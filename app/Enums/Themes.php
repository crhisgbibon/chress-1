<?php

declare(strict_types=1);

namespace App\Enums;

enum Themes: int
{
  case Light = 0;
  case Dark = 1;

  public function string()
  {
    return match($this)
    {
      self::Light => 'light',
      self::Dark => 'dark',
      default => 'light',
    };
  }
}