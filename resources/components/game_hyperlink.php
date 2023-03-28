<?php if($colour === 'white'): ?>
  <a
    class='p-2 rounded-lg flex justify-center items-center border border-black bg-white text-black'
    style='min-height: 100%; min-width: 100%;'
    href='<?=$href?>'>
    <?=$text?>
  </a>
<?php elseif($colour === 'black'): ?>
  <a
    class='p-2 rounded-lg flex justify-center items-center border border-black bg-black text-white'
    style='min-height: 100%; min-width: 100%;'
    href='<?=$href?>'>
    <?=$text?>
  </a>
<?php endif; ?>