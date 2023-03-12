<?php

if(!isset($_SESSION)) session_start();

require_once __DIR__ . '/../app/views/home/HomeView.php';

$home = new HomeView();
$home->render();