<div
  style='min-width: 320px; min-height: 320px;'
  x-data="{

  }">
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
            $class = 'bg-sky-200';
            $colour = 'black';
          }
          else $class = 'bg-sky-50';
        ?>
        class='<?=$class?>'
        style='padding: 0; margin: 0; width: 40px; min-height: 40px; float: left;'
        data-index='<?=$i?>'
        data-color='<?=$colour?>'>
          <img id='i<?=$i?>'
          src='assets/png/blank.png'>
          </img>
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