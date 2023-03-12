<?php

include "php_main.php";

if($_POST['action'] === "START") {
  
  return;
}

if($_POST['action'] === "REQUESTDATABASE") {
  
  if(isset($_POST['PGNFILE']))
  {
    $fileName = $_POST['PGNFILE'];
    $one = ConvertPGNToArray($fileName);
    //print_r($one);
    echo json_encode($one, JSON_UNESCAPED_UNICODE);
    return;
  }
}

if($_POST['action'] === "REQUESTDATABASEPURE") {
  
  if(isset($_POST['PGNFILE']))
  {
    $fileName = "memory1/" . $_POST['PGNFILE'];
    $one = ConvertPGNToArrayPure($fileName);
    //print_r($one);
    echo json_encode($one, JSON_UNESCAPED_UNICODE);
    return;
  }
}

if($_POST['action'] === "SAVETOPGNLIBRARY") {
  
  if(isset($_POST['SAVEFILE']))
  {
    $array = json_decode($_POST['SAVEFILE']);
    SavetoSQLPGNLibrary($array);
    return;
  }
}

if($_POST['action'] === "SAVETOPGNLIBRARYPURE") {
  
  if(isset($_POST['SAVEFILE']))
  {
    $array = json_decode($_POST['SAVEFILE']);
    SavetoSQLPGNLibrary2($array);
    return;
  }
}

if($_POST['action'] === "GETFROMPGNLIBRARY") {
  
  $result = GetFromPGNLibrary();
  echo json_encode($result, JSON_UNESCAPED_UNICODE);
  return;
}

if($_POST['action'] === "GETFROMPGNLIBRARYPURE") {
  
  $result = GetFromPGNLibraryPURE();
  echo json_encode($result);
  return;
}

// intended to save pgn to text file, but putting in sql now
if($_POST['action'] === "SAVEDATAB") {
  
  if(!isset($_POST['databaseToSave']))
  {
    ConvertToSaveFile($_POST['databaseToSave']);
  }
}

if($_POST['action'] === "GETUPLOADEDFILELIST") {
  
  $dir = 'memory1';
  // Check if the directory exists
  if (file_exists($dir) && is_dir($dir) )
  {
    $scan_arr = scandir($dir);
    $files_arr = array_diff($scan_arr, array('.','..') );
    $resultArray = array();
    foreach ($files_arr as $file) {
        array_push($resultArray, $file);
      }
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
    return;
  }
  else
  {
    echo "Directory does not exist";
  }
}
  
?>