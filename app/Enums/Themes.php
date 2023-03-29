<?php

declare(strict_types=1);

namespace App\Enums;

enum Themes: int
{
  case Light = 0;
  case Dark = 1;
  case Mono = 2;
  case Pastel = 3;

  public function string()
  {
    return match($this)
    {
      self::Light => 'light',
      self::Dark => 'dark',
      self::Mono => 'mono',
      self::Pastel => 'pastel',
      default => 'light',
    };
  }

  public static function names() : array
  {
    return
    [
      0 => ['title' => 'Light', 'root' => 'light'],
      1 => ['title' => 'Dark', 'root' => 'dark'],
      2 => ['title' => 'Mono', 'root' => 'mono'],
      3 => ['title' => 'Pastel', 'root' => 'pastel'],
    ];
  }
}