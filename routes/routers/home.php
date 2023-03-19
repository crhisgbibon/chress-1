<?php

use App\Controllers\Home\HomeController;

$router->get('/', [HomeController::class, 'index']);