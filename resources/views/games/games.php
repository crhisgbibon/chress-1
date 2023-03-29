<?php use App\Models\System\Component; ?>
<?php if(!$loggedin): ?>
  <div
    class='w-full flex flex-col justify-start items-center'>
    You must be logged in to view your games.
  </div>
<?php else: ?>
  <div
    x-data='{
      create:false,
    }'
    class='w-full flex flex-col justify-start items-center'>

    <div
      style='min-height: calc(var(--vh) * 7.5);'>
      <?=Component::make('button',['onclick'=>'create=!create','text'=>'Create'])?>
    </div>

    <div
      x-show='create'
      class='flex flex-col justify-start items-center fixed overflow-y-auto w-full'
      style='min-height: calc(var(--vh) * 85); max-height: calc(var(--vh) * 85); top: calc(var(--vh) * 15); z-index: 10; background-color: var(--back);'>
      <?=Component::make('create',[])?>
    </div>

    <div
      id='games'
      class='w-full overflow-y-auto flex flex-col justify-start items-center'
      style='max-height: calc(var(--vh) * 85);'>
      <?php if(count($games) > 0): ?>
        <?=Component::make('games',['user'=>$user,'games'=>$games])?>
      <?php else: ?>
        You have no active games.
      <?php endif; ?>
    </div>

  </div>
<?php endif; ?>