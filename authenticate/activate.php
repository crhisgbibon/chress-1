<?php

if(!isset($_SESSION)) session_start();

require_once __DIR__ . "/../generic/php/model/AccountManager.php";
require_once __DIR__ . "/../generic/php/model/Config.php";
require_once __DIR__ . "/../generic/php/model/DataBaseGeneric.php";

require_once __DIR__ . "/../generic/php/view/HeaderView.php";
require_once __DIR__ . "/../generic/php/view/AccountView.php";

$header = new HeaderView();
$faviconRoute = "/../favicon.ico";
$headerContents = $header->PrintContents("Validate", "css/Main.css", $faviconRoute);

if(isset($_GET["email"]))
{
  $email = $_GET["email"];
}
else
{
  $email = "";
}

if(isset($_GET["activation_code"]))
{
  $activationCode = $_GET["activation_code"];
}
else
{
  $activationCode = "";
}

echo <<<VIEW

{$headerContents}

<div id="validate">
  <button id="ValidateButton" onclick="Validate('{$email}', '{$activationCode}')">Validate Account</button>

  <div id="responseBox"></div>

  <button id="HomeButton"><img id="i_controlHome" src=""></img></button>
</div>

<div id="messageBox"></div>

</body>

<script src="js/Main.js"></script>

</html>

VIEW;