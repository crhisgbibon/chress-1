<?php

declare(strict_types=1);

// Generic

require_once __DIR__ . '/../../models/generic/AccountManager.php';
require_once __DIR__ . '/../../models/generic/Config.php';
require_once __DIR__ . '/../../models/generic/DatabaseAccount.php';
require_once __DIR__ . '/../../models/generic/Debug.php';
require_once __DIR__ . '/../../models/generic/Email.php';

require_once __DIR__ . '/../../../resources/views/generic/AccountView.php';
require_once __DIR__ . '/../../../resources/views/generic/ControlsView.php';
require_once __DIR__ . '/../../../resources/views/generic/FooterView.php';
require_once __DIR__ . '/../../../resources/views/generic/HeaderView.php';
require_once __DIR__ . '/../../../resources/views/generic/SplashView.php';
require_once __DIR__ . '/../../../resources/views/generic/UserView.php';

// Models

require_once __DIR__ . '/../../models/chress/Database.php';
require_once __DIR__ . '/../../models/chress/UpdateModel.php';
require_once __DIR__ . '/../../models/chress/PlayModel.php';
require_once __DIR__ . '/../../models/chress/ListModel.php';

require_once __DIR__ . '/../../models/chress/LibraryModel.php';
require_once __DIR__ . '/../../models/chress/PGNModel.php';

// require_once __DIR__ . '/../../models/chress/ChessRules.php';
require_once __DIR__ . '/../../models/chress/GameModel.php';
// require_once __DIR__ . '/../../models/chress/GameMoves.php';
require_once __DIR__ . '/../../models/chress/Square.php';

require_once __DIR__ . '/../../models/chress/SaveTurn.php';
require_once __DIR__ . '/../../models/chress/SaveSquare.php';

// require_once __DIR__ . '/../../models/chress/PiecePlaceTables.php';

// Views

require_once __DIR__ . '/../../../resources/views/chress/LobbyView.php';
require_once __DIR__ . '/../../../resources/views/chress/PlayView.php';
require_once __DIR__ . '/../../../resources/views/chress/SearchView.php';

require_once __DIR__ . '/../../../resources/views/chress/LibraryView.php';
require_once __DIR__ . '/../../../resources/views/chress/PGNView.php';

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

  public function Index()
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