<?php

declare(strict_types=1);

namespace App\Models\Chress;

use App\Models\System\Config;
use App\Models\System\DB;

use PDO;

class UsersModel
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

  public function SearchUsers(string $search) : array
  {
    $searchString = '%' . $search . '%';
    $stmt = $this->db->pdo->prepare("SELECT uniqueIndex, user_alias
    FROM logins
    WHERE user_alias LIKE :searchString
    AND uniqueIndex != :userID
    ORDER BY user_alias DESC LIMIT 50");

    $stmt->bindParam(':searchString', $searchString);
    $stmt->bindParam(':userID', $this->userID);

    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result;
  }

  public function GetUser(int $user) : array
  {
    $stmt = $this->db->pdo->prepare("SELECT uniqueIndex, user_alias
    FROM logins
    WHERE uniqueIndex = :user");

    $stmt->bindParam(':user', $user);

    $stmt->execute();
    $result = $stmt->fetchAll();

    return $result[0];
  }
}