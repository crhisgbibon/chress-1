<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

use App\Models\Chress\LibraryModel;

class LibraryController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private LibraryModel $model;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);

    $this->account = new AuthModel($this->db, $this->config);

    $this->model = new LibraryModel($this->db, $this->config);
  }

  #[Get(routePath:'/library')]
  public function index() : View
  {
    return View::make
    (
      'library/library',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
      ]
    );
  }

}