<?php

declare(strict_types=1);

namespace App\Models\Chress;

use App\Models\System\Config;
use App\Models\System\DB;

use PDO;

class HistoryModel
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

  public function GetClosedGames() : array
  {
    $stmt = $this->db->pdo->prepare("SELECT *
    FROM games
    WHERE gameCompleted=1
    AND ( whiteID=:userID1 OR blackID=:userID2 )
    AND hiddenRow=0
    ORDER BY games.lastMoved ASC");

    $stmt->bindParam(':userID1', $this->userID);
    $stmt->bindParam(':userID2', $this->userID);

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
}