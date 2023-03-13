<div id="lView">

  <div id="lOptions">
    <button class="lOptionsContent" id="lOptionsNewGame"> New Game </button>
  </div>

  <div id="lGames">

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
            $init = $turnTime - $timeSinceMoved;
            $minutes = (int)($init / 60);
            $hours = (int)($minutes / 60);
            $days = (int)($hours / 24);
            $hoursRemaining = (int)($hours % 24);
            $minutesRemaining = (int)($minutes % 60);
  
            $dateRemaining = $days . " days, " . $hoursRemaining . " hours, " . $minutesRemaining . " minutes remaining";
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
  
          if($gameCompleted === 0)
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
        echo "No active games.";
      }

    ?>

  </div>

  <div id="lLobby">

    <?php
      
      if(isset($lobby))
      {
        for($i = 0; $i < $count; $i++)
        {
          $uniqueIndex = $lobby[$i]["uniqueIndex"];
          $whiteID = $lobby[$i]["whiteID"];
          $blackID = $lobby[$i]["blackID"];
  
          $turnTime = $lobby[$i]["turnTime"];
          $lastMoved = $lobby[$i]["lastMoved"];
          $gameTurn = $lobby[$i]["gameTurn"];
  
          $gameCompleted = $lobby[$i]["gameCompleted"];
          $gameResult = $lobby[$i]["gameResult"];
  
          $whiteUser = $lobby[$i]["whiteUser"];
          $blackUser = $lobby[$i]["blackUser"];
  
          if($userID === (int)$whiteID || $userID === (int)$blackID)
          {
            $acceptOrCancel = "<button onclick='CancelChallenge({$uniqueIndex});'>Delete</button>";
          }
          else
          {
            $acceptOrCancel = "<button onclick='AcceptChallenge({$uniqueIndex});'>Accept</button>";
          }
  
          $timePerMove = (int)$turnTime / 60 / 60 / 24 . " Days";
  
          echo "
            <div class='lLobbyLobby'>
  
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
                Turn Time: {$timePerMove}
              </div>
  
              {$acceptOrCancel}
  
            </div>
          ";
        }
      }
      else
      {
        echo "Lobby is empty.";
      }

    ?>

  </div>

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

  <div id="lSwitch">
    <button id="lSwitchGames">Games</button>
    <button id="lSwitchLobby">Lobby</button>
    <button id="lSwitchHistory">History</button>
  </div>

  <div id="lNewGame">
    <div>
      Create New Game
    </div>

    <div>
      Choose Side:
    </div>

    <div class="lRadio">
      <input type="radio" id="lNewWhite" name="lNewColour" value="White" checked>
      <label for="White">White</label><br>
      <input type="radio" id="lNewBlack" name="lNewColour" value="Black">
      <label for="Black">Black</label><br>
      <input type="radio" id="lNewRandom" name="lNewColour" value="Random">
      <label for="Random">Random</label>
    </div>

    <div>
      Choose Opponent:
    </div>

    <div class="lRadio">
      <input type="radio" id="lNewSelf" name="lNewAgainst" value="Self" checked>
      <label for="Self">Self</label><br>
      <input type="radio" id="lNewComputer" name="lNewAgainst" value="Computer">
      <label for="Computer">Computer</label><br>
      <input type="radio" id="lNewPlayer" name="lNewAgainst" value="Player">
      <label for="Player">Player</label>
    </div>

    <div>
      Choose Turn Time (Days):
    </div>

    <div class="lRadio">
      <input type="radio" id="lNewOne" name="lNewTurn" value="One" checked>
      <label for="One">One</label><br>
      <input type="radio" id="lNewThree" name="lNewTurn" value="Three">
      <label for="Three">Three</label><br>
      <input type="radio" id="lNewSeven" name="lNewTurn" value="Seven">
      <label for="Seven">Seven</label>
    </div>

    <button id="lNewCreate" onclick='Post("NEWGAME");'>Create</button>

    <button id="lNewClose" onclick='TogglePanel(lNewGame);'>Close</button>

  </div>

</div>