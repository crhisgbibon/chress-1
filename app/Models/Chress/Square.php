<?php

declare(strict_types=1);

namespace App\Models\Chress;

class Square
{
    public int $index;
    
    public int $col;
    public int $row;
    // true or false depending on square colour
    public bool $white;
    
    public int $up;
    public int $down;
    
    public int $left;
    public int $right;

    public int $upLeft;
    public int $upRight;
    
    public int $downLeft;
    public int $downRight;
    
    public int $kUpRight;
    public int $kUpLeft;
    
    public int $kLeftUp;
    public int $kLeftDown;

    public int $kDownRight;
    public int $kDownLeft;
    
    public int $kRightUp;
    public int $kRightDown;
    
    public array $leftLine;
    public array $rightLine;
    
    public array $upLine;
    public array $downLine;
    
    public array $upRightLine;
    public array $upLeftLine;
    
    public array $downRightLine;
    public array $downLeftLine;
    
    public bool $firstMove;
    public int $enPassant = 0;
    
    public string $piece;
    public array $moves = [];
    
    // log all the squares the piece could move to or threatens to capture on
    // includes both enemy squares and squares of own pieces it is supporting
    public array $targetedByWhite;
    public array $targetedByBlack;
    
    // goes beyond targeted squares to log all empty squares and the first piece
    // used to stop own pieces moving and revealing check
    public array $xRayWhite;
    public array $xRayBlack;

  public function __construct(
    string $piece,
    bool $firstMove,
    bool $white
  )
  {
    $this->piece = $piece;
    $this->firstMove = $firstMove;
    $this->white = $white;
  }

  public function GetPiece() : string
  {
    return $this->piece;
  }

}