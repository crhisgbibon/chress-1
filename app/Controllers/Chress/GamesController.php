<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

use App\Models\Chress\GamesModel;

class GamesController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private GamesModel $model;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);

    $this->account = new AuthModel($this->db, $this->config);

    $this->model = new GamesModel($this->db, $this->config);
  }

  public function index() : View
  {
    return View::make
    (
      'games/games',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array

      ]
    );
  }

}