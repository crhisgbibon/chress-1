<div id="lHistory">

<?php

  if(isset($games))
  {
    for($i = 0; $i < $count; $i++)
    {
      $uniqueIndex = $games[$i]["uniqueIndex"];
      $whiteID = $games[$i]["whiteID"];
      $blackID = $games[$i]["blackID"];

      $turnTime = $games[$i]["turnTime"];
      $lastMoved = $games[$i]["lastMoved"];
      $gameTurn = $games[$i]["gameTurn"];

      $gameCompleted = $games[$i]["gameCompleted"];
      $gameResult = $games[$i]["gameResult"];

      $whiteUser = $games[$i]["whiteUser"];
      $blackUser = $games[$i]["blackUser"];

      $now = strtotime("now");
      $timeSinceMoved = $now - $lastMoved;
      if($timeSinceMoved < $turnTime)
      {
        $init = $timeSinceMoved;
        $hours = (int)floor($init / 3600);
        $minutes = (int)floor((int)($init / 60) % 60);
        $seconds = (int)$init % 60;

        $dateRemaining = $hours .":". $minutes .":". $seconds;

        $dateRemaining .= " Move Time Remaining";
      }
      else
      {
        $dateRemaining = "Time Expired";
      }

      if($dateRemaining === "Time Expired")
      {
        $sideToMove = "";
      }
      else
      {
        $sideToMove = "White To Move";
        if($gameTurn === "1")
        {
          $sideToMove = "Black To Move";
        }
      }

      if($gameCompleted === "0")
      {
        $manageGame = "
          <button onclick='ViewGame({$uniqueIndex});'>View</button>
          <button onclick='ResignGame({$uniqueIndex});'>Resign</button>
        ";
      }
      else
      {
        if($gameResult === $whiteID)
        {
          $manageGame = $whiteUser . " Won
          <button onclick='ViewGame({$uniqueIndex});'>View</button>
          ";
        }
        else if($gameResult === $blackID)
        {
          $manageGame = $blackUser . " Won
          <button onclick='ViewGame({$uniqueIndex});'>View</button>
          ";
        }
        else
        {
          $manageGame = "Game Drawn
          <button onclick='ViewGame({$uniqueIndex});'>View</button>
          ";
        }
      }

      echo "
        <div class='lLobbyGame'>

          <div>
            Game Number: {$uniqueIndex}
          </div>

          <div>
            White : {$whiteUser}
          </div>

          <div>
            Black : {$blackUser}
          </div>

          <div>
            {$dateRemaining}
          </div>

          <div>
            {$sideToMove}
          </div>

          {$manageGame}

        </div>
      ";
    }
  }
  else
  {
    echo "No game history.";
  }

?>

</div>