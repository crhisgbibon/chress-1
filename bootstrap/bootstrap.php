<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../routes/web.php';

use App\Models\System\App;
use App\Models\System\Config;

(new App(
  $router,
  ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
  new Config($_ENV)
))->run();