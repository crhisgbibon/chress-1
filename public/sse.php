<?php

declare(strict_types=1);

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

use App\Models\Chress\GamesModel;


header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Access-Control-Allow-Origin: *');

if(!isset($_SESSION)) session_start();

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