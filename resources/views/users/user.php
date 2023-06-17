<?php use App\Models\System\Component; ?>

<?php if(!isset($user)): ?>

  <div
    class='flex flex-col justify-start items-center w-full'>
    User data not found.
  </div>

<?php else: ?>

  <div
    class='flex flex-col justify-start items-center w-full'>

    <?=$user['user_alias']?>

  </div>

<?php endif; ?>