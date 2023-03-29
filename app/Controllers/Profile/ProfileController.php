<?php

declare(strict_types=1);

namespace App\Controllers\Profile;

use App\Attributes\Get;
use App\Attributes\Post;

use App\Enums\Themes;

use App\Models\System\Config;
use App\Models\System\DB;
use App\Models\System\View;
use App\Models\System\Component;

use App\Models\Auth\AuthModel;

use App\Models\Profile\ProfileModel;

class ProfileController
{
  private Config $config;
  private DB $db;

  private AuthModel $account;

  private ProfileModel $model;

  private int $userID;

  public function __construct()
  {
    $this->config = new Config($_ENV);
    $this->db = new DB($this->config->db);
    
    $this->account = new AuthModel($this->db, $this->config);

    $this->userID = (isset($_SESSION['id'])) ? $_SESSION['id'] : -1;

    $this->model = new ProfileModel($this->db, $this->config);
  }

  #[Get(routePath:'/profile')]
  public function index() : View
  {
    $loggedin = $this->account->LoggedIn();
    $name = (isset($_SESSION['name'])) ? $_SESSION['name'] : '';
    $themes = Themes::names();

    return View::make
    (
      'profile/profile', // body view path
      'Chress',         // view title
      true,             // with layout
      [                 // body params array
        'layer' => './',
        'loggedin' => $loggedin,
        'name' => $name,
        'themes' => $themes,
      ]
    );
  }

  #[Post(routePath:'/profile/theme')]
  public function theme() : Component
  {
    $data = json_decode($_POST['data']);
    $newtheme = (int)$data->newtheme;

    $this->model->ChangeTheme($newtheme, $this->userID);

    $loggedin = $this->account->LoggedIn();
    $name = (isset($_SESSION['name'])) ? $_SESSION['name'] : '';
    $themes = Themes::names();

    return Component::make('theme_buttons',['themes'=>$themes]);
  }
}