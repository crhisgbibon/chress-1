<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Models\System\Config;
use App\Models\System\DB;

use PDO;

class ProfileModel
{
  private DB $db;
  private Config $config;

  public function __construct(DB $db, Config $config)
  {
    $this->db = $db;
    $this->config = $config;
  }

  public function ChangeTheme(int $newTheme, int $userID) : bool
  {
    try
    {
      $stmt = $this->db->pdo->prepare('UPDATE logins SET `user_theme`=:user_theme WHERE uniqueIndex=:uniqueIndex');
      $stmt->bindParam(':user_theme', $newTheme);
      $stmt->bindParam(':uniqueIndex', $userID);
      $stmt->execute();
      $_SESSION['theme'] = $newTheme;
      return true;
    }
    catch(Exception $e)
    {
      return false;
    }
  }
}