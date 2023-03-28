<?php use App\Models\System\Component; ?>
<?php if(!$loggedin): ?>
  <div
    class='w-full flex flex-col justify-start items-center'>
    You must be logged in to view your history.
  </div>
<?php else: ?>
  <div
    class='w-full flex flex-col justify-start items-center'>

    <div
      class='w-full overflow-y-auto flex flex-col justify-start items-center'
      style='max-height: calc(var(--vh) * 85);'>
      <?php if(count($games) > 0): ?>
        <?=Component::make('history',['user'=>$user,'games'=>$games])?>
      <?php else: ?>
        You have no game history.
      <?php endif; ?>
    </div>

  </div>
<?php endif; ?>