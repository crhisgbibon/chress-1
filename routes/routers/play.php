<?php

use App\Controllers\Chress\PlayController;

$router->get('/play', [PlayController::class, 'index']);

$router->post('/play/mode', [PlayController::class, 'mode']);

$router->post('/play/flip', [PlayController::class, 'flip']);

$router->post('/play/lastgame', [PlayController::class, 'lastgame']);
$router->post('/play/nextgame', [PlayController::class, 'nextgame']);

$router->post('/play/lastmove', [PlayController::class, 'lastmove']);
$router->post('/play/nextmove', [PlayController::class, 'nextmove']);