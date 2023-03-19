<?php

use App\Controllers\Auth\AuthController;

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