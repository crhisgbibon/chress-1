<div id="headerControls">
  <div id="controlHolder">
    <?php 
      if(isset($buttons))
      {
        $c = count($options);
        for($i = 0; $i < $c; $i++)
        {
          $name = $options[$i];
          echo `
            <button id='{$name}Button'><img id='i_control{$name}' src=''></img></button>
          `;
        }
      }
    ?>
  </div>
</div>