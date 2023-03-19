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

  private int $userID;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);

    $this->account = new AuthModel($this->db, $this->config);

    $this->userID = (isset($_SESSION['id'])) ? $_SESSION['id'] : -1;

    $this->model = new GamesModel($this->db, $this->config, $this->userID);
  }

  public function index() : View
  {
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $games = $this->model->CloseExpiredAndReturnActiveGames();

    return View::make
    (
      'games/games',
      'Chress',
      true,
      [
        'loggedin' => $loggedin,
        'games' => $games,
      ]
    );
  }

  public function view() : View
  {
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $games = $this->model->CloseExpiredAndReturnActiveGames();

    return View::make
    (
      'games/games',
      'Chress',
      true,
      [
        'loggedin' => $loggedin,
        'games' => $games,
      ]
    );
  }

  public function resign() : View
  {
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $games = $this->model->CloseExpiredAndReturnActiveGames();

    return View::make
    (
      'games/games',
      'Chress',
      true,
      [
        'loggedin' => $loggedin,
        'games' => $games,
      ]
    );
  }
}