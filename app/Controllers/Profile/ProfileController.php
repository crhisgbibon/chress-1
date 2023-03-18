<?php

declare(strict_types=1);

namespace App\Controllers\Profile;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;

use App\Models\Auth\AuthModel;

use App\Models\Profile\ProfileModel;

class ProfileController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private ProfileModel $model;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);
    
    $this->account = new AuthModel($this->db, $this->config);

    $this->model = new ProfileModel($this->db, $this->config);
  }

  public function index() : View
  {
    $loggedin = $this->account->LoggedIn();
    $name = (isset($_SESSION['name'])) ? $_SESSION['name'] : '';
    return View::make
    (
      'profile/profile', // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'loggedin' => $loggedin,
        'name' => $name,
      ]
    );
  }
}