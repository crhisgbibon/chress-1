<?php

use App\Models\System\Router;

use App\Controllers\Auth\AuthController;
use App\Controllers\Chress\ChressController;

$router = new Router();
$router->get('/', [ChressController::class, 'homeGet']);

$router->get('/login', [AuthController::class, 'loginGet']);
$router->post('/login', [AuthController::class, 'loginPost']);

$router->get('/register', [AuthController::class, 'registerGet']);
$router->post('/register', [AuthController::class, 'registerPost']);

$router->get('/validate', [AuthController::class, 'validateGet']);
$router->post('/validate', [AuthController::class, 'validatePost']);

$router->get('/confirm', [AuthController::class, 'confirmGet']);
$router->post('/confirm', [AuthController::class, 'confirmPost']);

$router->get('/profile', [AuthController::class, 'profileGet']);
$router->get('/logout', [AuthController::class, 'logoutGet']);

$router->get('/play', [ChressController::class, 'playGet']);
$router->post('/play/swap', [ChressController::class, 'playGetSwap']);
$router->post('/play/lastgame', [ChressController::class, 'playGetLastgame']);
$router->post('/play/nextgame', [ChressController::class, 'playGetNextgame']);