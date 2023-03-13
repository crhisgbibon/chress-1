<?php

declare(strict_types=1);

namespace App\Views\Generic;

class AccountView
{
  
  public function __construct()
  {

  }

  public function render($isLoggedIn, $accountName)
  {
    $logInView = "";
    $logOutView = "";

    if($isLoggedIn)
    {
      $logInView = "style='display:none;'";
      $logOutView = "";
    }
    else
    {
      $logInView = "";
      $logOutView = "style='display:none;'";
    }

    echo <<<VIEW

    <div id="generic_view">

      <div id="generic_login" {$logInView}>
        <label class="generic_loginClass" id="generic_loginUsernameLabel" for="generic_loginUsername">Username:</label>
        <input class="generic_loginClass" type="text" id="generic_loginUsername" name="generic_loginUsername" autofocus placeholder="">
        <label class="generic_loginClass" id="generic_loginPasswordLabel" for="generic_loginPassword">Password:</label>
        <input class="generic_loginClass" type="password" id="generic_loginPassword" name="generic_loginPassword" placeholder="">
        <label class="generic_loginClass" id="generic_loginStayLabel" for="generic_loginStay">Remember Me:</label>
        <input type="checkbox" class="generic_loginClass" id="generic_loginStay" checked>
        <button class="generic_loginClass" id="generic_loginLogin">Log in</button>
        <button class="generic_loginClass" id="generic_loginRegister">Register</button>
        <button class="generic_loginClass" id="generic_loginHelp">Help</button>
      </div>

      <div id="generic_logout" {$logOutView}>

        <div class="generic_loginClass" id="generic_logoutUsername">Logged in as: {$accountName}</div>
        <br>
        Change Password
        <br>
        <label class="generic_loginClass" for="generic_logoutOldPassword">Enter Old Password:</label>
        <input class="generic_loginClass" type="password" id="generic_logoutOldPassword" name="generic_logoutOldPassword">

        <label class="generic_loginClass" for="generic_logoutNewPassword">Enter New Password:</label>
        <input class="generic_loginClass" type="password" id="generic_logoutNewPassword" name="generic_logoutNewPassword">

        <label class="generic_loginClass" for="generic_logoutConfirmPassword">Confirm New Password:</label>
        <input class="generic_loginClass" type="password" id="generic_logoutConfirmPassword" name="generic_logoutConfirmPassword">
        <br>
        <button class="generic_loginClass" id="generic_logoutChangePassword">Change Password</button>
        <br>
        <br>
        <button class="generic_loginClass" id="generic_logoutLogOut">Log out</button>
      </div>

      <div id="generic_register">
        <div class="generic_loginClass">Register Account</div>
        <label class="generic_loginClass" for="generic_registerUsername">Username:</label>
        <input class="generic_loginClass" type="text" id="generic_registerUsername" name="generic_registerUsername"> <!-- new account username -->
        <label class="generic_loginClass" for="generic_loginEmail">Email:</label>
        <input class="generic_loginClass" type="text" id="generic_loginEmail" name="generic_loginEmail"> <!-- new account email address -->
        <label class="generic_loginClass" for="generic_registerPassword">Password:</label>
        <input class="generic_loginClass" type="password" id="generic_registerPassword" name="generic_registerPassword" > <!-- new account password -->
        <label class="generic_loginClass" for="generic_registerConfirmPassword">Confirm Password:</label>
        <input class="generic_loginClass" type="password" id="generic_registerConfirmPassword" name="generic_registerConfirmPassword" > <!-- confirm new account password -->
        <button class="generic_loginClass" id="generic_registerRegister">Register</button> <!-- registers new account, logs in and closes registration screen -->
        <button class="generic_loginClass" id="generic_registerClose">Close</button> <!-- closes registration screen -->
      </div>

      <div id="generic_helpLogin">

        Reset Account Password

        <label class="generic_loginClass" for="generic_helpLoginEmail">Account Email Address:</label>
        <input class="generic_loginClass" type="text" id="generic_helpLoginEmail" name="generic_helpLoginEmail">
        <button class="generic_loginClass" id="generic_helpLoginReset">Reset Password</button>

        <button class="generic_loginClass" id="generic_helpLoginClose">Close</button>

      </div>

    </div>

    VIEW;
  }

  public function PrintNope(array $data) : string
  {
    $nope = false;

    if(isset($data['loggedin']) && $data['loggedin'])
    {
      if(isset($data['state']))
      {
        if($data['state'] !== "admin")
        {
          $nope = true;
        }
      }
      else
      {
        $nope = true;
      }
    }
    else
    {
      $nope = true;
    }

    $output = "";

    if($nope === true)
    {
      $output = <<<VIEW

      <!DOCTYPE html>

      <html lang="en-UK" style="font-size: 16px; font-family: Georgia, 'Times New Roman', Times, serif">

      <head>

        <title>Nope.</title>

        <meta charset="UTF-8" />

        <meta name="description" content="Nope." />
        <meta name="keywords" content="Calypso, Grammar, Nope." />
        <meta name="author" content="contact@calypsogrammar.com" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        
        <style>
          @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Open+Sans:wght@700&family=Patua+One&display=swap');
          body{
            position: fixed;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
          }
          </style>
        
      </head>

      <body>
      
      X
      
      </body>
      
      </html>

      VIEW;
    }

    return $output;
  }
}