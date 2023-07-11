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
      'onkeydown'=>'usersPost()',
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

  <script>
    function usersPost() {
      let data = {
        search: document.querySelector('input[name="search_users"]').value,
      };
      let jsonData = JSON.stringify(data);
      if (debug) console.log(data);
      if (debug) console.log(jsonData);
      $.ajax({
        method: "POST",
        url: '/users/search',
        data: {
          data: jsonData
        },
        timeout: 10000,
        success: function(result) {
          if (debug) console.log(result);
          document.getElementById('users').innerHTML = result;
        },
        error: function(result) {
          if (debug) console.log(result);
        }
      });
    }
  </script>

</div>