<?php

declare(strict_types=1);

namespace App\Models\Chess;

class SaveSquare
{
  public bool $firstMove;
  public int $enPassant;
  public string $piece;
}