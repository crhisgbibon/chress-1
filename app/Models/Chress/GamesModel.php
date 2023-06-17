<?php

declare(strict_types=1);

namespace App\Models\Chress;

use App\Models\System\Config;
use App\Models\System\DB;

use PDO;

class GamesModel
{
  private DB $db;
  private Config $config;
  private int $userID;

  public function __construct(DB $db, Config $config, int $userID)
  {
    $this->db = $db;
    $this->config = $config;
    $this->userID = $userID;
  }

  public function CloseExpiredAndReturnActiveGames()
  {
    $games = $this->GetActiveGamesData();

    $c = count($games);

    $now = strtotime("now");

    $stmt1 = $this->db->pdo->prepare("UPDATE games
    SET `gameCompleted`=:complete,
    `gameResult`=:result
    WHERE uniqueIndex=:uniqueIndex");

    $complete = 1;
    $stmt1->bindParam(':complete', $complete);

    for($i = 0; $i < $c; $i++)
    {
      $timeSinceMoved = $now - (int)$games[$i]["lastMoved"];

      if($timeSinceMoved >= (int)$games[$i]["turnTime"])
      {
        if($games[$i]["gameTurn"] === 0) $stmt1->bindParam(':result', $games[$i]["blackID"]);
        else if($games[$i]["gameTurn"] === 1) $stmt1->bindParam(':result', $games[$i]["whiteID"]);
        $stmt1->bindParam(':uniqueIndex', $games[$i]["uniqueIndex"]);
        $stmt1->execute();
        unset($games[$i]);
      }
    }
    $games = array_filter($games);
    return $games;
  }

  public function GetActiveGamesData() : array
  {
    $stmt = $this->db->pdo->prepare("SELECT *
    FROM games
    WHERE gameCompleted=0
    AND ( whiteID=:userID1 OR blackID=:userID2 )
    AND ( whiteID!=:lobby1 AND blackID!=:lobby2 )
    OR ( whiteID=:computer1 OR blackID=:computer2 )
    AND hiddenRow=0
    ORDER BY ( UNIX_TIMESTAMP() - ( games.lastMoved + games.turnTime ) ) DESC");

    $computer = -1;
    $lobby = -2;
    $stmt->bindParam(':userID1', $this->userID);
    $stmt->bindParam(':userID2', $this->userID);
    $stmt->bindParam(':computer1', $computer);
    $stmt->bindParam(':computer2', $computer);
    $stmt->bindParam(':lobby1', $lobby);
    $stmt->bindParam(':lobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll();

    $getUserName = $this->db->pdo->prepare("SELECT user_alias
    FROM logins
    WHERE uniqueIndex=:uniqueIndex
    LIMIT 1");

    $c = count($result);
    for($i = 0; $i < $c; $i++)
    {
      $whiteID = $result[$i]['whiteID'];
      $blackID = $result[$i]['blackID'];

      $getUserName->bindParam(':uniqueIndex', $whiteID);
      $getUserName->execute();
      $info = $getUserName->fetchColumn();
      $result[$i]['white_username'] = $info;

      $getUserName->bindParam(':uniqueIndex', $blackID);
      $getUserName->execute();
      $info = $getUserName->fetchColumn();
      $result[$i]['black_username'] = $info;
    }

    return $result;
  }

  public function NewGame(string $colour, string $opponent, string $turn)
  {
    $stmt = $this->db->pdo->prepare("INSERT INTO games
    (whiteID,
    blackID,
    turnTime,
    lastMoved,
    gameTurn,
    gameCompleted,
    gameResult,
    boardState,
    hiddenRow)
    VALUES 
    (:white,
    :black,
    :turntime,
    :lastmoved,
    :turnstate,
    :completed,
    :result,
    :board,
    :hiddenRow)");

    if($colour === "random")
    {
      $pick = rand(1,10);
      if($pick < 5) $colour = "white";
      else $colour = "black";
    }

    // OPPONENT is either a string - self/AI/player - or it is an INT in string form which is the specific opponent a challenge is issued to
    if($colour === "white")
    {
      $whiteUser = $this->userID;
      if($opponent === "self") $blackUser = $this->userID;
      else if($opponent === "AI") $blackUser = -1;
      else if($opponent === "player") $blackUser = -2;
      else $blackUser = (int)$opponent;
    }
    else if($colour === "black")
    {
      $blackUser = $this->userID;
      if($opponent === "self") $whiteUser = $this->userID;
      else if($opponent === "AI") $whiteUser = -1;
      else if($opponent === "player") $whiteUser = -2;
      else $whiteUser = (int)$opponent;
    }
    else return -1;

    if($turn === "one") $turnTime = 86400;
    else if($turn === "three") $turnTime = 259200;
    else if($turn === "seven") $turnTime = 604800;
    else return -1;

    $stmt->bindParam(':white', $whiteUser);
    $stmt->bindParam(':black', $blackUser);
    $stmt->bindParam(':turntime', $turnTime);
    $last = strtotime("now");
    $stmt->bindParam(':lastmoved', $last);
    $turn = 0;
    $stmt->bindParam(':turnstate', $turn);
    $completed = 0;
    $stmt->bindParam(':completed', $completed);
    $result = -1;
    $stmt->bindParam(':result', $result);
    $board = "";
    $stmt->bindParam(':board', $board);
    $notHidden = 0;
    $stmt->bindParam(':hiddenRow', $notHidden);

    $stmt->execute();

    $gameInt = (int)$this->db->pdo->lastInsertId();

    if($whiteUser == $this->userID && $blackUser == $this->userID) $editable = true;
    else $editable = false;
    
    $now = strtotime("now");
    $whiteUser = (int)$whiteUser;
    $blackUser = (int)$blackUser;

    $game = new GameModel(
      $gameInt,
      true,
      false,
      false,
      0,
      $whiteUser,
      $blackUser,
      $now,
      $editable
    );

    $game->NewBoard();

    $stmt = $this->db->pdo->prepare("UPDATE games
    SET `boardState`=:board
    WHERE uniqueIndex=:uniqueIndex
    AND hiddenRow = 0");

    $jsonState = serialize($game);
    $stmt->bindParam(':board', $jsonState);
    $saveInt = (int)$gameInt;
    $stmt->bindParam(':uniqueIndex', $gameInt);

    $stmt->execute();

    return $saveInt;
  }

  public function GetGame(int $gameID) : GameModel|bool
  {
    $stmt = $this->db->pdo->prepare("SELECT boardState FROM games
    WHERE uniqueIndex=:uniqueIndex
    AND hiddenRow = 0");

    $stmt->bindParam(':uniqueIndex', $gameID);

    $stmt->execute();

    $gamedata = $stmt->fetchColumn();

    if(is_string($gamedata))
    {
      $game = unserialize($gamedata);
      return $game;
    }
    else
    {
      return false;
    }
  }

  public function ValidateTurn(int $gameID) : bool
  {
    $stmt = $this->db->pdo->prepare("SELECT whiteID, blackID, gameTurn FROM games
    WHERE uniqueIndex=:uniqueIndex
    AND hiddenRow = 0");

    $stmt->bindParam(':uniqueIndex', $gameID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(count($result) === 1)
    {
      $userID = $this->userID;

      if((int)$result[0]["whiteID"] === $userID && 
      (int)$result[0]["gameTurn"] === 0)
      {
        return true;
      }
      else if((int)$result[0]["blackID"] === $userID && 
      (int)$result[0]["gameTurn"] === 1)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

  public function SaveGame(GameModel $game)
  {
    $gameIndex = $game->GetIndex();

    $stmt = $this->db->pdo->prepare("UPDATE games
    SET `boardState`=:boardState
    WHERE uniqueIndex=:uniqueIndex
    AND hiddenRow = 0");

    $jsonState = serialize($game);
    $stmt->bindParam(':boardState', $jsonState);

    $stmt->bindParam(':uniqueIndex', $gameIndex);

    $stmt->execute();
  }

  public function UpdateTurn(int $gameID, string $gameState)
  {
    $stmt = $this->db->pdo->prepare("SELECT gameTurn, whiteID, blackID FROM games
    WHERE uniqueIndex=:uniqueIndex
    AND hiddenRow = 0");
    $stmt->bindParam(':uniqueIndex', $gameID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) === 1)
    {
      $turn = (int)$result[0]["gameTurn"];

      $newTurn = 0;

      if($turn === 0)
      {
        $newTurn = 1;
      }
      else if($turn === 1)
      {
        $newTurn = 0;
      }
      else
      {
        return false;
      }

      $stmt = $this->db->pdo->prepare("UPDATE games
      SET `gameTurn`=:gameTurn,
      `lastMoved`=:lastMoved
      WHERE uniqueIndex=:uniqueIndex
      AND hiddenRow = 0");

      $stmt->bindParam(':gameTurn', $newTurn);
      $now = strtotime("now");
      $stmt->bindParam(':lastMoved', $now);
      $stmt->bindParam(':uniqueIndex', $gameID);

      $stmt->execute();

      if($gameState !== "" && $gameState !== "CHECKWHITE" && $gameState !== "CHECKBLACK")
      {
        $stmt = $this->db->pdo->prepare("UPDATE games
        SET `gameCompleted`=1,
        `gameResult`=:gameResult
        WHERE uniqueIndex=:uniqueIndex
        AND hiddenRow = 0");

        if($gameState === "CHECKMATEWHITE")
        {
          $stmt->bindParam(':uniqueIndex', $gameID);
          $stmt->bindParam(':gameResult', $result[0]["blackID"]);
          $stmt->execute();
        }
        if($gameState === "CHECKMATEBLACK")
        {
          $stmt->bindParam(':uniqueIndex', $gameID);
          $stmt->bindParam(':gameResult', $result[0]["whiteID"]);
          $stmt->execute();
        }
        else if($gameState === "DRAW50" || $gameState === "DRAWMATERIAL" ||
        $gameState === "DRAWSTALEMATE" || $gameState === "DRAWTHREE")
        {
          $stmt->bindParam(':uniqueIndex', $gameID);
          $draw = -2;
          $stmt->bindParam(':gameResult', $draw);
          $stmt->execute();
        }
      }

      return true;
    }
    else
    {
      return false;
    }
  }
}