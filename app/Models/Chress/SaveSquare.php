<?php

declare(strict_types=1);

namespace App\Models\Chress;

class SaveSquare
{

  public bool $firstMove;
  public int $enPassant;
  public string $piece;

  public function __construct()
  {

  }


}