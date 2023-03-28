<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

use App\Models\Chress\LobbyModel;

class LobbyController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private LobbyModel $model;

  private int $userID;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);

    $this->account = new AuthModel($this->db, $this->config);

    $this->userID = (isset($_SESSION['id'])) ? $_SESSION['id'] : -1;

    $this->model = new LobbyModel($this->db, $this->config, $this->userID);
  }

  #[Get(routePath:'/lobby')]
  public function index() : View
  {
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $games = $this->model->CloseExpiredAndReturnActiveGames();

    return View::make
    (
      'lobby/lobby',
      'Chress',
      true,
      [
        'layer' => './',
        'loggedin' => $loggedin,
        'games' => $games,
      ]
    );
  }

  #[Post(routePath:'/lobby/accept')]
  public function accept() : View
  {
    if($_POST['uuid']) $gameid = (int)$_POST['uuid'];
    else $gameid = -1;

    $this->model->AcceptChallenge($gameid);
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;
    $games = $this->model->CloseExpiredAndReturnActiveGames();
    header('Location: /lobby');
  }
}