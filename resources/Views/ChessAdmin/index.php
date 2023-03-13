<?php

include "php_main.php";

?>

<!DOCTYPE html>

<html lang="en-UK" style="font-size: 16px; font-family: Georgia, 'Times New Roman', Times, serif">

<head>

  <title>Chess</title>
  
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
  <meta name="description" content="" />
  
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Open+Sans:wght@700&family=Patua+One&display=swap');
</style>
  
  <link rel="stylesheet" type="text/css" href="css_main.css" />
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  
</head>

<body>

<div id="controls">
  <div id="div1">
    <button id="newGameButton">
      <img id="iPlay" src="play-button-o.svg"></img>
    </button>
  </div>
  <div id="div2">
    <button id="lastMoveButton">
      <
    </button>
  </div>
  <div id="currentMoveDiv">
    0
  </div>
  <div id="div3">
    <button id="nextMoveButton">
      >
    </button>
  </div>
  <div id="div4">
    <button id="aiButton">
      <img id="iInfo" src="info.svg"></img>
    </button>
  </div>
  <div id="div5">
    <button id="lastGameButton">
      <<
    </button>
  </div>
  <div id="currentGameDiv">
    0
  </div>
  <div id="div6">
    <button id="nextGameButton">
      >>
    </button>
  </div>
  <div id="div7">
    <button id="flipButton">
      <img id="iTheme" src="dark-mode.svg"></img>
    </button>
  </div>
  <!--
  <div id="div9">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="the_file[]" id="fileToUpload" multiple>
        <input type="submit" name="submit" value="Start Upload">
    </form>
  </div>
  -->
  <div id="div9">
    <input type="number" step="1" name="startNumber" id="startNumber">
    <input type="number" step="1" name="endNumber" id="endNumber">
  </div>
  <div id="div9">
    <select id="uploadedFileSelect"></select>
  </div>
  <div id="div9">
    <button onclick="RequestPurePGNJSON()">Load</button>
  </div>
  <div id="div9">
    <button onclick="RequestPurePGNJSON2()">Load Selected</button>
  </div>
  <div id="div8">
    <button id="saveToPGNLibraryButton">
      Save
    </button>
  </div>
</div>

<div id="bodyDiv">
  <div id="boardDiv"></div>
  <div id="interfaceDiv"></div>
</div>

</body>

<script src="js_main.js"></script>

</html>