<?php use App\Models\System\Component; ?>
<?php if(!isset($board) || count($board) !== 64 || !isset($gameid)): ?>
  <div
    class='flex flex-col justify-start items-center w-full'>
    Board data not found.
  </div>
<?php else: ?>
  <div
    id='boardholder'
    data-gameid='<?=$gameid?>'
    x-data="{

    }"
    :style="flip ?
    'min-width: 320px;min-height: 320px;height: calc(var(--square) * 8);width: calc(var(--square) * 8);transform: rotate(180deg);'
    :
    'min-width: 320px; min-height: 320px;height: calc(var(--square) * 8);width: calc(var(--square) * 8);transform: rotate(0deg);'">
    <?php
      $alternate = false;
      $counter = 0;
      $rowCounter = 7;
      $colCounter = 0;
    ?>
    <?php for($x = 0; $x < 8; $x++): ?>
      <?php
        $alternate = !$alternate;
      ?>
      <?php for($y = 0; $y < 8; $y++): ?>
        <?php
          $alternate = !$alternate;
          $i = ($rowCounter * 8) + $colCounter;
        ?>
        <div id='s<?=$i?>'>
          <button id='b<?=$i?>'
          <?php
            $class = '';
            $colour = 'white';
            if($alternate)
            {
              $class = 'boardButton bg-sky-200';
              $colour = 'black';
            }
            else $class = 'boardButton bg-sky-50';
          ?>
          class='<?=$class?>'
          :style="flip ?
          'padding: 0;margin: 0;border:0;min-width: 40px;min-height: 40px;height: var(--square);width: var(--square);float: left;transform: rotate(180deg);'
          :
          'padding: 0;margin: 0;border:0;min-width: 40px;min-height: 40px;height: var(--square);width: var(--square);float: left;transform: rotate(0deg);'"
          data-index='<?=$i?>'
          data-piece='<?=$board[$i][1]?>'
          data-color='<?=$colour?>'
          data-move='no'
          onmousedown='Post(`query`,[<?=$i?>,<?=$gameid?>])' 
          >
            <?=Component::make('piece',['layer'=>$layer,'num'=>$i,'type'=>$board[$i][1]])?>
          </button>
        </div>
        <?php
          $colCounter++;
          $counter++;
        ?>
      <?php endfor; ?>
      <?php
        $rowCounter--;
        $colCounter = 0;
      ?>
    <?php endfor; ?>
  </div>
<?php endif; ?>