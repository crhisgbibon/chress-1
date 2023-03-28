<img
  id='i<?=$num?>'
  class='piece'
  style=''

  <?php if($type === 'WR'):?>
    src='<?=$layer?>assets/png/whiteRook.png'
  <?php elseif($type === 'WK'):?>
    src='<?=$layer?>assets/png/whiteKnight.png'
  <?php elseif($type === 'WB'):?>
    src='<?=$layer?>assets/png/whiteBishop.png'
  <?php elseif($type === 'WQ'):?>
    src='<?=$layer?>assets/png/whiteQueen.png'
  <?php elseif($type === 'WX'):?>
    src='<?=$layer?>assets/png/whiteKing.png'
  <?php elseif($type === 'WP'):?>
    src='<?=$layer?>assets/png/whitePawn.png'

  <?php elseif($type === 'BR'):?>
    src='<?=$layer?>assets/png/blackRook.png'
  <?php elseif($type === 'BK'):?>
    src='<?=$layer?>assets/png/blackKnight.png'
  <?php elseif($type === 'BB'):?>
    src='<?=$layer?>assets/png/blackBishop.png'
  <?php elseif($type === 'BQ'):?>
    src='<?=$layer?>assets/png/blackQueen.png'
  <?php elseif($type === 'BX'):?>
    src='<?=$layer?>assets/png/blackKing.png'
  <?php elseif($type === 'BP'):?>
    src='<?=$layer?>assets/png/blackPawn.png'

  <?php endif;?>
  >
  <!-- <div style='z-index: 50; color: red;'><?=$num?></div> -->
</img>