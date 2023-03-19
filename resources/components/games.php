<?php use App\Models\System\Component; ?>
<div
  class='inline-block overflow-y-auto'
  style='min-height: 100%; min-width: 100%'>
  <?php for($i = 0; $i < count($games); $i++): ?>

    <div
      class='float-left p-2 m-2 max-w-xs flex flex-col justify-start items-center my-4 border-2 border-sky-200 rounded-lg'>

      <div
        class='w-full flex flex-row justify-center items-center m-2 border-b border-black'>
        <div
          class='w-full m-2 flex justify-center items-center'>
          White
        </div>

        <div
          class='w-full m-2 flex justify-center items-center'>
        </div>

        <div
          class='w-full m-2 flex justify-center items-center'>
          Black
        </div>
      </div>

      <div
        class='w-full flex flex-row justify-center items-center m-2  border-b border-black'>
        <div
          class='w-full mx-2 flex justify-center items-center'>
          <?php 
            if((int)$games[$i]['whiteID'] > 0) echo $games[$i]['user_alias'];
            else echo '?';
          ?>
        </div>

        <div
          class='w-full mx-2 flex justify-center items-center'>
          vs
        </div>

        <div
          class='w-full mx-2 flex justify-center items-center'>
          <?php 
            if((int)$games[$i]['blackID'] > 0) echo $games[$i]['user_alias'];
            else echo '?';
          ?>
        </div>

      </div>

      <?php
        $dateRemaining = 0;
        $turnTime = $games[$i]["turnTime"];
        $lastMoved = $games[$i]["lastMoved"];
        $gameTurn = $games[$i]["gameTurn"];

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

          $dateRemaining = $days . "d, " . $hoursRemaining . "h, " . $minutesRemaining . "m";
        }
        else
        {
          $dateRemaining = "Expired";
        }

        if($dateRemaining === "Expired")
        {
          $sideToMove = "";
        }
        else
        {
          $sideToMove = "White";
          if($gameTurn === "1")
          {
            $sideToMove = "Black";
          }
        }
      ?>

      <div
        class='w-full flex flex-row justify-center items-center m-2  border-b border-black'>
        <div
          class='w-full mx-2 flex justify-center items-center'>
          <?=$dateRemaining?>
        </div>

        <div
          class='w-full m-2 flex justify-center items-center'>
        </div>

        <div
          class='w-full mx-2 flex justify-center items-center'>
          <?=$sideToMove?>
        </div>

      </div>

      <div
        class='w-full mx-2 flex flex-row justify-between items-center'>
        <div
          class='p-2 m-2 flex justify-center items-center'>
          <form
            method='POST'
            action='play/view'
            class='w-full h-full'>
            <input type='number' name='uuid' value='<?=$games[$i]['uniqueIndex']?>' hidden>
            <?=Component::make('input',['version'=>'submit','uuid'=>'','nom'=>'','place'=>'','text'=>'View','auto'=>'','check'=>false])?>
          </form>
        </div>
        <div
          class='p-2 m-2 flex justify-center items-center'>
          <form
            method='POST'
            action='lobby/resign'
            class='w-full h-full'>
            <input type='number' name='uuid' value='<?=$games[$i]['uniqueIndex']?>' hidden>
            <?=Component::make('input',['version'=>'submit','uuid'=>'','nom'=>'','place'=>'','text'=>'Resign','auto'=>'','check'=>false])?>
          </form>
        </div>
      </div>

    </div>

  <?php endfor; ?>
</div>