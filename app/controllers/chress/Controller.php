<?php

if(!isset($_SESSION)) session_start();

require_once __DIR__ . "/../Main.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/generic/php/controller/GenericController.php";

$config = new Config();

// LIBRARY FUNCTIONS

if($_POST['action'] === 'GETLISTS')
{
  $db = new Database($config);
  $model = new ListModel($db, (int)$_SESSION["id"]);

  $output = $model->GetLists();

  echo json_encode($output);
}

if($_POST['action'] === 'QUERYLIBRARY')
{
  if($_POST["data"] === null) return;
  array_push($_POST["data"], $_SESSION["OFFSET"]);

  $_SESSION["PGN"] = true;

  $db = new Database($config);
  $model = new LibraryModel($db, (int)$_SESSION["id"]);
  $pgnIndexes = $model->GetIndexes($_POST["data"]);

  $c = count($pgnIndexes);
  $_SESSION["library"] = serialize($pgnIndexes);
  $_SESSION["currentPGN"] = 0;
  $_SESSION["totalPGN"] = $c;

  $library = unserialize($_SESSION["library"]);
  $metaInfo = $model->GetPGNList($pgnIndexes);

  $lView = new LibraryView();
  $lContents = $lView->PrintContents($metaInfo);

  echo json_encode($lContents);
}

if($_POST['action'] === 'SHOWGAME')
{
  if($_POST["data"] === null) return;

  $_SESSION["PGN"] = true;

  $db = new Database($config);
  $model = new LibraryModel($db, (int)$_SESSION["id"]);
  $library = unserialize($_SESSION["library"]);
  $pgnFile = $model->GetPGN((int)$_POST["data"][0]);

  $pgnModel = new PGNModel();
  $game = $pgnModel->PGNToGame($pgnFile);

  $gameData = $game->GetGameData((int)$_SESSION["id"]);
  $output = [$_SESSION["currentPGN"] + 1, $_SESSION["totalPGN"], $gameData, $_SESSION["PGN"]];
  echo json_encode($output);
  $_SESSION["pgnFile"] = serialize($game);
}

// PLAY VIEW

if($_POST['action'] === 'GETACTIVEGAMES')
{
  $db = new Database($config);
  $model = new PlayModel($db, (int)$_SESSION["id"]);

  $games = $model->GetActiveGames();
  $c = count($games);

  $_SESSION["OFFSET"] = 0;
  $_SESSION["PGN"] = false;

  $_SESSION["library"] = serialize([]);
  $_SESSION["currentPGN"] = 0;
  $_SESSION["totalPGN"] = 0;

  if($c > 0)
  {
    $_SESSION["games"] = serialize($games);
    $_SESSION["currentGame"] = 0;
    $_SESSION["totalGames"] = $c;

    $games = unserialize($_SESSION["games"]);
    $index = $games[$_SESSION["currentGame"]]["uniqueIndex"];

    $game = $model->GetGame($index);

    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $output = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];
    echo json_encode($output);
  }
  else
  {
    $_SESSION["games"] = serialize($games);
    $_SESSION["currentGame"] = 0;
    $_SESSION["totalGames"] = 0;

    $output = [0, 0, [], $_SESSION["PGN"]];
  
    echo json_encode($output);
  }
}

if($_POST['action'] === 'NEXTGAME' || $_POST['action'] === 'LASTGAME')
{
  $db = new Database($config);
  $model = new PlayModel($db, (int)$_SESSION["id"]);

  if($_SESSION["PGN"] === false)
  {
    if($_SESSION["totalGames"] === 0) return;

    if($_POST['action'] === 'NEXTGAME')
    {
      $_SESSION["currentGame"]++;
      if($_SESSION["currentGame"] > ($_SESSION["totalGames"] - 1)) $_SESSION["currentGame"] = 0;
    }
    else if($_POST['action'] === 'LASTGAME')
    {
      $_SESSION["currentGame"]--;
      if($_SESSION["currentGame"] < 0) $_SESSION["currentGame"] = $_SESSION["totalGames"] - 1;
    }

    $games = unserialize($_SESSION["games"]);
    $index = $games[$_SESSION["currentGame"]]["uniqueIndex"];
    $game = $model->GetGame($index);

    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $output = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];
  }
  else
  {
    if($_SESSION["totalPGN"] === 0) return;

    if($_POST['action'] === 'NEXTGAME')
    {
      $_SESSION["currentPGN"]++;
      if($_SESSION["currentPGN"] > ($_SESSION["totalPGN"] - 1)) $_SESSION["currentPGN"] = 0;
    }
    else if($_POST['action'] === 'LASTGAME')
    {
      $_SESSION["currentPGN"]--;
      if($_SESSION["currentPGN"] < 0) $_SESSION["currentPGN"] = $_SESSION["totalPGN"] - 1;
    }

    $libraryModel = new LibraryModel($db, (int)$_SESSION["id"]);
    $library = unserialize($_SESSION["library"]);
    $pgnFile = $libraryModel->GetPGN((int)$library[$_SESSION["currentPGN"]]);

    $pgnModel = new PGNModel();
    $game = $pgnModel->PGNToGame($pgnFile);
    $_SESSION["pgnFile"] = serialize($game);

    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $output = [$_SESSION["currentPGN"] + 1, $_SESSION["totalPGN"], $gameData, $_SESSION["PGN"]];
  }

  echo json_encode($output);
}

if($_POST['action'] === 'NEXTMOVE' || $_POST['action'] === 'LASTMOVE')
{
  $db = new Database($config);

  if($_SESSION["PGN"] === false)
  {
    if($_SESSION["totalGames"] === 0) return;

    $model = new PlayModel($db, (int)$_SESSION["id"]);
    $games = unserialize($_SESSION["games"]);
    $index = $games[(int)$_SESSION["currentGame"]]["uniqueIndex"];
    $game = $model->GetGame($index);

    $game->LoadState($_POST['action'], (int)$_SESSION["id"]);

    $model->SaveGame($game);

    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $output = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];
  }
  else
  {
    if($_SESSION["totalPGN"] === 0) return;

    $libraryModel = new LibraryModel($db, (int)$_SESSION["id"]);
    $library = unserialize($_SESSION["library"]);
    $pgnFile = $libraryModel->GetPGN((int)$library[$_SESSION["currentPGN"]]);

    $game = unserialize($_SESSION["pgnFile"]);

    $game->LoadState($_POST['action'], (int)$_SESSION["id"]);

    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $_SESSION["pgnFile"] = serialize($game);
    $output = [$_SESSION["currentPGN"] + 1, $_SESSION["totalPGN"], $gameData, $_SESSION["PGN"]];
  }
  
  echo json_encode($output);
}

if($_POST['action'] === 'NEWGAME')
{
  if($_POST["data"] === null) return json_encode([-1]);

  $db = new Database($config);
  $model = new PlayModel($db, (int)$_SESSION["id"]);

  $_SESSION["PGN"] = false;

  $newGameInt = $model->NewGame($_POST["data"]);

  $games = $model->GetActiveGames();
  $c = count($games);

  if($c > 0)
  {
    $_SESSION["games"] = serialize($games);
    $_SESSION["currentGame"] = $c-1;
    $_SESSION["totalGames"] = $c;

    $games = unserialize($_SESSION["games"]);
    $index = $games[(int)$_SESSION["currentGame"]]["uniqueIndex"];

    $game = $model->GetGame($index);
    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $output[0] = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];

    $model->ScanGames();
    $lobbyGames = $model->GetLobbyGames();
    $lobbyLobby = $model->GetLobbyChallenges();
    $lobbyHistory = $model->GetLobbyHistory();
    $lobby = new LobbyView((int)$_SESSION["id"]);

    $viewGames = $lobby->PrintGames($lobbyGames);
    $viewLobby = $lobby->PrintLobby($lobbyLobby);
    $viewHistory = $lobby->PrintHistory($lobbyHistory);

    $output[1] = [$viewGames, $viewLobby, $viewHistory];

    echo json_encode($output);
  }
  else
  {
    $output = [ [0, 0, [], $_SESSION["PGN"]], []];
  
    echo json_encode($output);
  }
}

if($_POST['action'] === 'VIEWGAME')
{
  if($_POST["data"] === null) return;

  $_SESSION["PGN"] = false;

  $db = new Database($config);
  $model = new PlayModel($db, (int)$_SESSION["id"]);

  $gameToLoad = (int)$_POST["data"][0];
  $games = unserialize($_SESSION["games"]);

  $c = count($games);
  $check = false;
  for($i = 0; $i < $c; $i++)
  {
    if($games[$i]["uniqueIndex"] === $gameToLoad)
    {
      $check = true;
    }
  }

  if($check === false)
  {
    $games[$c]["uniqueIndex"] = $gameToLoad;
    $_SESSION["totalGames"] = $c;
    $_SESSION["currentGame"] = $c - 1;
  }

  if($c > 0)
  {
    $game = $model->GetGame($games[(int)$_SESSION["currentGame"]]["uniqueIndex"]);
    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $output = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];
  
    $_SESSION["games"] = serialize($games);
    echo json_encode($output);
  }
  else
  {
    $output = [0, 0, [], $_SESSION["PGN"]];
    echo json_encode($output);
  }
}

if($_POST['action'] === 'RESIGNGAME')
{
  if($_POST["data"] === null) return;

  $db = new Database($config);
  $model = new PlayModel($db, (int)$_SESSION["id"]);

  $gameToResign = (int)$_POST["data"][0];
  $game = $model->ResignGame($gameToResign);

  $model->ScanGames();
  $lobbyGames = $model->GetLobbyGames();
  $lobbyLobby = $model->GetLobbyChallenges();
  $lobbyHistory = $model->GetLobbyHistory();
  $lobby = new LobbyView((int)$_SESSION["id"]);

  $viewGames = $lobby->PrintGames($lobbyGames);
  $viewLobby = $lobby->PrintLobby($lobbyLobby);
  $viewHistory = $lobby->PrintHistory($lobbyHistory);

  $output = [$viewGames, $viewLobby, $viewHistory];
}

if($_POST['action'] === 'SKIPTO')
{
  $db = new Database($config);

  if($_SESSION["PGN"] === false)
  {
    $model = new PlayModel($db, (int)$_SESSION["id"]);
    $games = unserialize($_SESSION["games"]);
    $index = $games[(int)$_SESSION["currentGame"]]["uniqueIndex"];
    $game = $model->GetGame($index);

    $skipTo = (int)$_POST["data"][0];
    $game->LoadState($skipTo, (int)$_SESSION["id"]);

    $model->SaveGame($game);

    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $output = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];
  }
  else
  {
    $libraryModel = new LibraryModel($db, (int)$_SESSION["id"]);
    $library = unserialize($_SESSION["library"]);
    $pgnFile = $libraryModel->GetPGN((int)$library[$_SESSION["currentPGN"]]);

    $game = unserialize($_SESSION["pgnFile"]);

    $skipTo = (string)$_POST["data"][0];
    $game->LoadState($skipTo, (int)$_SESSION["id"]);

    $gameData = $game->GetGameData((int)$_SESSION["id"]);
    $_SESSION["pgnFile"] = serialize($game);
    $output = [$_SESSION["currentPGN"] + 1, $_SESSION["totalPGN"], $gameData, $_SESSION["PGN"]];
  }
  
  echo json_encode($output);
}

if($_POST['action'] === 'SWAP')
{
  if($_SESSION["PGN"] === true)
  {
    $_SESSION["PGN"] = false;
  }
  else
  {
    $_SESSION["PGN"] = true;
  }

  $db = new Database($config);

  if($_SESSION["PGN"] === true)
  {
    if(isset($_SESSION["currentPGN"]) &&
    isset($_SESSION["library"])&&
    isset($_SESSION["totalPGN"]))
    {
      $libraryModel = new LibraryModel($db, (int)$_SESSION["id"]);
      $library = unserialize($_SESSION["library"]);
      if(count($library) === 0) $output = [];
      else
      {
        $pgnFile = $libraryModel->GetPGN((int)$library[$_SESSION["currentPGN"]]);

        $pgnModel = new PGNModel();
        $game = $pgnModel->PGNToGame($pgnFile);
        $_SESSION["pgnFile"] = serialize($game);
  
        $gameData = $game->GetGameData((int)$_SESSION["id"]);
        $output = [$_SESSION["currentPGN"] + 1, $_SESSION["totalPGN"], $gameData, $_SESSION["PGN"]];
      }
    }
    else
    {
      $output = [];
    }
  }
  else
  {
    if(isset($_SESSION["currentGame"]) && 
    isset($_SESSION["totalGames"]) && 
    isset($_SESSION["games"]))
    {
      $model = new PlayModel($db, (int)$_SESSION["id"]);

      $games = unserialize($_SESSION["games"]);
      if(count($games) === 0) $output = [];
      else
      {
        $index = $games[$_SESSION["currentGame"]]["uniqueIndex"];
        $game = $model->GetGame($index);
    
        $gameData = $game->GetGameData((int)$_SESSION["id"]);
        $output = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];
      }
    }
    else
    {
      $output = [];
    }
  }

  echo json_encode($output);
}

if($_POST['action'] === 'ACCEPTCHALLENGE')
{
  if($_POST["data"] === null) return;

  $db = new Database($config);
  $model = new PlayModel($db, (int)$_SESSION["id"]);

  $gameToAccept = (int)$_POST["data"][0];
  $model->AcceptChallenge($gameToAccept);

  $model->ScanGames();
  $lobbyGames = $model->GetLobbyGames();
  $lobbyLobby = $model->GetLobbyChallenges();
  $lobbyHistory = $model->GetLobbyHistory();
  $lobby = new LobbyView((int)$_SESSION["id"]);

  $viewGames = $lobby->PrintGames($lobbyGames);
  $viewLobby = $lobby->PrintLobby($lobbyLobby);
  $viewHistory = $lobby->PrintHistory($lobbyHistory);

  $output = [$viewGames, $viewLobby, $viewHistory];

  echo json_encode($output);
}

// GAME MOVES

if($_POST['action'] === 'QUERYSQUARE')
{
  if($_POST["data"] === null) return json_encode([-1]);

  if($_SESSION["PGN"] === true) return json_encode([-1]);

  $db = new Database($config);
  $model = new PlayModel($db, (int)$_SESSION["id"]);

  $games = unserialize($_SESSION["games"]);
  $index = $games[(int)$_SESSION["currentGame"]]["uniqueIndex"];

  $validate = $model->ValidateTurn($index);

  if($validate === true)
  {
    $game = $model->GetGame($index);
    $moves = $game->GetMoves($_POST["data"][0], (int)$_SESSION["id"]);
    $model->SaveGame($game);
  
    echo json_encode($moves);
  }
  else
  {
    echo json_encode([]);
  }
}

if($_POST['action'] === 'MOVEPIECE')
{
  if($_POST["data"] === null) return json_encode([0,0,[]]);

  if($_SESSION["PGN"] === true) return json_encode([0,0,[]]);

  $db = new Database($config);
  $model = new PlayModel($db, (int)$_SESSION["id"]);

  $games = unserialize($_SESSION["games"]);
  $index = $games[(int)$_SESSION["currentGame"]]["uniqueIndex"];

  $validate = $model->ValidateTurn($index);

  if($validate === true)
  {  
    $game = $model->GetGame((int)$index);
    $output = $game->MovePiece($_POST["data"], (int)$_SESSION["id"]);

    $changeTurn = $model->UpdateTurn($index, $output[5]);

    if($changeTurn === true)
    {
      $model->SaveGame($game);
  
      $gameData = $game->GetGameData((int)$_SESSION["id"]);
      $output = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];
      echo json_encode($output);
    }
    else
    {
      echo json_encode("Error updating turn");
    }
  }
  else
  {
    echo json_encode([]);
  }
}