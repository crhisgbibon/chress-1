<?php if($options): ?>
<div class='w-full flex justify-center items-center' style='max-height:calc(var(--vh) * 7.5)'>
  <div class='w-full max-w-xl flex flex-row justify-center items-center'>
    <?php foreach($options as $option): ?>
      <button class='border border-black rounded-lg mx-4'>
        <?php echo $option ?>
      </button>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>