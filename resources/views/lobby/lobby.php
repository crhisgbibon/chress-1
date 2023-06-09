<?php use App\Models\System\Component; ?>
<?php if(!$loggedin): ?>
  <div
    class='w-full flex flex-col justify-start items-center'>
    You must be logged in to view the lobby.
  </div>
<?php else: ?>
  <div
    class='w-full flex flex-col justify-start items-center'>

    <div
      class='w-full overflow-y-auto flex flex-col justify-start items-center'
      style='height: calc(var(--vh) * 90);'>
      <?php if(count($games) > 0): ?>
        <?=Component::make('lobby',['games'=>$games])?>
      <?php else: ?>
        There are no open challenges.
      <?php endif; ?>
    </div>

  </div>
<?php endif; ?>