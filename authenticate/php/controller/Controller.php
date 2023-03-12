<?php

session_start();

require_once __DIR__ . "/../Main.php";

$config = new Config();

if($_POST['action'] === 'VALIDATE')
{
  if(!isset($_POST["data"])) return json_encode("Failed.");

  $db = new DatabaseGeneric($config);
  $account = new AccountManager($db);

  $response = $account->Validate($_POST["data"]);

  echo json_encode($response);
}