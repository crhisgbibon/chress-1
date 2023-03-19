<?php

declare(strict_types=1);

namespace App\Models\Chress;

class SaveTurn
{

  public array $board;
  public bool $turn;
  public array $move;
  public string $state;

  public function __construct()
  {

  }


}