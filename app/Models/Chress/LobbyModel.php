<?php

declare(strict_types=1);

namespace App\Models\Chress;

use App\Models\System\Config;
use App\Models\System\DB;

use PDO;

class LobbyModel
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
    $stmt = $this->db->pdo->prepare("SELECT games.*, logins.user_alias
    FROM games
    INNER JOIN logins ON (games.whiteID = logins.uniqueIndex OR games.blackID = logins.uniqueIndex)
    WHERE gameCompleted=0
    AND ( whiteID!=:userID1 AND blackID!=:userID2 )
    AND ( whiteID=:lobby1 OR blackID=:lobby2 )
    AND hiddenRow=0");

    $lobby = -2;
    $stmt->bindParam(':userID1', $this->userID);
    $stmt->bindParam(':userID2', $this->userID);
    $stmt->bindParam(':lobby1', $lobby);
    $stmt->bindParam(':lobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }

  public function AcceptChallenge(int $gameID)
  {
    if($gameID === -1) return;

    $user = (int)$this->userID;
    $last = strtotime("now");

    $stmt = $this->db->pdo->prepare("UPDATE games
    SET `whiteID`=:user,
    `lastMoved`=:lastMoved
    WHERE uniqueIndex=:uniqueIndex
    AND whiteID = -2
    AND hiddenRow = 0");
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':lastMoved', $last);
    $stmt->bindParam(':uniqueIndex', $gameID);
    $stmt->execute();

    $stmt = $this->db->pdo->prepare("UPDATE games
    SET `blackID`=:user,
    `lastMoved`=:lastMoved
    WHERE uniqueIndex=:uniqueIndex
    AND blackID = -2
    AND hiddenRow = 0");
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':lastMoved', $last);
    $stmt->bindParam(':uniqueIndex', $gameID);
    $stmt->execute();

    $stmt = $this->db->pdo->prepare("SELECT boardState FROM games
    WHERE uniqueIndex=:uniqueIndex
    AND hiddenRow = 0");
    $stmt->bindParam(':uniqueIndex', $gameID);
    $stmt->execute();
    $game = unserialize($stmt->fetchColumn());
    $userID = (int)$this->userID;
    $game->AcceptChallenge($userID);

    $stmt = $this->db->pdo->prepare("UPDATE games
    SET `boardState`=:boardState
    WHERE uniqueIndex=:uniqueIndex
    AND hiddenRow = 0");
    $jsonState = serialize($game);
    $stmt->bindParam(':boardState', $jsonState);
    $stmt->bindParam(':uniqueIndex', $gameID);
    $stmt->execute();
  }
}