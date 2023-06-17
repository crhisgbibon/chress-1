<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\System\Config;
use App\Models\System\Component;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

use App\Models\Chress\UsersModel;
use App\Models\Chress\GamesModel;

class UsersController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private UsersModel $model;
  private GamesModel $gameModel;

  private int $userID;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);

    $this->account = new AuthModel($this->db, $this->config);

    $this->userID = (isset($_SESSION['id'])) ? $_SESSION['id'] : -1;

    $this->model = new UsersModel($this->db, $this->config, $this->userID);
    $this->gameModel = new GamesModel($this->db, $this->config, $this->userID);
  }

  #[Get(routePath:'/users')]
  public function index() : View
  {
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $search = '';
    $users = [];

    return View::make
    (
      'users/users',
      'Chress',
      true,
      [
        'layer' => './',
        'loggedin' => $loggedin,
        'users' => $users,
        'search' => $search,
      ]
    );
  }

  #[Post(routePath:'/users/search')]
  public function search()
  {
    $data = json_decode($_POST['data']);
    $search = $data->search;

    $users = $this->model->SearchUsers($search);

    return Component::make('users',['users'=>$users]);
  }

  #[Get('/users/{id}')]
  public function id($params) : mixed
  {
    $userid = (int)$params['id'];
    // return $gameid;
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $user = $this->model->GetUser($userid);
    // return $game;
    if(!$user)
    {
      return View::make
      (
        'error/userNotFound',
        'Chress',
        true,
        [
          'layer' => '../',
        ]
      );
    }

    return View::make
    (
      'users/user',
      'Chress',
      true,
      [
        'layer' => '../',
        'loggedin' => $loggedin,
        'user' => $user
      ]
    );
  }

  #[Post(routePath:'/users/challenge')]
  public function challenge() : mixed
  {
    $turn = $_POST['turn'];
    $colour = $_POST['colour'];
    $opponent = $_POST['opponent'];

    $response = $this->gameModel->NewGame($colour, $opponent, $turn);

    return header('Location: /users');
  }
}