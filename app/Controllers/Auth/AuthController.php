<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Models\Auth\AccountManager;
use App\Models\Generic\Config;
use App\Models\Generic\DB;
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
    $this->account = new AccountManager($this->db, $this->config);
  }

  public function loginGet() : View
  {
    return View::make
    (
      'auth/login',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'email' => '',
        'email_err' => '',
        'password' => '',
        'password_err' => '',
      ]
    );
  }

  public function loginPost() : View
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = false;

    $response = $this->account->Login($email, $password, $remember);

    return View::make
    (
      'auth/login', // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'email' => $email,
        'email_err' => $response['email_err'],
        'password' => '',
        'password_err' => $response['password_err'],
      ]
    );
  }

  public function registerGet() : View
  {
    return View::make
    (
      'auth/register',  // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array

      ]
    );
  }

  public function registerPost()
  {
    $username = $_POST['register_username'];
    $email = $_POST['register_email'];
    $password = $_POST['register_password'];
    $confirm = $_POST['register_confirm_password'];

    $response = $this->account->Register($username, $email, $password, $confirm);

    return View::make
    (
      'auth/register', // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'username' => $username,
        'username_err' => $response['username_err'],
        'email' => $email,
        'email_err' => $response['email_err'],
        'password' => '',
        'password_err' => $response['password_err'],
        'confirm' => '',
        'confirm_password_err' => $response['confirm_password_err'],
        'success' => $response['success'],
      ]
    );
  }

  public function validateGet() : View
  {
    if(isset($_GET['email'])) $email = $_GET['email'];
    else $email = '';
    
    if(isset($_GET['activation_code'])) $activationCode = $_GET['activation_code'];
    else $activationCode = '';

    return View::make
    (
      'auth/validate', // body view path
      'Chress',           // view title
      true,               // with layout
      [                   // controls array

      ],
      [                   // body params array
        'email' => $email,
        'code' => $activationCode,
      ]
    );
  }

  public function validatePost() : string
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];
    $code = $data['code'];

    $response = $this->account->Validate($email, $code);

    if($response !== null) return json_encode($response);
    else return json_encode('There was an error validating your account.');
  }

  public function profileGet() : View
  { 
    return View::make
    (
      'profile/profile', // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'name' => $_SESSION['name'],
      ]
    );
  }

  public function logoutGet() : View
  { 
    $_SESSION["loggedin"] = false;
    $_SESSION["id"] = "";
  
    $_SESSION["name"] = "";
    $_SESSION["state"] = "";
  
    $this->account->ClearLoginCookies();
  
    session_unset();
    session_destroy();

    return View::make
    (
      'auth/logout', // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array

      ]
    );
  }
}