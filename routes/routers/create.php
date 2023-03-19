<?php

use App\Controllers\Chress\CreateController;

$router->get('/create', [CreateController::class, 'index']);
$router->post('/create', [CreateController::class, 'newgame']);