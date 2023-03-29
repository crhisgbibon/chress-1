<?php use App\Models\System\Component; ?>
<div
  class='flex flex-col justify-start items-center overflow-y-auto'
  style='min-height: 100%; min-width: 100%'>
  <?php for($i = 0; $i < count($games); $i++): ?>

    <?php

      $result = $games[$i]["gameResult"];
      $resultText = '';

      if((int)$result === -2) $resultText = "Draw";
      else if((int)$result === (int)$games[$i]['whiteID']) $resultText = 'White';
      else if((int)$result === (int)$games[$i]['blackID']) $resultText = 'Black';
    ?>

    <div
      class='p-2 m-2 w-full max-w-xs flex flex-col justify-start items-center border border-black rounded-lg box-border'>

      <?php if($user === $games[$i]['whiteID']): ?>
        <a
          class='w-full h-10 flex justify-center items-center text-black border rounded-lg cursor-pointer'
          style='border-color: var(--low);background-color: var(--low);'
          href='/games/<?=$games[$i]['uniqueIndex']?>'>
          <?php if($games[$i]['blackID'] === -1) echo 'Computer'; else echo $games[$i]['black_username']; ?>
        </a>
      <?php else: ?>
        <a
          class='w-full h-10 flex justify-center items-center text-black border rounded-lg cursor-pointer'
          style='border-color: var(--full);background-color: var(--full);'
          href='/games/<?=$games[$i]['uniqueIndex']?>'>
          <?php if($games[$i]['whiteID'] === -1) echo 'Computer'; else echo $games[$i]['white_username']; ?>
        </a>
      <?php endif; ?>

      <div
        class='w-full m-2 flex justify-center items-center'>
        Result: <?=$resultText?>
      </div>

    </div>

  <?php endfor; ?>
</div>