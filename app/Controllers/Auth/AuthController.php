<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Models\Auth\AuthModel;
use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

class AuthController
{
  private AuthModel $account;
  private Config $config;
  private DB $db;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);
    $this->account = new AuthModel($this->db, $this->config);
  }

  public function loginGet() : View
  {
    $loggedin = $this->account->LoggedIn();
    return View::make
    (
      'auth/login',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'loggedin' => $loggedin,
        'email' => '',
        'email_err' => '',
        'password' => '',
        'password_err' => '',
        'login_err' => '',
      ]
    );
  }

  public function loginPost() : View
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = false;

    $response = $this->account->Login($email, $password, $remember);
    $loggedin = $this->account->LoggedIn();

    return View::make
    (
      'auth/login', // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'loggedin' => $loggedin,
        'email' => $email,
        'email_err' => $response['email_err'],
        'password' => '',
        'password_err' => $response['password_err'],
        'login_err' => $response['login_err'],
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
      [                   // body params array
        'email' => $email,
        'code' => $activationCode,
      ]
    );
  }

  public function validatePost() : string
  {
    $data = json_decode(file_get_contents('php://input'), true);
    if(count($data) === 2)
    {
      $email = $data['email'];
      $code = $data['code'];
    }
    else
    {
      $email = '';
      $code = '';
    }

    $response = $this->account->Validate($email, $code);

    if($response !== null) return json_encode($response);
    else return json_encode('There was an error confirming your account.');
  }

  public function confirmGet() : View
  {
    $name = $this->account->existsName();
    $loggedin = $this->account->LoggedIn();
    $verified = $this->account->isVerified();
    $response = '';
    return View::make
    (
      'auth/confirm',  // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'name' => $name,
        'loggedin' => $loggedin,
        'verified' => $verified,
        'response' => $response,
      ]
    );
  }

  public function confirmPost() : View
  {
    $name = $this->account->existsName();
    $loggedin = $this->account->LoggedIn();
    $verified = $this->account->isVerified();
    $response = $this->account->ReSentActivationEmail();

    return View::make
    (
      'auth/confirm',  // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'name' => $name,
        'loggedin' => $loggedin,
        'verified' => $verified,
        'response' => $response,
      ]
    );
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
    $this->account->logout();

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