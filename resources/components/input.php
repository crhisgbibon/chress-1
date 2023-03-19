<input
  <?php if($version === 'submit'): ?>
    class='w-32 p-2 m-2 rounded-lg flex justify-center items-center
          bg-sky-50 hover:bg-sky-100 active:bg-sky-200
          hover:scale-105 active:scale-95'
  <?php elseif($version==='radio'): ?>
    class=''
  <?php else: ?>
    class='border border-black p-2 rounded-lg outline-transparent 
          hover:outline hover:outline-offset-2 hover:outline-sky-100
          focus:outline focus:outline-offset-2 focus:outline-sky-200
          active:outline active:outline-offset-2 active:outline-sky-300'
  <?php endif; ?>
  style='min-width: 100%; min-height: 100%;' 
  type='<?=$version?>' 
  id='<?=$uuid?>' 
  name='<?=$nom?>' 
  placeholder='<?=$place?>' 
  value='<?=$text?>' 
  autocomplete='<?=$auto?>'
  <?php if($check) echo'checked';?>>