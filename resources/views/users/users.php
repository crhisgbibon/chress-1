<?php use App\Models\System\Component; ?>
<div
  class='w-full flex flex-col justify-start items-center'>

  <div
    style='min-height: calc(var(--vh) * 7.5);'>
    <?=Component::make('input',[
      'version'=>'text',
      'uuid'=>'search_users',
      'nom'=>'search_users',
      'place'=>'Enter user name...',
      'text'=>$search,
      'auto'=>'',
      'check'=>false,
      'onkeydown'=>'UsersPost()',
      ])?>
  </div>

  <div
    id='users'
    class='w-full overflow-y-auto flex flex-col justify-start items-center'
    style='max-height: calc(var(--vh) * 85);'>
    <?php if(isset($users) && count($users) > 0): ?>
      <?=Component::make('users',['users'=>$users])?>
    <?php else: ?>
      No users found.
    <?php endif; ?>
  </div>

</div>