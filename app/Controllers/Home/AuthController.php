<?php

declare(strict_types=1);

namespace App\Controllers\Home;

// Generic - Models

use App\Models\Generic\AccountManager;
use App\Models\Generic\Config;
use App\Models\Generic\DB;
use App\Models\Generic\Debug;
use App\Models\Generic\Email;
use App\Models\Generic\View;

class AuthController
{
  private AccountManager $account;
  private Config $config;
  private DB $db;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);
    $this->account = new AccountManager($this->db);
  }

  public function login()
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = false;

    $response = $this->account->Login($email, $password, $remember);

    if($response !== null) var_dump($response);
    else echo "response is empty";
  }

  public function register()
  {
    $username = $_POST['register_username'];
    $email = $_POST['register_email'];
    $password = $_POST['register_password'];
    $confirm = $_POST['register_confirm_password'];

    $response = $this->account->Register($username, $email, $password, $confirm);

    if($response !== null) var_dump($response);
    else echo "response is empty";
  }

}