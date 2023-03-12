<?php

declare(strict_types=1);

class ControlsView
{

  public function __construct()
  {

  }

  public function render(array $options) : string
  {
    $c = count($options);

    $buttons = "";

    for($i = 0; $i < $c; $i++)
    {
      $name = $options[$i];
      $buttons .= "
        <button id='{$name}Button'><img id='i_control{$name}' src=''></img></button>
      ";
    }

    return <<<VIEW

    <div id="headerControls">

      <div id="controlHolder">

        {$buttons}

      </div>

    </div>

    VIEW;
  }
}