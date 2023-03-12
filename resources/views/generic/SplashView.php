<?php

declare(strict_types=1);

/** View Class
 * 
 * 
 * 
*/

class SplashView
{
  
  public function __construct()
  {

  }

  public function render()
  {
    echo <<<VIEW

      <div id="generic_view">

        <div id="generic_login">
          <label class="generic_loginClass" id="generic_loginUsernameLabel" for="generic_loginUsername">Username:</label>
          <input class="generic_loginClass" type="text" id="generic_loginUsername" name="generic_loginUsername" autofocus placeholder="">
          <label class="generic_loginClass" id="generic_loginPasswordLabel" for="generic_loginPassword">Password:</label>
          <input class="generic_loginClass" type="password" id="generic_loginPassword" name="generic_loginPassword" placeholder="">
          <label class="generic_loginClass" id="generic_loginStayLabel" for="generic_loginStay">Remember Me:</label>
          <input type="checkbox" class="generic_loginClass" id="generic_loginStay" checked>
          <button class="generic_loginClass" id="generic_loginLogin">Log in</button>
          <button class="generic_loginClass" id="generic_loginRegister">Register</button>
          <button class="generic_loginClass" id="generic_loginHome">Home</button>
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

        <div id="messageBox"></div>

      </div>

    </body>

    <script src='js/splash/Splash.js'></script>

    </html>

    VIEW;
  }
}