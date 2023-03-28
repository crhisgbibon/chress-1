<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use App\Models\System\DB;

class Logins
{
  private DB $db;

  public function __construct(DB $db)
  {
    $this->db = $db;
  }

  public function up()
  {
    try {
      $stmt = $this->db->pdo->prepare("CREATE TABLE IF NOT EXISTS `logins`(
        `uniqueIndex` INT (11) PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
        `user_alias` VARCHAR (50) NOT NULL,
        `user_password` VARCHAR(255) NOT NULL,
        `createdAt` DATETIME,
        `user_email` VARCHAR(255) NOT NULL UNIQUE,
        `user_theme` INT (11),
        `user_status` VARCHAR(100) NOT NULL,
        `activationCode` VARCHAR(255) NOT NULL,
        `activationExpiry` DATETIME,
        `isVerified` TINYINT(4) NOT NULL)");
      $stmt->execute();
      printf('Logins table created'."\n");
    }
    catch(PDOException $e)
    {
      printf('Unable to create Logins table'."\n");
    }
  }
}