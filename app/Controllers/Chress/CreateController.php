<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\Auth\AuthModel;

use App\Models\Chress\CreateModel;

class CreateController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private CreateModel $model;

  private int $userID;


  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);

    $this->account = new AuthModel($this->db, $this->config);

    $this->userID = (isset($_SESSION['id'])) ? $_SESSION['id'] : -1;

    $this->model = new CreateModel($this->db, $this->config, $this->userID);
  }

  #[Get(routePath:'/create')]
  public function index() : View
  {
    if($this->userID === -1) $loggedin = false;
    else $loggedin = true;

    return View::make
    (
      'create/create',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'loggedin' => false,
      ]
    );
  }

  #[Post(routePath:'/create')]
  public function newgame() : View
  {
    if($this->userID === -1)
    {
      return View::make
      (
        'create/create',
        'Chress',
        true,
        [
          'loggedin' => false,
        ]
      );
    }

    $colour = $_POST['colour'];
    $opponent = $_POST['opponent'];
    $turn = $_POST['turn'];

    $response = $this->model->NewGame($colour, $opponent, $turn);

    $games = $this->model->GetActiveGamesIndexes();
    $c = count($games);

    return View::make
    (
      'lobby/lobby',
      'Chress',
      true,
      [
        'loggedin' => false,
        'games' => $games,
      ]
    );

    return json_encode($response);

    $_SESSION["PGN"] = false;

    $games = $model->GetActiveGamesIndexes();
    $c = count($games);

    if($c > 0)
    {
      $_SESSION["games"] = serialize($games);
      $_SESSION["currentGame"] = $c-1;
      $_SESSION["totalGames"] = $c;

      $games = unserialize($_SESSION["games"]);
      $index = $games[(int)$_SESSION["currentGame"]]["uniqueIndex"];

      $game = $model->GetGame($index);
      $gameData = $game->GetGameData((int)$_SESSION["id"]);
      $output[0] = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];

      $model->ScanGames();
      $lobbyGames = $model->GetLobbyGames();
      $lobby = new LobbyView((int)$_SESSION["id"]);

      $viewGames = $lobby->PrintGames($lobbyGames);
      $viewLobby = $lobby->PrintLobby($lobbyLobby);
      $viewHistory = $lobby->PrintHistory($lobbyHistory);

      $output[1] = [$viewGames, $viewLobby, $viewHistory];

      echo json_encode($output);
    }
    else
    {
      $output = [ [0, 0, [], $_SESSION["PGN"]], []];
    
      echo json_encode($output);
    }
  }
}