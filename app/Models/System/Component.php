<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Exceptions\ComponentNotFoundException;

class Component
{
  public function __construct
  (
    protected string $component,
    protected array $params = []
  )
  {
  }

  public static function make(string $component, array $params = []): static
  {
    return new static($component, $params);
  }

  public function render(): string
  {
    $componentPath = COMPONENT_PATH . '/' . $this->component . '.php';
    if(!file_exists($componentPath)) throw new ComponentNotFoundException();
    foreach($this->params as $key => $value) $$key = $value;

    ob_start();
    include $componentPath;
    return (string) ob_get_clean();
  }

  public function __toString(): string
  {
    return $this->render();
  }

  public function __get(string $name)
  {
    return $this->params[$name] ?? null;
  }
}