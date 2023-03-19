<?php

use App\Controllers\Chress\LobbyController;

$router->get('/lobby', [LobbyController::class, 'index']);

$router->post('/lobby/newgame', [LobbyController::class, 'newgame']);

$router->post('/lobby/accept', [LobbyController::class, 'accept']);