<?php

use App\Models\System\Router;

use App\Controllers\Auth\AuthController;

use App\Controllers\Chress\GamesController;
use App\Controllers\Chress\HistoryController;
use App\Controllers\Chress\LibraryController;
use App\Controllers\Chress\LobbyController;
use App\Controllers\Chress\UsersController;

use App\Controllers\Home\HomeController;

use App\Controllers\Profile\ProfileController;

$router = new Router();
$router->registerRoutesFromControllerAttributes([
  AuthController::class,

  GamesController::class,
  HistoryController::class,
  LibraryController::class,
  LobbyController::class,
  UsersController::class,

  HomeController::class,
  
  ProfileController::class,
]);