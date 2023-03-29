<input
  <?php if($version === 'submit'): ?>
    style='min-width: 100%; min-height: 100%;background-color:var(--low);'
    class='p-2 rounded-lg flex justify-center items-center
          hover:scale-105 active:scale-95'
  <?php elseif($version==='radio'): ?>
    class=''
    style='min-width: 100%; min-height: 100%;'
  <?php else: ?>
    style='min-width: 100%; min-height: 100%;'
    class='border border-black p-2 rounded-lg outline-transparent 
          hover:outline hover:outline-offset-2
          focus:outline focus:outline-offset-2
          active:outline active:outline-offset-2'
  <?php endif; ?>
  type='<?=$version?>' 
  id='<?=$uuid?>' 
  name='<?=$nom?>' 
  placeholder='<?=$place?>' 
  value='<?=$text?>' 
  autocomplete='<?=$auto?>'
  <?php if($check) echo'checked';?>>