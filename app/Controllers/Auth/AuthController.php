<?php

declare(strict_types=1);

namespace App\Controllers\Auth;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

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

  #[Get(routePath:'/login')]
  public function login_get() : View
  {
    $loggedin = $this->account->LoggedIn();
    return View::make
    (
      'auth/login',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
        'loggedin' => $loggedin,
        'email' => '',
        'email_err' => '',
        'password' => '',
        'password_err' => '',
        'login_err' => '',
      ]
    );
  }

  #[Post(routePath:'/login')]
  public function login_post() : View
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = false;

    $response = $this->account->Login($email, $password, $remember);
    $loggedin = $this->account->LoggedIn();

    return View::make
    (
      'auth/login',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
        'loggedin' => $loggedin,
        'email' => $email,
        'email_err' => $response['email_err'],
        'password' => '',
        'password_err' => $response['password_err'],
        'login_err' => $response['login_err'],
      ]
    );
  }

  #[Get(routePath:'/register')]
  public function register_get() : View
  {
    $loggedin = $this->account->LoggedIn();
    return View::make
    (
      'auth/register',  // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
        'loggedin' => $loggedin,
        'username' => '',
        'username_err' => '',
        'email' => '',
        'email_err' => '',
        'password' => '',
        'password_err' => '',
        'confirm' => '',
        'confirm_password_err' => '',
        'success' => '',
      ]
    );
  }

  #[Post(routePath:'/register')]
  public function register_post()
  {
    $loggedin = $this->account->LoggedIn();

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
        'layer' => './',
        'loggedin' => $loggedin,
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

  #[Get(routePath:'/validate')]
  public function validate_get() : View
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
        'layer' => './',
        'email' => $email,
        'code' => $activationCode,
      ]
    );
  }

  #[Post(routePath:'/validate')]
  public function validate_post() : string
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

  #[Get(routePath:'/recover')]
  public function recover_get() : View
  {
    $name = $this->account->existsName();
    $loggedin = $this->account->LoggedIn();
    $verified = $this->account->isVerified();
    $response = '';
    return View::make
    (
      'auth/recover',  // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
        'name' => $name,
        'loggedin' => $loggedin,
        'verified' => $verified,
        'response' => $response,
      ]
    );
  }

  #[Post(routePath:'/recover')]
  public function recover_post() : View
  {
    $name = $this->account->existsName();
    $loggedin = $this->account->LoggedIn();
    $verified = $this->account->isVerified();
    $response = $this->account->ReSentActivationEmail();

    return View::make
    (
      'auth/recover',  // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
        'name' => $name,
        'loggedin' => $loggedin,
        'verified' => $verified,
        'response' => $response,
      ]
    );
  }

  #[Get(routePath:'/logout')]
  public function logout_get() : View
  { 
    $wasLoggedIn = $this->account->logout();

    return View::make
    (
      'auth/logout', // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
        'wasloggedin' => $wasLoggedIn,
      ]
    );
  }
}