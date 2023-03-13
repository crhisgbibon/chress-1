<?php

use App\Models\Generic\App;
use App\Models\Generic\Config;
use App\Models\Generic\Router;

use App\Controllers\Home\HomeController;

require_once __DIR__ . '/../vendor/autoload.php';

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

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();