<?php if(!$loggedin): ?>
<div
  class='w-screen flex flex-row justify-center items-center my-4'>
  You must be logged in to view your profile.
</div>
<?php else: ?>
<div
  class='w-screen flex flex-row justify-center items-center my-4'>
  <div>
    Logged in as: <?php echo $name; ?>
  </div>
</div>
<?php endif; ?>