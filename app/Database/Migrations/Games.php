<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use App\Models\System\DB;

class Games
{
  private DB $db;

  public function __construct(DB $db)
  {
    $this->db = $db;
  }

  public function up()
  {
    try {
      $stmt = $this->db->pdo->prepare("CREATE TABLE IF NOT EXISTS `games`(
        `uniqueIndex` INT (11) PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
        `whiteID` INT (11),
        `blackID` INT (11),
        `turnTime` INT (11),
        `lastMoved` INT (11),
        `gameTurn` TINYINT (4),
        `gameCompleted` TINYINT (4),
        `gameResult` INT (11),
        `boardState` LONGTEXT,
        `hiddenRow` TINYINT (4) )");
      $stmt->execute();
      printf('Games table created'."\n");
    }
    catch(PDOException $e)
    {
      printf('Unable to create Games table'."\n");
    }
  }
}