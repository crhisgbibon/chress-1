<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use App\Models\Generic\Config;
use App\Models\Generic\DB;

class CreateUserTable
{
  private Config $config;
  private DB $db;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);
  }

  public function up()
  {
    try {
      $stmt = $this->db->pdo->prepare("CREATE TABLE `users`(
        `id` INT (11) PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
        `username` VARCHAR (50) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `created_at` INT(11),
        `email` VARCHAR(255) NOT NULL,
        `user_status` VARCHAR(100) NOT NULL,
      )");
      $stmt->execute();
      echo "User table created.";
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  }
}