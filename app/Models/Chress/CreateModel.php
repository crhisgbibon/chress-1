<?php

declare(strict_types=1);

namespace App\Models\Chress;

use App\Models\System\Config;
use App\Models\System\DB;

use App\Models\Chress\GameModel;

use PDO;

class CreateModel
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

    if($colour === "white")
    {
      $whiteUser = $this->userID;
      if($opponent === "self") $blackUser = $this->userID;
      else if($opponent === "computer") $blackUser = -1;
      else if($opponent === "player") $blackUser = -2;
    }
    else if($colour === "black")
    {
      $blackUser = $this->userID;
      if($opponent === "self") $whiteUser = $this->userID;
      else if($opponent === "computer") $whiteUser = -1;
      else if($opponent === "player") $whiteUser = -2;
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
}