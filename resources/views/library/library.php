<?php use App\Models\System\Component; ?>
<div
  x-data='{
    search:false,
  }'
  class='w-full flex flex-col justify-start items-center'>

  <div
    style='min-height: calc(var(--vh) * 7.5);'>
    <?=Component::make('button',['onclick'=>'search=!search','text'=>'Search'])?>
  </div>

  <div
    x-show='search'
    class='flex flex-col justify-start items-center fixed overflow-y-auto w-full'
    style='min-height: calc(var(--vh) * 85); max-height: calc(var(--vh) * 85); top: calc(var(--vh) * 15); z-index: 10; background-color: var(--back);'>
    <?=Component::make('search_library',[])?>
  </div>

  <div
    id='games'
    class='w-full overflow-y-auto flex flex-col justify-start items-center'
    style='max-height: calc(var(--vh) * 85);'>
    <?php if(isset($games) && count($games) > 0): ?>
      <?=Component::make('library',['user'=>$user,'games'=>$games])?>
    <?php else: ?>
      No games found.
    <?php endif; ?>
  </div>

</div>