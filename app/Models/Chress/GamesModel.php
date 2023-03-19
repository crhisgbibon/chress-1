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
    $stmt = $this->db->pdo->prepare("SELECT games.*, logins.user_alias
    FROM games
    INNER JOIN logins ON (games.whiteID = logins.uniqueIndex OR games.blackID = logins.uniqueIndex)
    WHERE gameCompleted=0
    AND ( whiteID=:userID1 OR blackID=:userID2 )
    AND ( whiteID!=:lobby1 AND blackID!=:lobby2 )
    AND hiddenRow=0
    ORDER BY games.lastMoved ASC");

    $lobby = -2;
    $stmt->bindParam(':userID1', $this->userID);
    $stmt->bindParam(':userID2', $this->userID);
    $stmt->bindParam(':lobby1', $lobby);
    $stmt->bindParam(':lobby2', $lobby);

    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }
}