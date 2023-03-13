<?php

session_start();

function ConvertPGNToArray($sourceName)
{
  $file1 = file_get_contents($sourceName);
  
  $fileArray = explode("[Event ",$file1);
  $fileArray = array_filter($fileArray);
  $fileArray = array_values($fileArray);
  $fLen = count($fileArray);
  //print_r($fLen);
  $saveArray = array();
  
  for($i = 0; $i < $fLen; $i++)
  {
    if($fileArray[$i] == null) continue;
    $fLength = strlen($fileArray[$i]);
    if($fLength == 0) continue;
    
    // split the meta information out
    $findPos = strrpos($fileArray[$i],"]");
    $metaInfo = substr($fileArray[$i], 0, ($findPos + 1));
    //print_r($metaInfo);
    
    // split the game information out
    $gameInfo = substr($fileArray[$i], ($findPos + 1));
    $gameInfo1 = trim(preg_replace('/\+/', '', $gameInfo));
    $gameInfo2 = trim(preg_replace('/\x/', '', $gameInfo1));
    // seperate it by move
    $gameArray = explode(".",$gameInfo2);
    $gameArray = array_filter($gameArray);
    $gameArray = array_values($gameArray);
    //print_r($gameArray);
    $moveArray = array();
    $gLen = count($gameArray);
    // process each move
    for($g = 0; $g < $gLen; $g++)
    {
      if($g == 0)
      {
        $gameArray[$g] = null;
        continue;
      }
      //print_r($gameArray[$g] . " /  ");
      $string = preg_replace('/\s+/', ' ', trim($gameArray[$g]));
      //print_r($string);
      $pointToSplit = explode(" ", $string);
      $pointToSplit = array_filter($pointToSplit);
      $pointToSplit = array_values($pointToSplit);
      //print_r($pointToSplit);
      $pCount = count($pointToSplit);
      $whiteTurn = $pointToSplit[0];
      $whiteTurn = trim($whiteTurn);
      $blackTurn = "-1";
      if($pCount > 0 && $pointToSplit[1] != null)
      {
        $blackTurn = $pointToSplit[1];
        $blackTurn = trim($blackTurn);
      }
      // the isolated moves per turn, still need to be split into piece and square to move to
      //print_r($whiteTurn);
      //print_r($blackTurn);
      $newMove = array();
      array_push($newMove, $whiteTurn);
      array_push($newMove, $blackTurn);
      $gameArray[$g] = $newMove;
      //print_r($gameArray[$g]);
      
      // WHITE
      if($gameArray[$g][0] != "O-O" && $gameArray[$g][0] != "O-O-O")
      {
        // extract the move to information, remainder is piece information
        $whitePiece = substr($gameArray[$g][0], 0, -2);
        if(strlen($whitePiece) == 0) $whitePiece = "P";
        $whiteSquare = substr($gameArray[$g][0], -2);
      }
      else
      {
        $whitePiece = "X";
        $whiteSquare = $gameArray[$g][0];
      }
      $nextArray = array();
      array_push($nextArray, $whitePiece);
      array_push($nextArray, $whiteSquare);
      $gameArray[$g][0] = $nextArray;
      
      // BLACK
      if($gameArray[$g][1] != "-1" && $gameArray[$g][1] != "1-0" && $gameArray[$g][1] != "0-1"&& $gameArray[$g][1] != "1/2-1/2")
      {
        if($gameArray[$g][1] != "O-O" && $gameArray[$g][1] != "O-O-O")
        {
          $blackPiece = substr($gameArray[$g][1], 0, -2);
          if(strlen($blackPiece) == 0) $blackPiece = "P";
          $blackSquare = substr($gameArray[$g][1], -2);
        }
        else
        {
          $blackPiece = "X";
          $blackSquare = $gameArray[$g][1];
        }
        $nextArray1 = array();
        array_push($nextArray1, $blackPiece);
        array_push($nextArray1, $blackSquare);
        $gameArray[$g][1] = $nextArray1;
      }
      else
      {
        $gameArray[$g][1] = "-1";
      }
      //print_r($gameArray[$g]);
    }
    $gameArray = array_filter($gameArray);
    $gameArray = array_values($gameArray);
    $resultArray = array();
    array_push($resultArray, $gameArray);
    array_push($resultArray, $metaInfo);
    array_push($saveArray, $resultArray);
  }
  return $saveArray;
}

function ConvertPGNToArrayPure($sourceName)
{
  $file1 = file_get_contents($sourceName);
  $file1 = trim(preg_replace('/\+/', '', $file1));
  $file1 = trim(preg_replace('/\x/', '', $file1));
  $file1 = preg_replace('/\s+/', ' ', trim($file1));
  
  $fileArray = explode("[Event ",$file1);
  $fileArray = array_filter($fileArray);
  $fileArray = array_values($fileArray);
  $fLen = count($fileArray);
  for($i = 0; $i < $fLen; $i++)
  {
    $fileArray[$i] = "[Event " . $fileArray[$i];
  }
  return $fileArray;
}

function ConvertToSaveFile($array)
{
  $aLen = count($fileArray);
  $resultArray = array();
  
  for($i = 0; $i < $aLen; $i++)
  {
    $wordLength = strlen($fileArray[$i]);
    if($wordLength == 5)
    {
      if(ctype_alpha($fileArray[$i])){
          $result = array(strtoupper($fileArray[$i]), 0);
          array_push($resultArray, $result);
      }
    }
  }

  $resultArray = ScoreArray($resultArray);
  usort($resultArray, 'cmpScore');
  
  $returnFile = fopen($fileName, "w");
  $str1 = create_string($resultArray);
  fwrite($returnFile, $str1);
}

function SavetoSQLPGNLibrary($array)
{
  global $servername, $username, $password, $database;
  $aLen = count($array);
  
  // [i][0] = the game string
  // print_r($array[0][0]);
  // [i][1] = the game result - DONT USE
  //print_r($array[0][1]);
  // [i][2] = the event
  //print_r($array[0][2]);
  // [i][3] = the site
  //print_r($array[0][3]);
  // [i][4] = the date
  //print_r($array[0][4]);
  // [i][5] = the round
  //print_r($array[0][5]);
  // [i][6] = the white player
  //print_r($array[0][6]);
  // [i][7] = the black player
  //print_r($array[0][7]);
  // [i][8] = the game result
  //print_r($array[0][8]);
  
  $connString = "mysql:host=$servername;dbname=".$database."";
  $conn = new PDO($connString, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $conn->prepare("INSERT INTO chess_pgn_library (event, site, date, round, white, black, result, game, hash)
    VALUES (:eventID, :siteID, :dateID, :roundID, :whiteID, :blackID, :resultID, :gameID, :hashID) ON DUPLICATE KEY UPDATE
    event = :eventID,
    site = :siteID,
    date = :dateID,
    round = :roundID,
    white = :whiteID,
    black = :blackID,
    result = :resultID,
    game = :gameID
    hash = :hashID");
  
  for($i = 0; $i < $aLen; $i+= 5)
  {
    try
    {
      $stmt->bindParam(':eventID', $event);
      $stmt->bindParam(':siteID', $site);
      $stmt->bindParam(':dateID', $date);
      $stmt->bindParam(':roundID', $round);
      $stmt->bindParam(':whiteID', $white);
      $stmt->bindParam(':blackID', $black);
      $stmt->bindParam(':resultID', $result);
      $stmt->bindParam(':gameID', $gameArray);
      $stmt->bindParam(':hashID', $gameArray);
      
      if($i < $aLen)
      {
        $event = $array[$i][2];
        $site = $array[$i][3];
        $date = $array[$i][4];
        $round = $array[$i][5];
        $white = $array[$i][6];
        $black = $array[$i][7];
        $result = $array[$i][8];
        $gameArray = json_encode($array[$i][0], JSON_UNESCAPED_UNICODE);
        $stmt->execute();
      }
      if(($i + 1) < $aLen)
      {
        $event = $array[$i + 1][2];
        $site = $array[$i + 1][3];
        $date = $array[$i + 1][4];
        $round = $array[$i + 1][5];
        $white = $array[$i + 1][6];
        $black = $array[$i + 1][7];
        $result = $array[$i + 1][8];
        $gameArray = json_encode($array[$i][0], JSON_UNESCAPED_UNICODE);
        $stmt->execute();
      }
      if(($i + 2) < $aLen)
      {
        $event = $array[$i + 2][2];
        $site = $array[$i + 2][3];
        $date = $array[$i + 2][4];
        $round = $array[$i + 2][5];
        $white = $array[$i + 2][6];
        $black = $array[$i + 2][7];
        $result = $array[$i + 2][8];
        $gameArray = json_encode($array[$i][0], JSON_UNESCAPED_UNICODE);
        $stmt->execute();
      }
      if(($i + 3) < $aLen)
      {
        $event = $array[$i + 3][2];
        $site = $array[$i + 3][3];
        $date = $array[$i + 3][4];
        $round = $array[$i + 3][5];
        $white = $array[$i + 3][6];
        $black = $array[$i + 3][7];
        $result = $array[$i + 3][8];
        $gameArray = json_encode($array[$i][0], JSON_UNESCAPED_UNICODE);
        $stmt->execute();
      }
      if(($i + 4) < $aLen)
      {
        $event = $array[$i + 4][2];
        $site = $array[$i + 4][3];
        $date = $array[$i + 4][4];
        $round = $array[$i + 4][5];
        $white = $array[$i + 4][6];
        $black = $array[$i + 4][7];
        $result = $array[$i + 4][8];
        $gameArray = json_encode($array[$i][0], JSON_UNESCAPED_UNICODE);
        $stmt->execute();
      }
    }
    catch(PDOException $e)
    {
      echo("Connection failed: " . $e->getMessage() . "\n");
    }
  }
  $conn = null;
}

function GetFromPGNLibrary()
{
  global $servername, $username, $password, $database;
  
  $connString = "mysql:host=$servername;dbname=".$database."";
  $conn = new PDO($connString, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  try
  {
    $player = "nakamura";
    $stmt = $conn->prepare("SELECT game, result, event, site, date, round, white, black FROM chess_pgn_library
    WHERE `white` LIKE '%{$player}%'
    OR `black` LIKE '%{$player}%'");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $conn = null;
    return $result;
  }
  catch(PDOException $e)
  {
    echo("Connection failed: " . $e->getMessage() . "\n");
  }
}






function SavetoSQLPGNLibrary2($array)
{
  global $servername, $username, $password, $database;
  $aLen = count($array);
  
  $connString = "mysql:host=$servername;dbname=".$database."";
  $conn = new PDO($connString, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $conn->prepare("INSERT INTO chess_pgn (event, site, date, round, white, black, result, game, hash)
    VALUES (:eventID, :siteID, :dateID, :roundID, :whiteID, :blackID, :resultID, :gameID, :hashID) ON DUPLICATE KEY UPDATE
    event = :eventID,
    site = :siteID,
    date = :dateID,
    round = :roundID,
    white = :whiteID,
    black = :blackID,
    result = :resultID,
    game = :gameID,
    hash = :hashID");
  
  for($i = 0; $i < $aLen; $i+= 5)
  {
    try
    {
      $stmt->bindParam(':eventID', $event);
      $stmt->bindParam(':siteID', $site);
      $stmt->bindParam(':dateID', $date);
      $stmt->bindParam(':roundID', $round);
      $stmt->bindParam(':whiteID', $white);
      $stmt->bindParam(':blackID', $black);
      $stmt->bindParam(':resultID', $result);
      $stmt->bindParam(':gameID', $gameArray);
      $stmt->bindParam(':hashID', $hash);
      
      if($i < $aLen)
      {
        $event = $array[$i][1];
        $site = $array[$i][2];
        $date = $array[$i][3];
        $round = $array[$i][4];
        $white = $array[$i][5];
        $black = $array[$i][6];
        $result = $array[$i][7];
        $gameArray = json_encode($array[$i][8], JSON_UNESCAPED_UNICODE);
        $hash = $event . $site . $date . $round . $white . $black . $result;
        $stmt->execute();
      }
      if(($i + 1) < $aLen)
      {
        $event = $array[$i + 1][1];
        $site = $array[$i + 1][2];
        $date = $array[$i + 1][3];
        $round = $array[$i + 1][4];
        $white = $array[$i + 1][5];
        $black = $array[$i + 1][6];
        $result = $array[$i + 1][7];
        $gameArray = json_encode($array[$i + 1][8], JSON_UNESCAPED_UNICODE);
        $hash = $event . $site . $date . $round . $white . $black . $result;
        $stmt->execute();
      }
      if(($i + 2) < $aLen)
      {
        $event = $array[$i + 2][1];
        $site = $array[$i + 2][2];
        $date = $array[$i + 2][3];
        $round = $array[$i + 2][4];
        $white = $array[$i + 2][5];
        $black = $array[$i + 2][6];
        $result = $array[$i + 2][7];
        $gameArray = json_encode($array[$i + 2][8], JSON_UNESCAPED_UNICODE);
        $hash = $event . $site . $date . $round . $white . $black . $result;
        $stmt->execute();
      }
      if(($i + 3) < $aLen)
      {
        $event = $array[$i + 3][1];
        $site = $array[$i + 3][2];
        $date = $array[$i + 3][3];
        $round = $array[$i + 3][4];
        $white = $array[$i + 3][5];
        $black = $array[$i + 3][6];
        $result = $array[$i + 3][7];
        $gameArray = json_encode($array[$i + 3][8], JSON_UNESCAPED_UNICODE);
        $hash = $event . $site . $date . $round . $white . $black . $result;
        $stmt->execute();
      }
      if(($i + 4) < $aLen)
      {
        $event = $array[$i + 4][1];
        $site = $array[$i + 4][2];
        $date = $array[$i + 4][3];
        $round = $array[$i + 4][4];
        $white = $array[$i + 4][5];
        $black = $array[$i + 4][6];
        $result = $array[$i + 4][7];
        $gameArray = json_encode($array[$i + 4][8], JSON_UNESCAPED_UNICODE);
        $hash = $event . $site . $date . $round . $white . $black . $result;
        $stmt->execute();
      }
    }
    catch(PDOException $e)
    {
      echo("Connection failed: " . $e->getMessage() . "\n");
    }
  }
  $conn = null;
}



function GetFromPGNLibraryPURE()
{
  global $servername, $username, $password, $database;
  
  $connString = "mysql:host=$servername;dbname=".$database."";
  $conn = new PDO($connString, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  try
  {
    $stmt = $conn->prepare("SELECT game FROM chess_pgn");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $rLen = count($result);
    
    for($i = 0; $i < $rLen; $i++)
    {
      $result[$i] = json_decode($result[$i]);
    }
    
    $conn = null;
    return $result;
  }
  catch(PDOException $e)
  {
    echo("Connection failed: " . $e->getMessage() . "\n");
  }
}

?>