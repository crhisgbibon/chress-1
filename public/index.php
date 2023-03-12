<?php

if(!isset($_SESSION)) session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/controllers/home/HomeController.php';

$loader = new FilesystemLoader('/../resources/views/**/*.php');
$twig = new Environment($loader, [
    'cache' => '/path/to/compilation_cache',
]);

$home = new HomeController();
$home->Index();