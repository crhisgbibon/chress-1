<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Models\System\Config;
use App\Models\System\DB;
use PDO;

class AccountManager
{
  private DB $db;
  private Config $config;

  public function __construct(DB $db, Config $config)
  {
    $this->db = $db;
    $this->config = $config;
  }

  public function Device() : bool
  {
    $output = true;

    if(empty($_COOKIE['device_id']))
    {
      $device_id = $this->MakeToken(32);
      $cookie_expiration_time = time() + (10 * 365 * 24 * 60 * 60);

      setcookie('device_id', $device_id, [
        'expires' => $cookie_expiration_time,
        'path' => '/',
        'samesite' => 'Strict',
        'secure' => true,
        'httponly' => true
      ]);

      $output = true;
    }
    else
    {
      $output = false;
    }

    return $output;
  }

  public function LoggedIn() : bool
  {
    $output = false;

    if(isset($_SESSION['loggedin'])) $output = (bool)$_SESSION['loggedin'];

    return $output;
  }

  public function CheckCookie() : bool
  {
    $output = false;
    $state = '';

    if(!empty($_COOKIE['member_login']) && 
    !empty($_COOKIE['random_password']) && 
    !empty($_COOKIE['random_selector']) &&
    !empty($_COOKIE['device_id']))
    {
      $isPasswordVerified = false;
      $isSelectorVerified = false;
      $isExpiryDateVerified = false;
      
      $userToken = $this->GetTokenByUsername($_COOKIE['member_login'], $_COOKIE['device_id'], 0);
      
      if(password_verify($_COOKIE['random_password'], $userToken[0]['passwordHash']))
      {
        $isPasswordVerified = true;
      }
      
      if(password_verify($_COOKIE['random_selector'], $userToken[0]['selectorHash']))
      {
        $isSelectorVerified = true;
      }
      
      date_default_timezone_set('UTC');
      $current_date = date('Y-m-d H:i:s');
      
      if($userToken[0]['expiryDate'] >= $current_date)
      {
        $isExpiryDateVerified = true;
      }
      
      if(!empty($userToken[0]['uniqueIndex']) && 
      $isPasswordVerified && 
      $isSelectorVerified && 
      $isExpiryDateVerified)
      {
        $stmt = $this->db->pdo->prepare('SELECT * FROM logins 
        WHERE user_alias=:qUser
        AND isVerified=1');

        $stmt->bindParam(':qUser', $userToken[0]['user_alias']);
        $stmt->execute();

        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count = count($response);

        if($count > 0)
        {
          if(!isset($_SESSION)) session_start();

          $_SESSION['loggedin'] = true;
          $_SESSION['name'] = $response[0]['user_alias'];
          $_SESSION['id'] = $response[0]['uniqueIndex'];
          $_SESSION['state'] = $response[0]['user_status'];

          $output = true;
          $state = 'Logged in. All factors authenticated and user found.';
        }
        else
        {
          $output = false;
          $state = 'Failed - Factors authenticated but no user found.';
        }
      } 
      else
      {
        $this->MarkAsExpired($userToken[0]['uniqueIndex'], $_COOKIE['device_id']);
        $this->ClearLoginCookies();
        $output = false;
        $state = 'Failed - Some Missing cookies, cleared tokens';
      }
    }
    else
    {
      $output = false;
      $state = 'Failed - All cookies missing do nothing';
    }

    return $output;
  }

  function ClearLoginCookies()
  {
    if(isset($_COOKIE['member_login']))
    {
      setcookie('member_login', 'content', 1, '/');
    }
    if(isset($_COOKIE['random_password']))
    {
      setcookie('random_password', 'content', 1, '/');
    }
    if(isset($_COOKIE['random_selector']))
    {
      setcookie('random_selector', 'content', 1, '/');
    }
  }

  public function Login(string $email, string $password, bool $remember) : array
  {
    $email_err = $password_err = $login_err = '';

    if(empty(trim($email)))
    {
      $email_err = 'Email required.';
    }
    else
    {
      $email = trim($email);
    }
      
    if(empty(trim($password)))
    {
      $password_err = 'Password required.';
    }
    else
    {
      $password = trim($password);
    }
      
    if(empty($email_err) && empty($password_err))
    {
      $stmt = $this->db->pdo->prepare("SELECT *
      FROM logins 
      WHERE user_email=:email
      AND isVerified='1'");
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $count = count($response);

      if($count === 1)
      {
        $hashedPassword = $response[0]['user_password'];
        if(password_verify($password, $hashedPassword))
        {
          if(!isset($_SESSION)) session_start();

          $_SESSION['loggedin'] = true;
          $_SESSION['id'] = $response[0]['uniqueIndex'];
          $_SESSION['name'] = $response[0]['user_alias'];
          $_SESSION['state'] = $response[0]['user_status'];

          if($remember === true)
          {
            $current_time = time();
            $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);

            setcookie('member_login', $response[0]['user_alias'], [
              'expires' => $cookie_expiration_time,
              'path' => '/',
              'samesite' => 'Strict',
              'secure' => true,
              'httponly' => true
            ]);
          
            $random_password = $this->MakeToken(16);

            setcookie('random_password', $random_password, [
              'expires' => $cookie_expiration_time,
              'path' => '/',
              'samesite' => 'Strict',
              'secure' => true,
              'httponly' => true
            ]);
            
            $random_selector = $this->MakeToken(32);

            setcookie('random_selector', $random_selector, [
              'expires' => $cookie_expiration_time,
              'path' => '/',
              'samesite' => 'Strict',
              'secure' => true,
              'httponly' => true
            ]);
            
            $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
            $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
            
            $expiry_date = date('Y-m-d H:i:s', $cookie_expiration_time);

            $device = $this->Device();
            
            $userToken = $this->GetTokenByUsername($response[0]['user_alias'], $_COOKIE['device_id'], 0);

            if (!empty($userToken[0]['uniqueIndex']))
            {
              $this->MarkAsExpired($userToken[0]['uniqueIndex'], $_COOKIE['device_id']);
            }

            $this->InsertToken($response[0]['user_alias'], $random_password_hash, $random_selector_hash, $_COOKIE['device_id'], $expiry_date);

          }

          $success = 'success';
        }
        else
        {
          $success = '';
          $password_err = 'Wrong password.';
        }
      }
      else
      {
        $success = '';
        $email_err = 'Unknown email address.';
      }
    }
    else
    {
      $success = '';
      $login_err = 'Email or password missing.';
    }
    $response = array(
      'success' => '',
      'email_err' => $email_err,
      'password_err' => $password_err,
      'login_err' => $login_err,
    );
    return $response;
  }

  public function Register($username, $email, $password, $confirm) : array
  {
    $usernameToRegister = '';
    $emailToRegister = '';
    $passwordToRegister = '';
    $username_err = $email_err = $password_err = $confirm_password_err = $success = '';

    if(empty(trim($username)))
    {
      $username_err = 'Please enter a username.';
    }
    else if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($username)))
    {
      $username_err = 'Username can only contain letters, numbers, and underscores.';
    }
    else
    {
      $stmt = $this->db->pdo->prepare('SELECT uniqueIndex FROM logins WHERE user_alias=:user');
      $stmt->bindParam(':user', $username);
      $stmt->execute();
      $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $count = count($response);

      if($count > 0)
      {
        $username_err = 'This username is already taken.';
      }
      else
      {
        $usernameToRegister = trim($username);
      }
    }

    if(empty(trim($email)))
    {
      $email_err = 'Please enter an email address.';
    }
    else
    {
      $stmt = $this->db->pdo->prepare('SELECT uniqueIndex FROM logins WHERE user_email=:qEmail');
      $stmt->bindParam(':qEmail', $email);
      $stmt->execute();
      $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $count = count($response);

      if($count > 0)
      {
        $email_err = 'There is already an account registered to this email address.';
      }
      else
      {
        $emailToRegister = trim($email);
      }
    }

    if(empty(trim($password)))
    {
      $password_err = 'Please enter a password.';
    }
    else if(strlen(trim($password)) < 6)
    {
      $password_err = 'Password must have at least 6 characters.';
    }
    else
    {
      $passwordToRegister = trim($password);
    }
    
    if(empty(trim($confirm)))
    {
      $confirm_password_err = 'Please confirm password.';
    }
    else
    {
      if(empty($password_err) && ($passwordToRegister != $confirm))
      {
        $confirm_password_err = 'Password did not match.';
      }
    }

    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err))
    {
      $stmt = $this->db->pdo->prepare('INSERT INTO logins
      (user_alias,
      user_password,
      createdAt,

      user_email,
      user_status,
      activationCode,

      activationExpiry,
      isVerified)
      VALUES (:qUser,
      :qPassword,
      :qCreated,

      :qEmail,
      :qStatus,
      :qCode,

      :qExpiry,
      :qVerified)');

      $stmt->bindParam(':qUser', $usernameToRegister);

      $hashed = password_hash($passwordToRegister, PASSWORD_DEFAULT);
      $stmt->bindParam(':qPassword', $hashed);

      date_default_timezone_set('UTC');
      $currentDate1 = date('Y-m-d H:i:s');
      $stmt->bindParam(':qCreated', $currentDate1);

      $stmt->bindParam(':qEmail', $emailToRegister);

      $status = 'user';
      $stmt->bindParam(':qStatus', $status);

      $code = $this->MakeToken(32);
      $hashed_code = password_hash($code, PASSWORD_DEFAULT);
      $stmt->bindParam(':qCode', $hashed_code);

      $activationExpiry = date('Y-m-d H:i:s', strtotime('+ 1 day'));
      $stmt->bindParam(':qExpiry', $activationExpiry);

      $notVerified = 0;
      $stmt->bindParam(':qVerified', $notVerified);

      $stmt->execute();

      $this->SendActivationEmail($emailToRegister, $code);

      $this->ClearLoginCookies();

      $success = 'Account created. Please check your email to validate your account.';
    }
    else
    {
      $success = 'There was an error creating your account. Please try again';
    }
    $response = array(
      'success' => $success,
      'username_err' => $username_err,
      'email_err' => $email_err,
      'password_err' => $password_err,
      'confirm_password_err' => $confirm_password_err,
    );
    return $response;
  }

  private function SendActivationEmail(string $address, string $activationCode) : string
  {
    
    $url = $this->config->app['url'] . '/validate';

    $activatationLink = $url . '?email={$address}&activation_code={$activationCode}';

    $subject = $this->config->app['name'] . ' - Account Activation';
    $message = <<<MESSAGE
    Hi,
    <br>
    <br>
    Please click the following link to validate your account:
    <br>
    <br>
    <a href={$activatationLink}>Validate</a>
    <br>
    <br>
    MESSAGE;
    
    $e = new Email($this->config->email);

    $to = trim($address);
  
    $response = $e->Email(
      $errorMode = false,
      $debugMode = 0,
      $sentFrom = [$this->config->email['from'], $this->config->app['name']],
      $sendTo = [
        [$to, ''],
      ],
      $replyTo = [$this->config->email['from'], $this->config->app['name']],
      $emailSubject = $subject,
      $emailBody = $message,
      $emailAltBody = $message,
      $attachments = [],
      $images = []
    );

    return $response;
  }

  public function Validate(string $email, string $code) : string
  {
    $stmt = $this->db->pdo->prepare('SELECT activationCode, activationExpiry FROM logins WHERE user_email=:qEmail');
    $stmt->bindParam(':qEmail', $email);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($response);

    if($count === 1)
    {
      $activationExpiry = strtotime($response[0]['activationExpiry']);
      $now = strtotime('now');

      if($now < $activationExpiry)
      {
        if(password_verify($code, $response[0]['activationCode']))
        {
          $stmt = $this->db->pdo->prepare('UPDATE logins SET `isVerified`=:qVerified WHERE user_email=:qEmail');
          $verified = 1;
          $stmt->bindParam(':qVerified', $verified);
          $stmt->bindParam(':qEmail', $email);
          $stmt->execute();
          $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $count = count($response);

          return 'Accout Validated. Please login.';
        }
        else
        {
          $stmt = $this->db->pdo->prepare('DELETE FROM logins WHERE user_email=:qEmail');
          $stmt->bindParam(':qEmail', $email);
          $stmt->execute();

          return 'Error - Activation code is invalid. Please re-register';
        }
      }
      else
      {
        $stmt = $this->db->pdo->prepare('DELETE FROM logins WHERE user_email=:qEmail');
        $stmt->bindParam(':qEmail', $email);
        $stmt->execute();

        return 'Error - Activation code has expired. Please re-register.';
      }
    }
    else if($count > 0)
    {
      return 'Error - There is already an account registered to this email address.';
    }
    else if($count === 0)
    {
      return 'Error - No account identified.';
    }
  }

  public function ResetAccountPassword(array $data) : string
  {
    if(count($data) !== 1) return 'Invalid Input Data.';

    $email = (string)$data[0];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return 'Error: Invalid email submitted.';
    }

    $stmt = $this->db->pdo->prepare('SELECT * FROM logins WHERE user_email=:qEmail');
    $stmt->bindParam(':qEmail', $email);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($response);

    if($count === 1)
    {
      $newPassword = $this->MakeToken(8);
      $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

      $subject = 'CalypsoGrammar - Password Reset';
      $message = <<<MESSAGE
      Hi,
      <br>
      <br>
      Your password has been reset to:
      <br>
      <br>
      {$newPassword}
      <br>
      <br>
      MESSAGE;

      $e = new Email($this->config->email);
  
      $to = trim($email);

      var_dump($to);
    
      $emailResponse = $e->Email(
        $errorMode = false,
        $debugMode = 0,
        $sentFrom = ['admin@calypsogrammar.com', 'Calypso Grammar'],
        $sendTo = [
          [$to, ''],
        ],
        $replyTo = ['admin@calypsogrammar.com', 'Calypso Grammar'],
        $emailSubject = $subject,
        $emailBody = $message,
        $emailAltBody = $message,
        $attachments = [],
        $images = []
      );

      var_dump($emailResponse);

      if($emailResponse === 'SENT')
      {
        $stmt = $this->db->pdo->prepare('UPDATE logins SET `user_password`=:qPassword WHERE user_email=:qEmail');
        $stmt->bindParam(':qPassword', $hashed);
        $stmt->bindParam(':qEmail', $email);
        try
        {
          $stmt->execute();
          return 'An email has been sent to you with a new password.';
        }
        catch(Exception $e)
        {
          return 'Error: Unable to update account. Please try again.';
        }
      }
      else
      {
        return 'Error: Unable to email selected account. Please try again.';
      }
    }
    else if($count === 0)
    {
      return 'No account found linked that to email address.';
    }
    else if($count > 1)
    {
      return 'Error: Multiple accounts detected. Please email contact@calypsogrammar.com.';
    }
  }

  public function ChangePassword(array $data, string $name) : string
  {
    if(count($data) !== 3) return 'Invalid Input Data.';

    $oldPassword = (string)$data[0];
    $newPassword = (string)$data[1];
    $confirmPassword = (string)$data[2];

    $stmt = $this->db->pdo->prepare('SELECT * FROM logins WHERE user_alias=:qName');
    $stmt->bindParam(':qName', $name);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($response);

    if($count === 1)
    {
      $hashedPassword = $response[0]['user_password'];

      if(password_verify($oldPassword, $hashedPassword))
      {
        $passwordToRegister = trim($newPassword);
        $trimmedConfirm = trim($confirmPassword);

        if($passwordToRegister === $trimmedConfirm)
        {
          $stmt = $this->db->pdo->prepare('UPDATE logins SET `user_password`=:qPassword WHERE user_alias=:qName');

          $hashed = password_hash($passwordToRegister, PASSWORD_DEFAULT);
          $stmt->bindParam(':qPassword', $hashed);
          $stmt->bindParam(':qName', $name);
          
          try
          {
            $stmt->execute();
            return 'Password updated successfully.';
          }
          catch(Exception $e)
          {
            return 'Error updating password. Please try again.';
          }
        }
        else
        {
          return 'Password and confirmation do not match. Please try again.';
        }
      }
      else
      {
        return 'Old password does not match. Please try again.';
      }
    }
    else if($count === 0)
    {
      return 'Account not found.';
    }
    else if($count > 1)
    {
      return 'Error: Multiple accounts detected  - please contact administrator.';
    }
  }

  private function MakeToken($length)
  {
    $rand_token = openssl_random_pseudo_bytes($length);
    $token = bin2hex($rand_token);
    return $token;
  }

  public function GetTokenByUsername($username, $device, $expired)
  {
    $stmt = $this->db->pdo->prepare('SELECT * FROM tokens 
    WHERE user_alias=:qUser 
    AND deviceID=:qDevice
    AND isExpired=:qExpired');
    $stmt->bindParam(':qUser', $username);
    $stmt->bindParam(':qDevice', $device);
    $stmt->bindParam(':qExpired', $expired);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response;
  }

  public function MarkAsExpired($tokenId, $device)
  {
    $stmt = $this->db->pdo->prepare('UPDATE tokens 
    SET isExpired=:qExpired 
    WHERE uniqueIndex=:qIndex
    AND deviceID=:qDevice');
    $expired = 1;
    $stmt->bindParam(':qExpired', $expired);
    $stmt->bindParam(':qDevice', $device);
    $stmt->bindParam(':qIndex', $tokenId);
    $stmt->execute();
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $response;
  }

  function InsertToken($username, $random_password_hash, $random_selector_hash, $random_device_id, $expiry_date)
  {
    $stmt = $this->db->pdo->prepare('INSERT INTO tokens (user_alias, 
    passwordHash, 
    selectorHash, 
    deviceID, 
    isExpired, 
    expiryDate)
    VALUES (:user, :pass, :selector, :device, :isExpired, :expiry)');
    $expiredValue = 0;
    $stmt->bindParam(':user', $username);
    $stmt->bindParam(':pass', $random_password_hash);
    $stmt->bindParam(':selector', $random_selector_hash);
    $stmt->bindParam(':device', $random_device_id);
    $stmt->bindParam(':isExpired', $expiredValue);
    $stmt->bindParam(':expiry', $expiry_date);
    $stmt->execute();
  }

  function GetAccountName($intID) : string
  {
    $stmt = $this->db->pdo->prepare('SELECT user_alias FROM logins WHERE uniqueIndex=:uIndex');
    $stmt->bindParam(':uIndex', $intID);
    $stmt->execute();
    $response = $stmt->fetchColumn();
    return (string)$response;
  }
}