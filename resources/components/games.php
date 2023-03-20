<?php use App\Models\System\Component; ?>
<div
  class='flex flex-col justify-start items-center overflow-y-auto'
  style='min-height: 100%; min-width: 100%'>
  <?php for($i = 0; $i < count($games); $i++): ?>

    <?php
      $timeRemaining = 0;
      $sideToMove = '';
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

        // $timeRemaining = $days . "d, " . $hoursRemaining . "h, " . $minutesRemaining . "m";
        $timeRemaining = 'Clock:<br>' . $hours . " hours<br>" . $minutesRemaining . ' minutes';
      }
      else
      {
        $timeRemaining = "Expired";
      }

      if($timeRemaining !== "Expired")
      {
        if($user === $games[$i]['whiteID'])
        {
          if((int)$gameTurn === 0) $sideToMove = 'Your turn.';
          else $sideToMove = 'Waiting.';
        }
        else
        {
          if((int)$gameTurn === 0) $sideToMove = 'Waiting.';
          else $sideToMove = 'Your turn.';
        }
      }
    ?>

    <div
      class='p-2 m-2 w-full max-w-xs flex flex-col justify-start items-center border border-black rounded-lg box-border'>

      <?php if($user === $games[$i]['whiteID']): ?>
        <form
          class='w-full h-10'
          method='POST'
          action='/game'>
          <input type='number' name='uuid' value='<?=$games[$i]['uniqueIndex']?>' hidden>
          <input
            class='w-full h-full flex justify-center items-center bg-white text-black border border-black rounded-lg cursor-pointer'
            type='submit' value='<?=$games[$i]['black_username']?>'>
        </form>
      <?php else: ?>
        <form
          class='w-full h-10'
          method='POST'
          action='/game'>
          <input type='number' name='uuid' value='<?=$games[$i]['uniqueIndex']?>' hidden>
          <input
            class='w-full h-full flex justify-center items-center bg-black text-white border border-black rounded-lg cursor-pointer'
            type='submit' value='<?=$games[$i]['white_username']?>'>
        </form>
      <?php endif; ?>

      <div
        class='w-full m-2 flex justify-center items-center'>
        <?=$sideToMove?>
      </div>

      <div
        class='w-full m-2 flex justify-center items-center'>
        <?=$timeRemaining?>
      </div>

    </div>

  <?php endfor; ?>
</div>