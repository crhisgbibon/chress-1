<?php

use App\Models\System\Router;

$router = new Router();

require_once('routers/auth.php');
require_once('routers/create.php');
require_once('routers/games.php');
require_once('routers/history.php');
require_once('routers/home.php');
require_once('routers/library.php');
require_once('routers/lobby.php');
require_once('routers/play.php');
require_once('routers/profile.php');