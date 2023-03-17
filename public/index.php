<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Generic\App;
use App\Models\Generic\Config;
use App\Models\Generic\Router;

use App\Controllers\Auth\AuthController;
use App\Controllers\Chress\ChressController;

if(!isset($_SESSION)) session_start();

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../resources/views');
define('ASSET_PATH', __DIR__ . '/../resources/assets');
define('CSS_PATH', __DIR__ . '/../resources/css');
define('JS_PATH', __DIR__ . '/../resources/js');

$router = new Router();
$router->get('/', [AuthController::class, 'loginGet']);

$router->get('/login', [AuthController::class, 'loginGet']);
$router->post('/login', [AuthController::class, 'loginPost']);

$router->get('/register', [AuthController::class, 'registerGet']);
$router->post('/register', [AuthController::class, 'registerPost']);

$router->get('/validate', [AuthController::class, 'validateGet']);
$router->post('/validate', [AuthController::class, 'validatePost']);

$router->get('/profile', [AuthController::class, 'profileGet']);
$router->get('/logout', [AuthController::class, 'logoutGet']);

$router->get('/play', [ChressController::class, 'playGet']);
$router->post('/play/swap', [ChressController::class, 'playGetSwap']);
$router->post('/play/lastgame', [ChressController::class, 'playGetLastgame']);
$router->post('/play/nextgame', [ChressController::class, 'playGetNextgame']);

(new App(
  $router,
  ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
  new Config($_ENV)
))->run();