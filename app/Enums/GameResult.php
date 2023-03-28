<?php

declare(strict_types=1);

namespace App\Enums;

enum GameResult: int
{
  case Pending = -1;
  case White = 1;
  case Black = 0;
  case Draw = -2;

  public function string()
  {
    return match($this)
    {
      self::Pending => 'Pending',
      self::White => 'White',
      self::Black => 'Black',
      self::Draw => 'Draw',
      default => 'Pending',
    };
  }

  public function colour()
  {
    return match($this)
    {
      self::Pending => 'green',
      self::White => 'white',
      self::Black => 'black',
      self::Draw => 'grey',
      default => 'green',
    };
  }
}

// from
// GameResult::tryFrom(int_value);
// GameResult::cases - gives all cases