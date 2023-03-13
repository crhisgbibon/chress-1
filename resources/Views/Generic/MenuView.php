<?php

declare(strict_types=1);

namespace App\Views\Generic;

class MenuView
{

  public function __construct()
  {

  }

  public function render(array $options) : string
  {
    /*
    
    options structure:

    3 layers deep

    Sample Format:

    $controlsContents = $controls->PrintContents([
      ["File", [["New Game", ["One", "Two", "Three"]], ["Cells", ["One", "Two", "Three"]]]],
      ["Edit", [["Main"]]],
      ["Options", [["Full"], ["Mini"], ["Nothing"]]],
      ["View", [["Theme"]]],
      ["Home"]
    ]);
    
    */

    $menu = "<div class='sub'>";

    $count1 = count($options);
    for($i = 0; $i < $count1; $i++)
    {
      if(count($options[$i]) === 1)
      {
        $name = $options[$i][0];
        $menu .= "
          <button class='subMenu-1' id='{$name}Button'>{$name}</button>
        ";
      }
      if(count($options[$i]) === 2)
      {
        $name = $options[$i][0];
        $menu .= "
          <button id='{$name}Button' class='subMenu-1' 
          onclick='SwitchLayer(`subMenu-1`, `y{$i}`);'>
          {$name}</button>
        ";

        $count2 = count($options[$i][1]);

        $menu .= "<div class='sub' id='y{$i}' style='display: none;'>";

        $menu .= "
          <button class='subMenu{$i}' id='BackButton{$i}' onclick='SwitchLayer(`subMenu-1`, `y{$i}`);'>
          Back</button>
        ";

        for($y = 0; $y < $count2; $y++)
        {
          if(count($options[$i][1][$y]) === 1)
          {
            $name = $options[$i][1][$y][0];
            $menu .= "
              <button class='subMenu{$i}' id='{$name}Button'>{$name}</button>
            ";
          }
          if(count($options[$i][1][$y]) === 2)
          {
            $name = $options[$i][1][$y][0];

            $menu .= "
              <button class='subMenu{$i}' id='{$name}Button' onclick='SwitchLayer(`subMenu{$i}`, `u{$i}`);'>
              {$name}</button>
            ";

            $menu .= "<div class='sub' id='u{$i}' style='display: none;'>";

            $menu .= "
              <button id='BackButton{$i}' onclick='SwitchLayer(`subMenu{$i}`, `u{$i}`);'>
              Back</button>
            ";

            $count3 = count($options[$i][1][$y][1]);

            for($u = 0; $u < $count3; $u++)
            {
              $name = $options[$i][1][$y][1][$u];
              $menu .= "
                <button id='{$name}Button'>{$name}</button>
              ";
            }
            $menu .= "</div>";
          }
        }
        $menu .= "</div>";
      }
    }

    return <<<VIEW

    <div id="menuHeader">

    {$menu}

    </div>

    VIEW;
  }
}