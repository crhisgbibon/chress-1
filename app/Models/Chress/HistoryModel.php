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

  public function __construct(DB $db, Config $config)
  {
    $this->db = $db;
    $this->config = $config;
  }
}