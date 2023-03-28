<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

use App\Models\Chress\HistoryModel;

class HistoryController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private HistoryModel $model;

  private int $userID;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);

    $this->account = new AuthModel($this->db, $this->config);

    $this->userID = (isset($_SESSION['id'])) ? $_SESSION['id'] : -1;

    $this->model = new HistoryModel($this->db, $this->config, $this->userID);
  }

  #[Get(routePath:'/history')]
  public function index() : View
  {
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $games = $this->model->GetClosedGames();

    return View::make
    (
      'history/history',
      'Chress',
      true,
      [
        'layer' => './',
        'user' => $this->userID,
        'loggedin' => $loggedin,
        'games' => $games,
      ]
    );
  }
}