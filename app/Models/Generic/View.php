<?php

declare(strict_types=1);

namespace App\Models\Generic;

use App\Exceptions\ViewNotFoundException;

class View
{
  public function __construct
  (
    protected string $view,
    protected string $title,
    protected bool $withLayout,
    protected array $controls,
    protected array $params = []
  )
  {
  }

  public static function make(string $view, string $title, bool $withLayout, array $controls = [], array $params = []): static
  {
    return new static($view, $title, $withLayout, $controls, $params);
  }

  public function render(bool $withLayout = false): string
  {
    $viewPath = VIEW_PATH . '/' . $this->view . '.php';
    if(!file_exists($viewPath)) throw new ViewNotFoundException();
    foreach($this->params as $key => $value) $$key = $value;

    $controlPath = VIEW_PATH . '/generic/controls.php';
    if(!file_exists($controlPath)) throw new ViewNotFoundException();

    if($withLayout)
    {
      ob_start();
      $options = [];
      foreach($this->controls as $key => $value)
      {
        $$key = $value;
        array_push($options, $$key);
      }
      include $controlPath;
      $con = (string) ob_get_clean();

      ob_start();
      include $viewPath;
      $view = (string) ob_get_clean();

      $layoutPath = VIEW_PATH . '/layout.php';
      if(!file_exists($layoutPath)) throw new ViewNotFoundException();
      $title = $this->title;
      $controls = $con;
      $body = $view;
      ob_start();
      include $layoutPath;
      return (string) ob_get_clean();
    }
    else
    {
      ob_start();
      $options = [];
      foreach($this->controls as $key => $value)
      {
        $$key = $value;
        array_push($options, $$key);
      }
      include $controlPath;
      $con = (string) ob_get_clean();

      ob_start();
      include $viewPath;
      $controls = $con;
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