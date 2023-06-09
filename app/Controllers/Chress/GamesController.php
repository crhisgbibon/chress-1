<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;
use App\Models\System\Component;

use App\Models\Auth\AuthModel;

use App\Models\Chress\GamesModel;

use App\Exceptions\GameNotFoundException;

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
        'layer' => './',
        'user' => $this->userID,
        'loggedin' => $loggedin,
        'games' => $games,
      ]
    );
  }

  #[Post(routePath:'/games/create')]
  public function newgame()
  {
    $data = json_decode($_POST['data']);
    $colour = $data->colour;
    $opponent = $data->opponent;
    $turn = $data->turn;

    $response = $this->model->NewGame($colour, $opponent, $turn);

    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $games = $this->model->CloseExpiredAndReturnActiveGames();

    return Component::make('games',['user'=>$this->userID,'games'=>$games]);
  }

  #[Get('/games/{id}')]
  public function id($params) : mixed
  {
    $gameid = (int)$params['id'];
    // return $gameid;
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    $game = $this->model->GetGame($gameid);
    // return $game;
    if(!$game)
    {
      return View::make
      (
        'error/gameNotFound',
        'Chress',
        true,
        [
          'layer' => '../',
        ]
      );
    }

    $game->clicked = -1;
    $data = $game->GetGameData($this->userID);
    if($game->lastMoved > 0 && $game->lastMoved < 64) $currentMoves = $game->board[$game->lastMoved]->moves;
    else $currentMoves = [];

    return View::make
    (
      'games/play',
      'Chress',
      true,
      [
        'layer' => '../',
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

  // #[Post('/games')]
  // public function view() : View
  // {
  //   $gameid = (int)$_POST['uuid'];
  //   if($this->userID === -1) $loggedin = false;
  //   else $loggedin = true;

  //   $game = $this->model->GetGame($gameid);
  //   $game->clicked = -1;
  //   $data = $game->GetGameData($this->userID);
  //   if($game->lastMoved > 0 && $game->lastMoved < 64) $currentMoves = $game->board[$game->lastMoved]->moves;
  //   else $currentMoves = [];

  //   return View::make
  //   (
  //     'games/play',
  //     'Chress',
  //     true,
  //     [
  //       'layer' => './',
  //       'user' => $this->userID,
  //       'loggedin' => $loggedin,
  //       'gameid' => $gameid,
  //       'board' => $data['board'],
  //       'moves' => $data['moves'],
  //       'state' => $data['state'],
  //       'score' => $data['score'],
  //       'meta' => $data['meta'],
  //       'pgn' => $data['pgn'],
  //       'lastmove' => $data['lastmove'],
  //       'iswhite' => $data['iswhite'],
  //       'currentmoves' => $currentMoves,
  //     ]
  //   );
  // }

  #[Post(routePath:'/games/lastmove')]
  public function lastmove() : string
  {
    // return json_encode('hello, lastmove');
    $post = json_decode($_POST['data']);
    $index = (int)$post[0];
    $game = $this->model->GetGame($index);
    $game->LoadState('LASTMOVE', $this->userID);
    $this->model->SaveGame($game);
    return json_encode($game->GetGameData($this->userID));
  }

  #[Post(routePath:'/games/nextmove')]
  public function nextmove() : string
  {
    // return json_encode('hello, nextmove');
    $post = json_decode($_POST['data']);
    $index = (int)$post[0];
    $game = $this->model->GetGame($index);
    $game->LoadState('NEXTMOVE', $this->userID);
    $this->model->SaveGame($game);
    return json_encode($game->GetGameData($this->userID));
  }

  #[Post(routePath:'/games/query')]
  public function query() : string
  {
    $post = json_decode($_POST['data']);
    $square = (int)$post[0];
    $index = (int)$post[1];
    $promote = (string)$post[2];
    // return json_encode($post);

    $game = $this->model->GetGame($index);
    // return json_encode($game);
  
    $validate = $this->model->ValidateTurn($index);
    // return json_encode($validate);

    if($validate)
    {
      $output = $game->Click($square, $this->userID, $promote);
      // return json_encode($output);

      $c = count($output);
      if($c >= 5) if($output[0] !== 'moves') $changeTurn = $this->model->UpdateTurn($index, $output[5]);
      $this->model->SaveGame($game);
    }

    return json_encode($game->GetGameData($this->userID));
  }

  #[Post('/games/resign')]
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
        'layer' => './',
        'loggedin' => $loggedin,
        'games' => $games,
      ]
    );
  }

  #[Post('/games/poll')]
  public function poll() : string
  {
    $post = json_decode($_POST['data']);
    // return json_encode($post);
    $index = (int)$post;
    // return json_encode($index);
    $game = $this->model->GetGame($index);
    return json_encode($game->GetGameData($this->userID));
  }

  #[Post('/games/skip')]
  public function skip() : string
  {
    $post = json_decode($_POST['data']);
    // return json_encode($post);
    $move = (int)$post[0];
    $index = (int)$post[1];
    // return json_encode($index);
    $game = $this->model->GetGame($index);
    // return json_encode($game);
    $game->LoadState($move, $this->userID);
    $this->model->SaveGame($game);
    return json_encode($game->GetGameData($this->userID));
  }
}