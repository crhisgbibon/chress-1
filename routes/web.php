<?php

use App\Models\System\Router;

use App\Controllers\Auth\AuthController;
use App\Controllers\Home\HomeController;
use App\Controllers\Profile\ProfileController;

use App\Controllers\Chress\GamesController;
use App\Controllers\Chress\PlayController;
use App\Controllers\Chress\LobbyController;
use App\Controllers\Chress\LibraryController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'login_get']);
$router->post('/login', [AuthController::class, 'login_post']);
$router->get('/register', [AuthController::class, 'register_get']);
$router->post('/register', [AuthController::class, 'register_post']);
$router->get('/validate', [AuthController::class, 'validate_get']);
$router->post('/validate', [AuthController::class, 'validate_post']);
// $router->get('/confirm', [AuthController::class, 'confirm_get']);
// $router->post('/confirm', [AuthController::class, 'confirm_post']);
$router->get('/recover', [AuthController::class, 'recover_get']);
$router->post('/recover', [AuthController::class, 'recover_post']);
$router->get('/logout', [AuthController::class, 'logout_get']);

$router->get('/profile', [ProfileController::class, 'index']);

$router->get('/games', [GamesController::class, 'index']);

$router->get('/lobby', [LobbyController::class, 'index']);

$router->get('/library', [LibraryController::class, 'index']);

$router->get('/play', [PlayController::class, 'index']);
$router->post('/play/swap', [PlayController::class, 'swap']);
$router->post('/play/flip', [PlayController::class, 'flip']);
$router->post('/play/lastgame', [PlayController::class, 'lastgame']);
$router->post('/play/nextgame', [PlayController::class, 'nextgame']);
$router->post('/play/lastmove', [PlayController::class, 'lastmove']);
$router->post('/play/nextmove', [PlayController::class, 'nextmove']);