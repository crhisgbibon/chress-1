<div
  class='w-screen flex flex-row justify-center items-center my-4'>
  <div>
    <?php if(isset($wasloggedin)): ?>
      <?php if($wasloggedin): ?>
        You have been logged out successfully.
      <?php else: ?>
        You must login to logout.
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>