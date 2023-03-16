<?php

declare(strict_types=1);

namespace App\Database\Migrations;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Dotenv\Dotenv;

use App\Models\Generic\Config;
use App\Models\Generic\DB;

use App\Database\Migrations\Logins;
use App\Database\Migrations\Tokens;

$dotenv = Dotenv::createImmutable(dirname(__DIR__ . '/../../../../'));
$dotenv->load();

$config = new Config($_ENV);
$db = new DB($config->db_local);

$login = new Logins($db);
$login->up();

$token = new Tokens($db);
$token->up();