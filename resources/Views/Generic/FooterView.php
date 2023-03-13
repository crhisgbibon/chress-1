<?php

declare(strict_types=1);

namespace App\Views\Generic;

class FooterView
{

  public function __construct()
  {

  }

  public function render() : string
  {
    return <<<VIEW

        </body>

        <div id='messageBox'></div>

        </body>

        <script src='js/home/Main.js'></script>

    </html>

    VIEW;
  }
}