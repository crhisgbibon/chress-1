<div
  class='w-screen flex flex-col justify-center items-center my-2'>
  <?php foreach($themes as $key => $value): ?>
    <button
      class='mx-2 p-2 rounded-lg'
      <?php if(isset($_SESSION['theme']))
        if((int)$_SESSION['theme'] === (int)$key)
        {
          $root = $value['root'];
          echo 'style="background-color: var(--low);" data-theme="yes" data-root="' . $root . '"';
        }
        else
        {
          echo 'style="border-color: var(--low);"';
        }
      ?>
      onclick="Theme(<?=$key?>);"><?=$value['title']?></button>
  <?php endforeach; ?>
</div>