<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Models\Auth\AccountManager;
use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

class ChressController
{
  private AccountManager $account;
  private Config $config;
  private DB $db;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);
    $this->account = new AccountManager($this->db, $this->config);
  }

  public function playGet() : View
  {
    return View::make
    (
      'chress/play',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array

      ]
    );
  }

  public function playGetSwap() : string
  {
    return json_encode('hello, mode');
  }

  public function playGetLastgame() : string
  {
    return json_encode('hello, lastgame');
  }

  public function playGetNextgame() : string
  {
    return json_encode('hello, nextgame');
  }

  public function lobbyGet() : View
  {
    return View::make
    (
      'chress/lobby',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array

      ]
    );
  }

  public function libraryGet() : View
  {
    return View::make
    (
      'chress/library',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array

      ]
    );
  }

  public function searchGet() : View
  {
    return View::make
    (
      'chress/search',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array

      ]
    );
  }
}