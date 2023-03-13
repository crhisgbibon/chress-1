<?php

declare(strict_types=1);

namespace App\Controllers\Home;

// Generic - Models

use App\Models\Generic\AccountManager;
use App\Models\Generic\Config;
use App\Models\Generic\DatabaseAccount;
use App\Models\Generic\Debug;
use App\Models\Generic\Email;

// Generic - Views

use App\Views\Generic\AccountView;
use App\Views\Generic\ControlsView;
use App\Views\Generic\FooterView;
use App\Views\Generic\HeaderView;
use App\Views\Generic\SplashView;
use App\Views\Generic\UserView;

// Chress - Models

use App\Models\Chress\Database;
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

// Chress - Views

use App\Views\Chress\LobbyView;
use App\Views\Chress\PlayView;
use App\Views\Chress\SearchView;

use App\Views\Chress\LibraryView;
use App\Views\Chress\PGNView;

class HomeController
{
  // Generic

  private AccountManager $accountManager;
  private Config $config;
  private DatabaseAccount $dbAccount;

  private AccountView $account;
  private ControlsView $controls;
  private FooterView $footer;
  private HeaderView $header;
  private SplashView $splash;

  // Chress

  private Database $database;
  private UpdateModel $update;
  private PlayModel $play;
  private ListModel $list;

  private LibraryModel $library;
  private PGNModel $pgn;

  private GameModel $game;
  private Square $square;

  private SaveTurn $saveTurn;
  private SaveSquare $saveSquare;

  private LobbyView $lobbyView;
  private PlayView $playView;
  private SearchView $searchView;

  private LibraryView $librayView;
  private PGNView $pgnView;

  public function __construct()
  {
    // Generic

    $this->config = new Config();
    $this->dbAccount = new DatabaseAccount($this->config);
    $this->accountManager = new AccountManager($this->dbAccount);

    $this->controls = new ControlsView();
    $this->account = new AccountView();
    $this->footer = new FooterView();
    $this->splash = new SplashView();

    // Chress - Models

    $this->database = new Database($this->config);

    // Chress - Views

    $this->playView = new PlayView();
    $this->searchView = new SearchView();

    $this->librayView = new LibraryView();
    $this->pgnView = new PGNView();
  }

  public function index()
  {
    $device = $this->accountManager->Device();
    $isLoggedIn = $this->accountManager->CheckCookie($device);

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
    {
      $pageTitle = 'Chess';
      $cssRoute = 'css/home/Main.css';
      $faviconRoute = 'favicon.ico';
      $header = new HeaderView($pageTitle, $cssRoute, $faviconRoute);
      
      $controls = $this->controls->render(['Lobby', 'Play', 'Search']);
      $footer = $this->footer->render();

      $model = new PlayModel($this->database, (int)$_SESSION['id']);
      $model->ScanGames();

      $lobbyGames = $model->GetLobbyGames();
      $lobbyLobby = $model->GetLobbyChallenges();
      $lobbyHistory = $model->GetLobbyHistory();
      $lobbyView = new LobbyView((int)$_SESSION['id']);
      $lobby = $lobbyView->render($lobbyGames, $lobbyLobby, $lobbyHistory);

      $play = $this->playView->render();
      $search = $this->searchView->render();

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
      $pageTitle = 'Splash';
      $cssRoute = 'css/home/Main.css';
      $faviconRoute = 'favicon.ico';
      $header = new HeaderView($pageTitle, $cssRoute, $faviconRoute);
      $splash = $this->splash->render();

      echo <<<VIEW

      {$header}

      {$splash}

      VIEW;
    }
  }
}