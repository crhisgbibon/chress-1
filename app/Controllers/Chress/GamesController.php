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

  #[Post(routePath:'/games/create')]
  public function newgame()
  {
    if($this->userID === -1)
    {
      header('Location: /games');
    }

    $colour = $_POST['colour'];
    $opponent = $_POST['opponent'];
    $turn = $_POST['turn'];

    $response = $this->model->NewGame($colour, $opponent, $turn);

    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $games = $this->model->CloseExpiredAndReturnActiveGames();

    header('Location: /games');
  }

  #[Post('/game')]
  public function view() : View
  {
    $gameid = (int)$_POST['uuid'];
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $game = $this->model->GetGame($gameid);
    $data = $game->GetGameData($this->userID);
    if($game->lastMoved !== -1) $currentMoves = $game->board[$game->lastMoved]->moves;
    else $currentMoves = [];

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
        'currentmoves' => $currentMoves,
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
    $post = json_decode($_POST['data']);
    $square = (int)$post[0];
    $index = (int)$post[1];
    $promote = (string)$post[2];
  
    $validate = $this->model->ValidateTurn($index);

    // return json_encode($validate);

    $game = $this->model->GetGame($index);

    // return json_encode($game);
  
    if($validate)
    {
      $output = $game->Click($square, $this->userID, $promote);

      // return json_encode($output);

      $c = count($output);
      if($c >= 5)
      {
        if($output[0] !== 'moves')
        {
          $changeTurn = $this->model->UpdateTurn($index, $output[5]);
        }
      }
      $this->model->SaveGame($game);
    }

    return json_encode($game->GetGameData($this->userID));
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