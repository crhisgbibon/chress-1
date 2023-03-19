<?php

use App\Controllers\Chress\HistoryController;

$router->get('/history', [HistoryController::class, 'index']);