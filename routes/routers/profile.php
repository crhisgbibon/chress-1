<?php

use App\Controllers\Profile\ProfileController;

$router->get('/profile', [ProfileController::class, 'index']);