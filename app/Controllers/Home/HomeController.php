<?php

declare(strict_types=1);

namespace App\Controllers\Home;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\System\View;

class HomeController
{
  #[Get(routePath:'/')]
  public function index() : View
  {
    return View::make
    (
      'home/home',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
        'test' => 'hello, world'
      ]
    );
  }
}