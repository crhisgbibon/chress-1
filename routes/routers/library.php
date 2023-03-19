<?php

use App\Controllers\Chress\LibraryController;

$router->get('/library', [LibraryController::class, 'index']);