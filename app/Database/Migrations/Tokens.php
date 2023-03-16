<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use App\Models\Generic\DB;

class Tokens
{
  private DB $db;

  public function __construct(DB $db)
  {
    $this->db = $db;
  }

  public function up()
  {
    try
    {
      $result = $this->db->pdo->query("SELECT 1 FROM `logins` LIMIT 1");
    }
    catch(Exception $e)
    {
      $result = false;
    }

    if($result === false)
    {
      try {
        $stmt = $this->db->pdo->prepare("CREATE TABLE `tokens`(
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
    else
    {
      printf('Tokens table already exists'."\n");
    }
  }
}