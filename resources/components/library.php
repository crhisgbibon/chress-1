<?php use App\Models\System\Component; ?>
<?php 
  $c = count($games);
  if($c === 0):
?>
  <div
    class='flex flex-col justify-start items-center overflow-y-auto'
    style='min-height: 100%; min-width: 100%'>
    No games found.
  </div>
<?php else: ?>
  <div
    class='flex flex-col justify-start items-center overflow-y-auto'
    style='min-height: 100%; min-width: 100%'>
    <?php for($i = 0; $i < count($games); $i++): ?>

      <?php
        $days = 0;
        $timeRemaining = 0;
        $uuid = $games[$i]['uniqueIndex'];
        $turnTime = $games[$i]["turnTime"];
        $lastMoved = $games[$i]["lastMoved"];
        $gameTurn = $games[$i]["gameTurn"];

        $href = "/games/{$uuid}";

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

          if($days > 1) $timeRemaining = $days . ' Days';
          else if($days === 1) $timeRemaining = $days . ' Day';
          else if($days === 0 && $hoursRemaining > 1) $timeRemaining = $hoursRemaining . ' Hours';
          else if($days === 0 && $hoursRemaining === 1) $timeRemaining = $hoursRemaining . ' Hour';
          else if($days === 0 && $hoursRemaining === 0 && $minutesRemaining > 1) $timeRemaining = $minutesRemaining . ' Minutes';
          else if($days === 0 && $hoursRemaining === 0 && $minutesRemaining === 1) $timeRemaining = $minutesRemaining . ' Minute';
        }
        else
        {
          $timeRemaining = "Expired";
        }
      ?>

      <div
        style='border-color: var(--high);'
        class='p-2 my-2 w-full max-w-xs flex flex-row justify-around items-center border rounded-lg box-border'>

        <div
          class='mx-2 flex justify-center items-center w-1/3 truncate'>
          #<?=$uuid?>
        </div>

        <div
          class='mx-2 flex justify-center items-center w-1/3 truncate'>
          <?php if($user === $games[$i]['whiteID']): ?>
            <?php $value = ($games[$i]['blackID'] === -1) ? 'Computer' : $games[$i]['black_username']; ?>

            <?php if($gameTurn === 0): ?>
              <?=Component::make('game_hyperlink',['href'=>$href,'text'=>$value,'turn'=>'yes'])?>
            <?php else: ?>
              <?=Component::make('game_hyperlink',['href'=>$href,'text'=>$value,'turn'=>'no'])?>
            <?php endif; ?>

          <?php else: ?>
            <?php $value = ($games[$i]['whiteID'] === -1) ? 'Computer' : $games[$i]['white_username']; ?>

            <?php if($gameTurn === 1): ?>
              <?=Component::make('game_hyperlink',['href'=>$href,'text'=>$value,'turn'=>'yes'])?>
            <?php else: ?>
              <?=Component::make('game_hyperlink',['href'=>$href,'text'=>$value,'turn'=>'no'])?>
            <?php endif; ?>

          <?php endif; ?>
        </div>

        <div
          <?php if($days === 0): ?>
            style='color: var(--warning);'
          <?php endif; ?>
          class='mx-2 flex justify-center items-center w-1/3 truncate'>
          <?=$timeRemaining?>
        </div>

      </div>

    <?php endfor; ?>
  </div>
<?php endif; ?>