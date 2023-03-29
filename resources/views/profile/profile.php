<?php use App\Models\System\Component; ?>
<?php if(!$loggedin): ?>
<div
  class='w-screen flex flex-row justify-center items-center my-4'>
  You must be logged in to view your profile.
</div>
<?php else: ?>
<div
  class='w-screen flex flex-col justify-center items-center my-4'>

  <div
   class='my-2'>
    Logged in as: <?php echo $name; ?>
  </div>

  <div
   class='my-2 underline'>
    Theme
  </div>

  <div
    id='themebuttons'>
    <?=Component::make('theme_buttons',['themes'=>$themes])?>
  </div>

</div>
<?php endif; ?>