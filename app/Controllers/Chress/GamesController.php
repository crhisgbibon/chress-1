<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Attributes\Get;
use App\Attributes\Post;

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

  #[Get(routePath:'/games')]
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
        'user' => $this->userID,
        'loggedin' => $loggedin,
        'games' => $games,
      ]
    );
  }

  #[Post('/game')]
  public function view() : View
  {
    $gameid = (int)$_POST['uuid'];
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $game = $this->model->GetGame($gameid);
    $data = $game->GetGameData($this->userID);

    return View::make
    (
      'games/play',
      'Chress',
      true,
      [
        'user' => $this->userID,
        'loggedin' => $loggedin,
        'gameid' => $gameid,
        'board' => $data['board'],
        'moves' => $data['moves'],
        'state' => $data['state'],
        'score' => $data['score'],
        'meta' => $data['meta'],
        'pgn' => $data['pgn'],
        'lastmove' => $data['lastmove'],
        'iswhite' => $data['iswhite'],
      ]
    );
  }

  #[Post(routePath:'/game/lastmove')]
  public function lastmove() : string
  {
    return json_encode('hello, lastmove');
  }

  #[Post(routePath:'/game/nextmove')]
  public function nextmove() : string
  {
    return json_encode('hello, nextmove');
  }

  #[Post(routePath:'/game/query')]
  public function query() : string
  {
    // return json_encode('hello, test');

    $square = json_decode($_POST['data'])[0];

    // return json_encode(json_decode($_POST['data'])[0]);

    // need current game ID to get game and gamedata
  
    $validate = $model->ValidateTurn($index);
  
    if($validate === true)
    {
      $game = $model->GetGame($index);
      $moves = $game->GetMoves($_POST["data"][0], (int)$_SESSION["id"]);
      $model->SaveGame($game);
    
      echo json_encode($moves);
    }
    else
    {
      echo json_encode([]);
    }
  }

  #[Post('/game/resign')]
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