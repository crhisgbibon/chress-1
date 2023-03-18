<?php

declare(strict_types=1);

namespace App\Controllers\Home;

use App\Models\System\View;

class HomeController
{
  public function index() : View
  {
    return View::make
    (
      'home/home',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'test' => 'hello, world'
      ]
    );
  }
}