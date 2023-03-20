<img
  id='i<?=$num?>'
  style='min-height: 100%; min-width: 100%'

  <?php if($type === 'WR'):?>
    src='./assets/png/whiteRook.png'
  <?php elseif($type === 'WK'):?>
    src='./assets/png/whiteKnight.png'
  <?php elseif($type === 'WB'):?>
    src='./assets/png/whiteBishop.png'
  <?php elseif($type === 'WQ'):?>
    src='./assets/png/whiteQueen.png'
  <?php elseif($type === 'WX'):?>
    src='./assets/png/whiteKing.png'
  <?php elseif($type === 'WP'):?>
    src='./assets/png/whitePawn.png'

  <?php elseif($type === 'BR'):?>
    src='./assets/png/blackRook.png'
  <?php elseif($type === 'BK'):?>
    src='./assets/png/blackKnight.png'
  <?php elseif($type === 'BB'):?>
    src='./assets/png/blackBishop.png'
  <?php elseif($type === 'BQ'):?>
    src='./assets/png/blackQueen.png'
  <?php elseif($type === 'BX'):?>
    src='./assets/png/blackKing.png'
  <?php elseif($type === 'BP'):?>
    src='./assets/png/blackPawn.png'

  <?php endif;?>
  >
</img>