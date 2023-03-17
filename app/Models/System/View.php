<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Exceptions\ViewNotFoundException;

class View
{
  public function __construct
  (
    protected string $view,
    protected string $title,
    protected bool $withLayout,
    protected array $params = []
  )
  {
  }

  public static function make(string $view, string $title, bool $withLayout, array $params = []): static
  {
    return new static($view, $title, $withLayout, $params);
  }

  public function render(bool $withLayout = false): string
  {
    $session = false;
    if(isset($_SESSION['loggedin'])) if($_SESSION['loggedin']) $session = true;

    $viewPath = VIEW_PATH . '/' . $this->view . '.php';
    if(!file_exists($viewPath)) throw new ViewNotFoundException();
    foreach($this->params as $key => $value) $$key = $value;

    $navPath = VIEW_PATH . '/system/navigation.php';
    if(!file_exists($navPath)) throw new ViewNotFoundException();

    if($withLayout)
    {
      ob_start();
      $loggedin = $session;
      include $navPath;
      $nav = (string) ob_get_clean();

      ob_start();
      include $viewPath;
      $view = (string) ob_get_clean();

      $layoutPath = VIEW_PATH . '/layout.php';
      if(!file_exists($layoutPath)) throw new ViewNotFoundException();
      $title = $this->title;
      $navBar = $nav;
      $body = $view;
      ob_start();
      include $layoutPath;
      return (string) ob_get_clean();
    }
    else
    {
      ob_start();
      $loggedin = $session;
      include $navPath;
      $nav = (string) ob_get_clean();

      ob_start();
      include $viewPath;
      $navBar = $nav;
      return (string) ob_get_clean();
    }
  }

  public function __toString(): string
  {
    return $this->render($this->withLayout);
  }

  public function __get(string $name)
  {
    return $this->params[$name] ?? null;
  }
}