<?php

declare(strict_types=1);

namespace App\Controllers\Home;

if(!isset($_SESSION)) session_start();

require_once __DIR__ . "/../generic/php/model/AccountManager.php";
require_once __DIR__ . "/../generic/php/model/DataBaseGeneric.php";
require_once __DIR__ . "/../generic/php/model/Debug.php";
require_once __DIR__ . "/../generic/php/model/Config.php";
require_once __DIR__ . "/../generic/php/model/Email.php";

// REGISTRATION / LOGIN

$config = new Config();

if($_POST['action'] === 'Login')
{
  $username = (string)$_POST["data"][0];
  $password = (string)$_POST["data"][1];
  if($_POST["data"][2] === "true") $remember = true;
  else $remember = false;

  $d = new Debug();
  $d->Debug("Controller_remember", "bool", $remember);

  $db = new DatabaseGeneric($config);
  $account = new AccountManager($db);

  $response = $account->Login($username, $password, $remember);
  
  echo json_encode("Logged In.");
}

if($_POST['action'] === 'Register')
{
  $username = $_POST["data"][0];
  $email = $_POST["data"][1];

  $password = $_POST["data"][2];
  $confirm = $_POST["data"][3];

  $db = new DatabaseGeneric($config);
  $account = new AccountManager($db);

  $response = $account->Register($username, $email, $password, $confirm);

  echo json_encode($response);
}

if($_POST['action'] === 'Logout')
{
  $db = new DatabaseGeneric($config);
  $account = new AccountManager($db);

  $_SESSION["loggedin"] = false;
  $_SESSION["id"] = "";

  $_SESSION["name"] = "";
  $_SESSION["state"] = "";

  $account->ClearLoginCookies();

  session_unset();
  session_destroy();

  echo json_encode("Logged Out.");
}

if($_POST['action'] === 'RECOVER')
{
  if(!isset($_POST["data"])) return json_encode("Failed.");

  $db = new DatabaseGeneric($config);
  $account = new AccountManager($db);

  $response = $account->ResetAccountPassword($_POST["data"]);

  echo json_encode($response);
}

if($_POST['action'] === 'CHANGEPASSWORD')
{
  if(!isset($_POST["data"])) return json_encode("Failed.");

  $db = new DatabaseGeneric($config);
  $account = new AccountManager($db);

  $response = $account->ChangePassword($_POST["data"], $_SESSION["name"]);

  echo json_encode($response);
}

if($_POST['action'] === 'DEBUG')
{
  $d = new Debug();
  $output = $d->ShowDebug();
  echo json_encode($output);
}