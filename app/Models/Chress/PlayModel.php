<?php

declare(strict_types=1);

namespace App\Models\Chress;

class PlayModel
{

  private Database $db;
  private int $userID;

  public function __construct(Database $db, int $userID)
  {

    $this->db = $db;
    $this->userID = $userID;

  }

  public function ScanGames() // checks all games the player is involved with and ensures none have expired on time
  {
    $user = (int)$this->userID;
    $lobby = -2;

    $stmt = $this->db->conn->prepare("SELECT uniqueIndex,
    whiteID,
    blackID,
    turnTime,
    lastMoved,
    gameTurn,
    gameCompleted,
    gameResult
    FROM chess_games
    WHERE gameCompleted='0'
    AND ( whiteID =:qWhite OR blackID=:qBlack )
    AND ( whiteID !=:qLobby1 AND blackID!=:qLobby2 )
    AND hiddenRow='0'
    ORDER BY uniqueIndex");

    $stmt->bindParam(':qWhite', $user);
    $stmt->bindParam(':qBlack', $user);

    $stmt->bindParam(':qLobby1', $lobby);
    $stmt->bindParam(':qLobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $c = count($result);

    $now = strtotime("now");

    $stmt1 = $this->db->conn->prepare("UPDATE chess_games
    SET `gameCompleted`=:qComplete,
    `gameResult`=:qResult
    WHERE uniqueIndex=:qIndex");

    $complete = 1;
    $stmt1->bindParam(':qComplete', $complete);

    for($i = 0; $i < $c; $i++)
    {
      $timeSinceMoved = $now - (int)$result[$i]["lastMoved"];

      if($timeSinceMoved >= (int)$result[$i]["turnTime"])
      {
        if($result[$i]["gameTurn"] === 0)
        {
          $stmt1->bindParam(':qResult', $result[$i]["blackID"]);
        }
        else if($result[$i]["gameTurn"] === 1)
        {
          $stmt1->bindParam(':qResult', $result[$i]["whiteID"]);
        }
        $stmt1->bindParam(':qIndex', $result[$i]["uniqueIndex"]);
        $stmt1->execute();
      }
    }
  }

  public function GetLobbyGames() : array
  {
    $user = (int)$this->userID;
    $lobby = -2;

    $stmt = $this->db->conn->prepare("SELECT uniqueIndex,
    whiteID,
    blackID,
    turnTime,
    lastMoved,
    gameTurn,
    gameCompleted,
    gameResult
    FROM chess_games
    WHERE gameCompleted='0'
    AND ( whiteID =:qWhite OR blackID=:qBlack )
    AND ( whiteID !=:qLobby1 AND blackID!=:qLobby2 )
    AND hiddenRow='0'
    ORDER BY uniqueIndex");

    $stmt->bindParam(':qWhite', $user);
    $stmt->bindParam(':qBlack', $user);

    $stmt->bindParam(':qLobby1', $lobby);
    $stmt->bindParam(':qLobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $c = count($result);

    for($i = 0; $i < $c; $i++)
    {
      if($result[$i]["whiteID"] !== -1)
      {
        $stmt1 = $this->db->conn->prepare("SELECT 
        user_alias
        FROM crhisgbi_generic.logins
        WHERE uniqueIndex=:qUser");

        $stmt1->bindParam(':qUser', $result[$i]["whiteID"]);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $result[$i]["whiteUser"] = $result1[0]["user_alias"];
      }
      else if($result[$i]["whiteID"] === -1)
      {
        $result[$i]["whiteUser"] = "Computer";
      }

      if($result[$i]["blackID"] !== -1)
      {
        $stmt1 = $this->db->conn->prepare("SELECT 
        user_alias
        FROM crhisgbi_generic.logins
        WHERE uniqueIndex=:qUser");

        $stmt1->bindParam(':qUser', $result[$i]["blackID"]);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $result[$i]["blackUser"] = $result1[0]["user_alias"];
      }
      else if($result[$i]["blackID"] === -1)
      {
        $result[$i]["blackUser"] = "Computer";
      }
    }

    return $result;
  }

  public function GetLobbyChallenges() : array
  {
    $lobby = -2;

    $stmt = $this->db->conn->prepare("SELECT crhisgbi_crhisgbibon.chess_games.uniqueIndex,
    whiteID,
    blackID,
    turnTime,
    lastMoved,
    gameTurn,
    gameCompleted,
    gameResult
    FROM crhisgbi_crhisgbibon.chess_games
    WHERE gameCompleted='0'
    AND ( whiteID =:qLobby1 OR blackID=:qLobby2 )
    AND hiddenRow='0'
    ORDER BY uniqueIndex");

    $stmt->bindParam(':qLobby1', $lobby);
    $stmt->bindParam(':qLobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $c = count($result);

    for($i = 0; $i < $c; $i++)
    {
      if($result[$i]["whiteID"] !== -2)
      {
        $stmt1 = $this->db->conn->prepare("SELECT 
        user_alias
        FROM crhisgbi_generic.logins
        WHERE uniqueIndex=:qUser");

        $stmt1->bindParam(':qUser', $result[$i]["whiteID"]);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $result[$i]["whiteUser"] = $result1[0]["user_alias"];
      }
      else
      {
        $result[$i]["whiteUser"] = "?";
      }

      if($result[$i]["blackID"] !== -2)
      {
        $stmt1 = $this->db->conn->prepare("SELECT 
        user_alias
        FROM crhisgbi_generic.logins
        WHERE uniqueIndex=:qUser");

        $stmt1->bindParam(':qUser', $result[$i]["blackID"]);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $result[$i]["blackUser"] = $result1[0]["user_alias"];
      }
      else
      {
        $result[$i]["blackUser"] = "?";
      }
    }

    return $result;
  }

  public function GetLobbyHistory() : array
  {
    $user = (int)$this->userID;
    $lobby = -2;

    $stmt = $this->db->conn->prepare("SELECT uniqueIndex,
    whiteID,
    blackID,
    turnTime,
    lastMoved,
    gameTurn,
    gameCompleted,
    gameResult
    FROM chess_games
    WHERE gameCompleted='1'
    AND ( whiteID =:qWhite OR blackID=:qBlack )
    AND ( whiteID !=:qLobby1 AND blackID!=:qLobby2 )
    AND hiddenRow='0'
    ORDER BY uniqueIndex");

    $stmt->bindParam(':qWhite', $user);
    $stmt->bindParam(':qBlack', $user);

    $stmt->bindParam(':qLobby1', $lobby);
    $stmt->bindParam(':qLobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $c = count($result);

    for($i = 0; $i < $c; $i++)
    {
      if($result[$i]["whiteID"] !== -1)
      {
        $stmt1 = $this->db->conn->prepare("SELECT 
        user_alias
        FROM crhisgbi_generic.logins
        WHERE uniqueIndex=:qUser");

        $stmt1->bindParam(':qUser', $result[$i]["whiteID"]);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $result[$i]["whiteUser"] = $result1[0]["user_alias"];
      }
      else if($result[$i]["whiteID"] === -1)
      {
        $result[$i]["whiteUser"] = "Computer";
      }

      if($result[$i]["blackID"] !== -1)
      {
        $stmt1 = $this->db->conn->prepare("SELECT 
        user_alias
        FROM crhisgbi_generic.logins
        WHERE uniqueIndex=:qUser");

        $stmt1->bindParam(':qUser', $result[$i]["blackID"]);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $result[$i]["blackUser"] = $result1[0]["user_alias"];
      }
      else if($result[$i]["blackID"] === -1)
      {
        $result[$i]["blackUser"] = "Computer";
      }
    }

    return $result;
  }

  public function GetActiveGames() : array
  {
    $stmt = $this->db->conn->prepare("SELECT uniqueIndex
    FROM chess_games
    WHERE gameCompleted='0'
    AND ( whiteID =:qWhite OR blackID=:qBlack )
    AND ( whiteID !=:qLobby1 AND blackID!=:qLobby2 )
    AND hiddenRow='0'");

    $user = (int)$this->userID;
    $lobby = -2;

    $stmt->bindParam(':qWhite', $user);
    $stmt->bindParam(':qBlack', $user);

    $stmt->bindParam(':qLobby1', $lobby);
    $stmt->bindParam(':qLobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }

  function AcceptChallenge(int $gameID)
  {
    $user = (int)$this->userID;
    $last = strtotime("now");

    $stmt = $this->db->conn->prepare("UPDATE chess_games
    SET `whiteID`=:qUser,
    `lastMoved`=:qLast
    WHERE uniqueIndex=:qIndex
    AND whiteID = -2
    AND hiddenRow = 0");
    $stmt->bindParam(':qUser', $user);
    $stmt->bindParam(':qLast', $last);
    $stmt->bindParam(':qIndex', $gameID);
    $stmt->execute();

    $stmt = $this->db->conn->prepare("UPDATE chess_games
    SET `blackID`=:qUser,
    `lastMoved`=:qLast
    WHERE uniqueIndex=:qIndex
    AND blackID = -2
    AND hiddenRow = 0");
    $stmt->bindParam(':qUser', $user);
    $stmt->bindParam(':qLast', $last);
    $stmt->bindParam(':qIndex', $gameID);
    $stmt->execute();

    $stmt = $this->db->conn->prepare("SELECT boardState FROM chess_games
    WHERE uniqueIndex=:qIndex
    AND hiddenRow = 0");
    $stmt->bindParam(':qIndex', $gameID);
    $stmt->execute();
    $game = unserialize($stmt->fetchColumn());
    $userID = (int)$this->userID;
    $game->AcceptChallenge($userID);

    $stmt = $this->db->conn->prepare("UPDATE chess_games
    SET `boardState`=:qState
    WHERE uniqueIndex=:qIndex
    AND hiddenRow = 0");
    $jsonState = serialize($game);
    $stmt->bindParam(':qState', $jsonState);
    $stmt->bindParam(':qIndex', $gameID);
    $stmt->execute();
  }

  function ResignGame(int $gameID)
  {
    $user = (int)$this->userID;
    $last = strtotime("now");

    $stmt = $this->db->conn->prepare("SELECT whiteID, blackID FROM chess_games
    WHERE uniqueIndex=:qIndex");
    $stmt->bindParam(':qIndex', $gameID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) !== 1) return;

    $stmt = $this->db->conn->prepare("UPDATE chess_games
    SET `gameResult`=:qResult,
    `lastMoved`=:qLast,
    `gameCompleted`=1
    WHERE uniqueIndex=:qIndex
    AND whiteID = :qWhite
    AND hiddenRow = 0");
    $blackID = $result[0]["blackID"];
    $stmt->bindParam(':qResult', $blackID);
    $stmt->bindParam(':qLast', $last);
    $stmt->bindParam(':qIndex', $gameID);
    $stmt->bindParam(':qWhite', $user);
    $stmt->execute();

    $stmt = $this->db->conn->prepare("UPDATE chess_games
    SET `gameResult`=:qResult,
    `lastMoved`=:qLast,
    `gameCompleted`=1
    WHERE uniqueIndex=:qIndex
    AND blackID = :qBlack
    AND hiddenRow = 0");
    $whiteID = $result[0]["whiteID"];
    $stmt->bindParam(':qResult', $whiteID);
    $stmt->bindParam(':qLast', $last);
    $stmt->bindParam(':qIndex', $gameID);
    $stmt->bindParam(':qBlack', $user);
    $stmt->execute();
  }

  function ValidateTurn(int $gameID) : bool
  {
    $stmt = $this->db->conn->prepare("SELECT whiteID, blackID, gameTurn FROM chess_games
    WHERE uniqueIndex=:qIndex
    AND hiddenRow = 0");

    $stmt->bindParam(':qIndex', $gameID);
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

  public function UpdateTurn(int $gameID, string $gameState)
  {
    $stmt = $this->db->conn->prepare("SELECT gameTurn, whiteID, blackID FROM chess_games
    WHERE uniqueIndex=:qIndex
    AND hiddenRow = 0");
    $stmt->bindParam(':qIndex', $gameID);
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

      $stmt = $this->db->conn->prepare("UPDATE chess_games
      SET `gameTurn`=:qTurn,
      `lastMoved`=:qDate
      WHERE uniqueIndex=:qIndex
      AND hiddenRow = 0");

      $stmt->bindParam(':qTurn', $newTurn);
      $now = strtotime("now");
      $stmt->bindParam(':qDate', $now);
      $stmt->bindParam(':qIndex', $gameID);

      $stmt->execute();

      if($gameState !== "" && $gameState !== "CHECKWHITE" && $gameState !== "CHECKBLACK")
      {
        $stmt = $this->db->conn->prepare("UPDATE chess_games
        SET `gameCompleted`=1,
        `gameResult`=:qResult
        WHERE uniqueIndex=:qIndex
        AND hiddenRow = 0");

        if($gameState === "CHECKMATEWHITE")
        {
          $stmt->bindParam(':qIndex', $gameID);
          $stmt->bindParam(':qResult', $result[0]["blackID"]);
          $stmt->execute();
        }
        if($gameState === "CHECKMATEBLACK")
        {
          $stmt->bindParam(':qIndex', $gameID);
          $stmt->bindParam(':qResult', $result[0]["whiteID"]);
          $stmt->execute();
        }
        else if($gameState === "DRAW50" || $gameState === "DRAWMATERIAL" ||
        $gameState === "DRAWSTALEMATE" || $gameState === "DRAWTHREE")
        {
          $stmt->bindParam(':qIndex', $gameID);
          $draw = -2;
          $stmt->bindParam(':qResult', $draw);
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

  public function GetGame(int $gameID) : GameModel
  {
    $stmt = $this->db->conn->prepare("SELECT boardState FROM chess_games
    WHERE uniqueIndex=:qIndex
    AND hiddenRow = 0");

    $stmt->bindParam(':qIndex', $gameID);

    $stmt->execute();

    $game = unserialize($stmt->fetchColumn());

    return $game;
  }

  public function NewGame(array $data) : int
  {
    if(count($data) !== 3) return -1;

    $colour = (string)$_POST["data"][0];
    $opponent = (string)$_POST["data"][1];
    $time = (string)$_POST["data"][2];

    $stmt = $this->db->conn->prepare("INSERT INTO chess_games
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
    (:qWhite,
    :qBlack,
    :qTime,
    :qLast,
    :qTurn,
    :qCompleted,
    :qResult,
    :qState,
    :qHidden)");

    if($colour === "Random")
    {
      $pick = rand(1,10);

      if($pick < 5)
      {
        $colour = "White";
      }
      else
      {
        $colour = "Black";
      }
    }

    if($colour === "White")
    {
      $whiteUser = $this->userID;

      if($opponent === "Self")
      {
        $blackUser = $this->userID;
      }
      else if($opponent === "Computer")
      {
        $blackUser = -1;
      }
      else if($opponent === "Player")
      {
        $blackUser = -2;
      }
    }
    else if($colour === "Black")
    {
      $blackUser = $this->userID;

      if($opponent === "Self")
      {
        $whiteUser = $this->userID;
      }
      else if($opponent === "Computer")
      {
        $whiteUser = -1;
      }
      else if($opponent === "Player")
      {
        $whiteUser = -2;
      }
    }
    else
    {
      return -1;
    }

    if($time === "One")
    {
      $turnTime = 86400;
    }
    else if($time === "Three")
    {
      $turnTime = 259200;
    }
    else if($time === "Seven")
    {
      $turnTime = 604800;
    }
    else
    {
      return -1;
    }

    $stmt->bindParam(':qWhite', $whiteUser);

    $stmt->bindParam(':qBlack', $blackUser);

    $stmt->bindParam(':qTime', $turnTime);

    if($opponent === "Player")
    {
      $last = 0;
    }
    else
    {
      $last = strtotime("now");
    }
    $stmt->bindParam(':qLast', $last);

    $turn = 0;
    $stmt->bindParam(':qTurn', $turn);

    $completed = 0;
    $stmt->bindParam(':qCompleted', $completed);

    $result = -1;
    $stmt->bindParam(':qResult', $result);

    $state = "";
    $stmt->bindParam(':qState', $state);

    $notHidden = 0;
    $stmt->bindParam(':qHidden', $notHidden);

    $stmt->execute();

    $gameInt = (int)$this->db->conn->lastInsertId();

    if($whiteUser == $this->userID && $blackUser == $this->userID)
    {
      $editable = true;
    }
    else
    {
      $editable = false;
    }
    
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

    $stmt = $this->db->conn->prepare("UPDATE chess_games
    SET `boardState`=:qBoard
    WHERE uniqueIndex=:qIndex
    AND hiddenRow = 0");

    $jsonState = serialize($game);
    $stmt->bindParam(':qBoard', $jsonState);

    $saveInt = (int)$gameInt;
    $stmt->bindParam(':qIndex', $gameInt);

    $stmt->execute();

    return $saveInt;
  }

  public function SaveGame(GameModel $game)
  {
    $gameIndex = $game->GetIndex();

    $stmt = $this->db->conn->prepare("UPDATE chess_games
    SET `boardState`=:qBoard
    WHERE uniqueIndex=:qIndex
    AND hiddenRow = 0");

    $jsonState = serialize($game);
    $stmt->bindParam(':qBoard', $jsonState);

    $stmt->bindParam(':qIndex', $gameIndex);

    $stmt->execute();
  }

}