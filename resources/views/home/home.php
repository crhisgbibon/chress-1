<?php

declare(strict_types=1);

namespace App\Views\Home;

// Generic - Models

use App\models\generic\AccountManager;
use App\models\generic\Config;
use App\models\generic\DatabaseAccount;
use App\models\generic\Debug;
use App\models\generic\Email;

// Generic - Views

use Resources\views\generic\AccountView;
use Resources\views\generic\ControlsView;
use Resources\views\generic\FooterView;
use Resources\views\generic\HeaderView;
use Resources\views\generic\SplashView;
use Resources\views\generic\UserView;

// Chress - Models

use App\models\chress\Database;
use App\models\chress\UpdateModel;
use App\models\chress\PlayModel;
use App\models\chress\ListModel;

use App\models\chress\LibraryModel;
use App\models\chress\PGNModel;


use App\models\chress\ChessRules;
use App\models\chress\GameModel;
use App\models\chress\GameMoves;
use App\models\chress\Square;

use App\models\chress\SaveTurn;
use App\models\chress\SaveSquare;

use App\models\chress\PiecePlaceTables;

// Chress - Views

use Resources\views\chress\LobbyView;
use Resources\views\chress\PlayView;
use Resources\views\chress\SearchView;

use Resources\views\chress\LibraryView;
use Resources\views\chress\PGNView;

class HomeView
{

  // Generic - Models

  private AccountManager $accountManager;
  private Config $config;
  private DatabaseAccount $dbAccount;

  // Generic - Views

  private AccountView $account;
  private ControlsView $controls;
  private FooterView $footer;
  private HeaderView $header;
  private SplashView $splash;

  // Chress - Models

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

  // Chress - Views

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

    $this->header = new HeaderView();
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

  public function render()
  {
    $device = $this->accountManager->Device();
    $isLoggedIn = $this->accountManager->CheckCookie($device);

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true)
    {
      $header = $this->header->render('Chess', 'css/home/Main.css', 'favicon.ico');
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
      $header = $this->header->render('Splash', 'css/home/Main.css', 'favicon.ico');
      $splash = $this->splash->render();

      echo <<<VIEW

      {$header}

      {$splash}

      VIEW;
    }
  }
}