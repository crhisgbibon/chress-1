<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use App\Models\System\DB;

class Tokens
{
  private DB $db;

  public function __construct(DB $db)
  {
    $this->db = $db;
  }

  public function up()
  {
    try {
      $stmt = $this->db->pdo->prepare("CREATE TABLE IF NOT EXISTS `tokens`(
        `uniqueIndex` INT (11) PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
        `user_alias` VARCHAR (255) NOT NULL,
        `deviceID` VARCHAR(255) NOT NULL,
        `passwordHash` VARCHAR(255) NOT NULL,
        `selectorHash` VARCHAR(255) NOT NULL,
        `isExpired` INT (11) NOT NULL,
        `expiryDate` VARCHAR(45) NOT NULL)");
      $stmt->execute();
      printf('Tokens table created'."\n");
    }
    catch(PDOException $e)
    {
      printf('Unable to create Tokens table'."\n");
    }
  }
}