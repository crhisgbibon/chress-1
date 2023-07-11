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
      onclick="theme(<?=$key?>);"><?=$value['title']?></button>
  <?php endforeach; ?>

  <script>
    function theme(data) {
      let data2 = {
        newtheme: data,
      };
      let jsonData = JSON.stringify(data2);
      if (debug) console.log(data2);
      $.ajax({
        method: "POST",
        url: '/profile/theme',
        data: {
          data: jsonData
        },
        timeout: 10000,
        success: function(result) {
          if (debug) console.log(result);
          document.getElementById('themebuttons').innerHTML = result;
          let newroot = document.querySelector('[data-theme="yes"]').dataset.root;
          let href = document.getElementById('rootcss').href;
          let last = href.lastIndexOf('/') + 1;
          let dot = href.lastIndexOf('.');
          let replace = href.substring(last, dot);
          let newHref = href.replace(replace, newroot);
          document.getElementById('rootcss').href = newHref;
        },
        error: function(result) {
          if (debug) console.log(result);
          document.getElementById('themebuttons').innerHTML = result;
          if (debug) console.log(document.getElementById('rootcss').href);
        }
      });
    }
  </script>

</div>