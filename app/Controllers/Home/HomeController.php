<?php

declare(strict_types=1);

namespace App\Controllers\Home;

// Generic - Models

use App\Models\Generic\AccountManager;
use App\Models\Generic\Config;
use App\Models\Generic\DB;
use App\Models\Generic\Debug;
use App\Models\Generic\Email;
use App\Models\Generic\View;

// Chress - Models

use App\Models\Chress\UpdateModel;
use App\Models\Chress\PlayModel;
use App\Models\Chress\ListModel;

use App\Models\Chress\LibraryModel;
use App\Models\Chress\PGNModel;

use App\Models\Chress\ChessRules;
use App\Models\Chress\GameModel;
use App\Models\Chress\GameMoves;
use App\Models\Chress\Square;

use App\Models\Chress\SaveTurn;
use App\Models\Chress\SaveSquare;

use App\Models\Chress\PiecePlaceTables;

class HomeController
{
  private AccountManager $accountManager;
  private Config $config;
  private DB $db;

  private HeaderView $header;

  private PlayModel $play;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);
    $this->accountManager = new AccountManager($this->db);
  }

  public function index() : View
  {
    $device = $this->accountManager->Device();
    $isLoggedIn = $this->accountManager->CheckCookie($device);

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
    {
      return View::make
      (
        'chress/play', // body view path
        'Chress',         // view title
        true,             // with layout
        [                 // controls array

        ],
        [                 // body params array

        ]
      );

      $pageTitle = 'Chess';
      $cssRoute = 'css/home/Main.css';
      $faviconRoute = 'favicon.ico';
      $header = View::make('generic/header', [
        'title' => $pageTitle,
        'css' => $cssRoute,
        'favicon' => $faviconRoute,
      ]);

      $buttons = ['Lobby', 'Play', 'Search'];

      $controls = View::make('generic/controls', [
        'buttons' => $buttons,
      ]);

      $footer = View::make('generic/footer', [

      ]);

      $model = new PlayModel($this->db, (int)$_SESSION['id']);
      $model->ScanGames();

      $lobbyGames = $model->GetLobbyGames();
      $lobbyLobby = $model->GetLobbyChallenges();
      $lobbyHistory = $model->GetLobbyHistory();

      $lobby = View::make('chress/lobby', [
        'games' => $lobbyGames,
        'lobby' => $lobbyLobby,
        'history' => $lobbyHistory,
      ]);

      $play = View::make('chress/play', [

      ]);

      $search = View::make('chress/search', [

      ]);

      echo <<<VIEW

      {$header}

      {$controls}

      {$lobby}

      {$play}

      {$search}

      {$footer}

      VIEW;

    }
    else
    {
      return View::make
      (
        'generic/splash', // body view path
        'Chress',         // view title
        true,             // with layout
        [                 // controls array

        ],
        [                 // body params array

        ]
      );
    }
  }
}