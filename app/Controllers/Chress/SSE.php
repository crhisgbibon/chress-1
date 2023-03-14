<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Access-Control-Allow-Origin: *');

if(!isset($_SESSION)) session_start();
require_once __DIR__ . "/../Main.php";

if($_SESSION["PGN"] === false)
{
  $config = new Config();
  $db = new Database($config);

  $uModel = new UpdateModel($db, (int)$_SESSION["id"]);
  $lobbyGames = $uModel->ScanLobbyGames();
  $lobbyLobby = $uModel->ScanLobbyLobby();

  $games = unserialize($_SESSION["games"]);
  $index = $games[(int)$_SESSION["currentGame"]]["uniqueIndex"];
  $pModel = new PlayModel($db, (int)$_SESSION["id"]);
  $game = $pModel->GetGame((int)$index);
  $gameData = $game->GetGameData((int)$_SESSION["id"]);

  $output1 = [$_SESSION["currentGame"] + 1, $_SESSION["totalGames"], $gameData, $_SESSION["PGN"]];

  $output = [$lobbyGames, $lobbyLobby, $output1];
}
else
{
  $output = [];
}

$event = "sse_ping";
$retry = "3000";

$data = [
  "output"=>$output,
];

$json = json_encode($data);

echo "event: {$event}\n";
echo "retry: {$retry}\n";
echo "data: {$json}";
echo "\n\n";