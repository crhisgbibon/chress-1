<?php

use App\Controllers\Chress\GamesController;

$router->get('/games', [GamesController::class, 'index']);

$router->post('/games/view', [GamesController::class, 'view']);
$router->post('/games/resign', [GamesController::class, 'resign']);