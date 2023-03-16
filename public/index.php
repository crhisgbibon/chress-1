<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Generic\App;
use App\Models\Generic\Config;
use App\Models\Generic\Router;

use App\Controllers\Home\HomeController;
use App\Controllers\Home\AuthController;

if(!isset($_SESSION)) session_start();

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../resources/views');
define('ASSET_PATH', __DIR__ . '/../resources/assets');
define('CSS_PATH', __DIR__ . '/../resources/css');
define('JS_PATH', __DIR__ . '/../resources/js');

$router = new Router();
$router->get('/', [HomeController::class, 'index']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/validate', [AuthController::class, 'validate']);
$router->post('/validate', [AuthController::class, 'authenticate']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();