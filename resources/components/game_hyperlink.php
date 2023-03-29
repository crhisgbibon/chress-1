<?php if($turn === 'yes'): ?>
  <a
    class='p-2 rounded-lg flex justify-center items-center border'
    style='min-height: 100%; min-width: 100%;border-color: var(--low);background-color: var(--low);'
    href='<?=$href?>'>
    <?=$text?>
  </a>
<?php elseif($turn === 'no'): ?>
  <a
    class='p-2 rounded-lg flex justify-center items-center border'
    style='min-height: 100%; min-width: 100%;border-color: var(--full);'
    href='<?=$href?>'>
    <?=$text?>
  </a>
<?php endif; ?>