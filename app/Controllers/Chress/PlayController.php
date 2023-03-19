<?php

declare(strict_types=1);

namespace App\Controllers\Chress;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

use App\Models\Chress\PlayModel;

class PlayController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private PlayModel $model;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);

    $this->account = new AuthModel($this->db, $this->config);

    $this->model = new PlayModel($this->db, $this->config);
  }

  public function index() : View
  {
    return View::make
    (
      'play/play',     // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array

      ]
    );
  }

  public function mode() : string
  {
    return json_encode('hello, mode');
  }

  public function flip() : string
  {
    return json_encode('hello, flip');
  }

  public function lastgame() : string
  {
    return json_encode('hello, lastgame');
  }

  public function nextgame() : string
  {
    return json_encode('hello, nextgame');
  }

  public function lastmove() : string
  {
    return json_encode('hello, lastmove');
  }

  public function nextmove() : string
  {
    return json_encode('hello, nextmove');
  }

}