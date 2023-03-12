<?php

declare(strict_types=1);

/** Model Class
 * 
 * 
 * 
*/

class GameMoves
{

  private int $index;
  private array $board;

  public function __construct(
    int $index,
    array $board)
  {
    $this->index = $index;
    $this->board = $board;
  }

  private function AddFromLine($array, $board, $white, $index) : array
  {
    $len = count($array);

    if($len === 0) return [];
    if($len === 1 && $array[0] === -1) return [];
    
    $result = [];
    // $xRay is turned on after reach the first piece, turned off after (including) the second piece
    // if piece is $white, mark each $square $up to the first black piece as a $result and targeted by $white
    // if the first piece is $white mark don't add that to $result
    // if first piece was opposite colour, run $xRay following on until it hits a piece and mark all squares as $xRay
    // don't run $xRay if first piece hit was same colour
    $xRay = false;
    
    for($i = 0; $i < $len; $i++)
    {
      $square = $array[$i];
      if($board[$square] !== null)
      {
        // for $white pieces
        if($board[$index]->piece[0] === "W")
        {
          // if $xRay is on
          if($xRay)
          {
            // mark all empty squares as xrayed
            if($board[$square]->piece === "-")
            {
              array_push($board[$square]->xRayWhite, $index);
            }
            // mark the first piece and end
            if($board[$square]->piece[0] !== "-")
            {
              array_push($board[$square]->xRayWhite, $index);
              break;
            }
          }
          else
          {
            // if $xRay is off
            // mark all empty squares in $result and targeted by $white
            if($board[$square]->piece === "-")
            {
              array_push($board[$square]->targetedByWhite, $index);
              array_push($result, $square);
            }
            // if hit a black piece first
            if($board[$square]->piece[0] === "B")
            {
              // actiate $xRay
              array_push($board[$square]->targetedByWhite, $index);
              array_push($result, $square);
              $xRay = true;
            }
            // if hit a $white piece first
            if($board[$square]->piece[0] === "W")
            {
              // dont activate $xRay, just target and end
              array_push($board[$square]->targetedByWhite, $index);
              $xRay = true;
              break;
            }
          }
        }
        // for black pieces
        if($board[$index]->piece[0] === "B")
        {
          // if $xRay is on
          if($xRay)
          {
            // mark all empty squares as xrayed
            if($board[$square]->piece === "-")
            {
              array_push($board[$square]->xRayBlack, $index);
            }
            // mark the first piece and end
            if($board[$square]->piece[0] !== "-")
            {
              array_push($board[$square]->xRayBlack, $index);
              break;
            }
          }
          else
          {
            // if $xRay is off
            // mark all empty squares in $result and targeted by $white
            if($board[$square]->piece === "-")
            {
              array_push($board[$square]->targetedByBlack, $index);
              array_push($result, $square);
            }
            // if hit a same colour piece first
            if($board[$square]->piece[0] === "W")
            {
              // actiate $xRay
              array_push($board[$square]->targetedByBlack, $index);
              array_push($result, $square);
              $xRay = true;
            }
            // if hit an opposite colour piece first
            if($board[$square]->piece[0] === "B")
            {
              // dont activate $xRay, just target and end
              array_push($board[$square]->targetedByBlack, $index);
              $xRay = true;
              break;
            }
          }
        }
      }
    }
    return $result;
  }

  public function FindMovesPawn() : array
  {
    $index = $this->index;
    $board = $this->board;

    $square = $board[$index];
    
    $up = $square->up;
    $down = $square->down;
    
    $upRight = $square->upRight;
    $upLeft = $square->upLeft;
    $downRight = $square->downRight;
    $downLeft = $square->downLeft;
    
    $result = [];
    
    $white = true;
    if($board[$index]->piece !== "WP") $white = false;
    
    if($white) if($up !== -1 && ($board[$up]->piece === "-")) array_push($result, $up);
    if($white) if($upRight !== -1) { array_push($board[$upRight]->targetedByWhite, $index); };
    if($white) if($upRight !== -1 && ($board[$upRight]->piece[0] === "B")) { array_push($result, $upRight); };
    if($white) if($upLeft !== -1) { array_push($board[$upLeft]->targetedByWhite, $index); };
    if($white) if($upLeft !== -1 && ($board[$upLeft]->piece[0] === "B")) { array_push($result, $upLeft); };

    if(!$white) if($down !== -1 && ($board[$down]->piece === "-")) array_push($result, $down);
    if(!$white) if($downRight !== -1) { array_push($board[$downRight]->targetedByBlack, $index); };
    if(!$white) if($downRight !== -1 && ($board[$downRight]->piece[0] === "W")) { array_push($result, $downRight); };
    if(!$white) if($downLeft !== -1) { array_push($board[$downLeft]->targetedByBlack, $index); };
    if(!$white) if($downLeft !== -1 && ($board[$downLeft]->piece[0] === "W")) { array_push($result, $downLeft); };

    if($square->firstMove)
    {
      if($white && $square->row === 1)
      {
        if($board[$up]->piece === "-" && $board[$board[$square->up]->up]->piece === "-") array_push($result, $board[$square->up]->up);
      }
      else if(!$white && $square->row === 6)
      {
        if($board[$down]->piece === "-" && $board[$board[$square->down]->down]->piece === "-") array_push($result, $board[$square->down]->down);
      }
    }
    
    // en passant check
    $left = $square->left;
    $right = $square->right;
    if($left !== -1 && $white && $board[$left]->enPassant > 0) array_push($result, $upLeft);
    if($right !== -1 && $white && $board[$right]->enPassant > 0) array_push($result, $upRight);
    
    if($left !== -1 && !$white && $board[$left]->enPassant > 0) array_push($result, $downLeft);
    if($right !== -1 && !$white && $board[$right]->enPassant > 0) array_push($result, $downRight);
    
    return $result;
  }

  public function FindMovesRook() : array
  {
    $index = $this->index;
    $board = $this->board;

    $square = $board[$index];
    
    $leftLine = $square->leftLine;
    $rightLine = $square->rightLine;
    
    $upLine = $square->upLine;
    $downLine = $square->downLine;
    
    $result = [];
    
    $white = true;
    if($board[$index]->piece !== "WR") $white = false;
    
    array_push($result, $this->AddFromLine($leftLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($rightLine, $board, $white, $index));

    array_push($result, $this->AddFromLine($upLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($downLine, $board, $white, $index));

    return $result;
  }

  public function FindMovesKnight() : array
  {
    $index = $this->index;
    $board = $this->board;

    $square = $board[$index];
    
    $kDownLeft = $square->kDownLeft;
    $kDownRight = $square->kDownRight;
    
    $kUpLeft = $square->kUpLeft;
    $kUpRight = $square->kUpRight;
    
    $kLeftUp = $square->kLeftUp;
    $kLeftDown = $square->kLeftDown;
    
    $kRightUp = $square->kRightUp;
    $kRightDown = $square->kRightDown;
    
    $result = [];
    
    $white = true;
    if($board[$index]->piece !== "WK") $white = false;
    
    if($kDownLeft !== -1) {
      if($white) array_push($board[$kDownLeft]->targetedByWhite, $index);
      else array_push($board[$kDownLeft]->targetedByBlack, $index);
      if($board[$kDownLeft]->piece === "-") array_push($result, $kDownLeft);
      else if($board[$kDownLeft]->piece[0] === "W") { if(!$white) array_push($result, $kDownLeft); }
      else if($board[$kDownLeft]->piece[0] === "B") { if($white) array_push($result, $kDownLeft); }; };
    if($kDownRight !== -1) {
      if($white) array_push($board[$kDownRight]->targetedByWhite, $index);
      else array_push($board[$kDownRight]->targetedByBlack, $index);
      if($board[$kDownRight]->piece === "-") array_push($result, $kDownRight);
      else if($board[$kDownRight]->piece[0] === "W") { if(!$white) array_push($result, $kDownRight); }
      else if($board[$kDownRight]->piece[0] === "B") { if($white) array_push($result, $kDownRight); }; };
    
    if($kUpLeft !== -1) {
      if($white) array_push($board[$kUpLeft]->targetedByWhite, $index);
      else array_push($board[$kUpLeft]->targetedByBlack, $index);
      if($board[$kUpLeft]->piece === "-") array_push($result, $kUpLeft);
      else if($board[$kUpLeft]->piece[0] === "W") { if(!$white) array_push($result, $kUpLeft); }
      else if($board[$kUpLeft]->piece[0] === "B") { if($white) array_push($result, $kUpLeft); }; };
    if($kUpRight !== -1) {
      if($white) array_push($board[$kUpRight]->targetedByWhite, $index);
      else array_push($board[$kUpRight]->targetedByBlack, $index);
      if($board[$kUpRight]->piece === "-") array_push($result, $kUpRight);
      else if($board[$kUpRight]->piece[0] === "W") { if(!$white) array_push($result, $kUpRight); }
      else if($board[$kUpRight]->piece[0] === "B") { if($white) array_push($result, $kUpRight); }; };
    
    if($kLeftUp !== -1) {
      if($white) array_push($board[$kLeftUp]->targetedByWhite, $index);
      else array_push($board[$kLeftUp]->targetedByBlack, $index);
      if($board[$kLeftUp]->piece === "-") array_push($result, $kLeftUp);
      else if($board[$kLeftUp]->piece[0] === "W") { if(!$white) array_push($result, $kLeftUp); }
      else if($board[$kLeftUp]->piece[0] === "B") { if($white) array_push($result, $kLeftUp); }; };
    if($kLeftDown !== -1) {
      if($white) array_push($board[$kLeftDown]->targetedByWhite, $index);
      else array_push($board[$kLeftDown]->targetedByBlack, $index);
      if($board[$kLeftDown]->piece === "-") array_push($result, $kLeftDown);
      else if($board[$kLeftDown]->piece[0] === "W") { if(!$white) array_push($result, $kLeftDown); }
      else if($board[$kLeftDown]->piece[0] === "B") { if($white) array_push($result, $kLeftDown); }; };
    
    if($kRightUp !== -1) {
      if($white) array_push($board[$kRightUp]->targetedByWhite, $index);
      else array_push($board[$kRightUp]->targetedByBlack, $index);
      if($board[$kRightUp]->piece === "-") array_push($result, $kRightUp);
      else if($board[$kRightUp]->piece[0] === "W") { if(!$white) array_push($result, $kRightUp); }
      else if($board[$kRightUp]->piece[0] === "B") { if($white) array_push($result, $kRightUp); }; };
    if($kRightDown !== -1) {
      if($white) array_push($board[$kRightDown]->targetedByWhite, $index);
      else array_push($board[$kRightDown]->targetedByBlack, $index);
      if($board[$kRightDown]->piece === "-") array_push($result, $kRightDown);
      else if($board[$kRightDown]->piece[0] === "W") { if(!$white) array_push($result, $kRightDown); }
      else if($board[$kRightDown]->piece[0] === "B") { if($white) array_push($result, $kRightDown); }; };
    
    return $result;
  }

  public function FindMovesBishops() : array
  {
    $index = $this->index;
    $board = $this->board;

    $square = $board[$index];
    
    $upRightLine = $square->upRightLine;
    $upLeftLine = $square->upLeftLine;
    
    $downRightLine = $square->downRightLine;
    $downLeftLine = $square->downLeftLine;
    
    $result = [];
    
    $white = true;
    if($board[$index]->piece !== "WB") $white = false;

    array_push($result, $this->AddFromLine($upRightLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($upLeftLine, $board, $white, $index));

    array_push($result, $this->AddFromLine($downRightLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($downLeftLine, $board, $white, $index));
    
    return $result;
  }

  public function FindMovesQueen() : array
  {
    $index = $this->index;
    $board = $this->board;

    $square = $board[$index];
    
    $leftLine = $square->leftLine;
    $rightLine = $square->rightLine;
    
    $upLine = $square->upLine;
    $downLine = $square->downLine;
    
    $upRightLine = $square->upRightLine;
    $upLeftLine = $square->upLeftLine;
    
    $downRightLine = $square->downRightLine;
    $downLeftLine = $square->downLeftLine;
    
    $result = [];
    
    $white = true;
    if($board[$index]->piece !== "WQ") $white = false;

    array_push($result, $this->AddFromLine($leftLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($rightLine, $board, $white, $index));

    array_push($result, $this->AddFromLine($upLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($downLine, $board, $white, $index));

    array_push($result, $this->AddFromLine($upRightLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($upLeftLine, $board, $white, $index));

    array_push($result, $this->AddFromLine($downRightLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($downLeftLine, $board, $white, $index));
    
    return $result;
  }

  public function FindMovesKing() : array
  {
    $index = $this->index;
    $board = $this->board;

    $square = $board[$index];
    
    $white = true;
    if($board[$index]->piece !== "WX") $white = false;
    
    $up = $square->up;
    if($up !== -1 && $white && count($board[$up]->targetedByBlack) > 0) $up = -1;
    if($up !== -1 && !$white && count($board[$up]->targetedByWhite) > 0) $up = -1;
    $down = $square->down;
    if($down !== -1 && $white && count($board[$down]->targetedByBlack) > 0) $down = -1;
    if($down !== -1 && !$white && count($board[$down]->targetedByWhite) > 0) $down = -1;
    
    $left = $square->left;
    if($left !== -1 && $white && count($board[$left]->targetedByBlack) > 0) $left = -1;
    if($left !== -1 && !$white && count($board[$left]->targetedByWhite) > 0) $left = -1;
    $right = $square->right;
    if($right !== -1 && $white && count($board[$right]->targetedByBlack) > 0) $right = -1;
    if($right !== -1 && !$white && count($board[$right]->targetedByWhite) > 0) $right = -1;
    
    $upRight = $square->upRight;
    if($upRight !== -1 && $white && count($board[$upRight]->targetedByBlack) > 0) $upRight = -1;
    if($upRight !== -1 && !$white && count($board[$upRight]->targetedByWhite) > 0) $upRight = -1;
    $upLeft = $square->upLeft;
    if($upLeft !== -1 && $white && count($board[$upLeft]->targetedByBlack) > 0) $upLeft = -1;
    if($upLeft !== -1 && !$white && count($board[$upLeft]->targetedByWhite) > 0) $upLeft = -1;
    
    $downRight = $square->downRight;
    if($downRight !== -1 && $white && count($board[$downRight]->targetedByBlack) > 0) $downRight = -1;
    if($downRight !== -1 && !$white && count($board[$downRight]->targetedByWhite) > 0) $downRight = -1;
    $downLeft = $square->downLeft;
    if($downLeft !== -1 && $white && count($board[$downLeft]->targetedByBlack) > 0) $downLeft = -1;
    if($downLeft !== -1 && !$white && count($board[$downLeft]->targetedByWhite) > 0) $downLeft = -1;
    
    $result = [];
    
    if($up !== -1) {
      if($white) array_push($board[$up]->targetedByWhite, $index);
      else array_push($board[$up]->targetedByBlack, $index);
      if($board[$up]->piece === "-") array_push($result, $up);
      else if($board[$up]->piece[0] === "W") { if(!$white) array_push($result, $up); }
      else if($board[$up]->piece[0] === "B") { if($white) array_push($result, $up); }; };
    if($down !== -1) {
      if($white) array_push($board[$down]->targetedByWhite, $index);
      else array_push($board[$down]->targetedByBlack, $index);
      if($board[$down]->piece === "-") array_push($result, $down);
      else if($board[$down]->piece[0] === "W") { if(!$white) array_push($result, $down); }
      else if($board[$down]->piece[0] === "B") { if($white) array_push($result, $down); }; };
    
    if($left !== -1) {
      if($white) array_push($board[$left]->targetedByWhite, $index);
      else array_push($board[$left]->targetedByBlack, $index);
      if($board[$left]->piece === "-") array_push($result, $left);
      else if($board[$left]->piece[0] === "W") { if(!$white) array_push($result, $left); }
      else if($board[$left]->piece[0] === "B") { if($white) array_push($result, $left); }; };
    if($right !== -1) {
      if($white) array_push($board[$right]->targetedByWhite, $index);
      else array_push($board[$right]->targetedByBlack, $index);
      if($board[$right]->piece === "-") array_push($result, $right);
      else if($board[$right]->piece[0] === "W") { if(!$white) array_push($result, $right); }
      else if($board[$right]->piece[0] === "B") { if($white) array_push($result, $right); }; };
    
    if($upRight !== -1) {
      if($white) array_push($board[$upRight]->targetedByWhite, $index);
      else array_push($board[$upRight]->targetedByBlack, $index);
      if($board[$upRight]->piece === "-") array_push($result, $upRight);
      else if($board[$upRight]->piece[0] === "W") { if(!$white) array_push($result, $upRight); }
      else if($board[$upRight]->piece[0] === "B") { if($white) array_push($result, $upRight); }; };
    if($upLeft !== -1) {
      if($white) array_push($board[$upLeft]->targetedByWhite, $index);
      else array_push($board[$upLeft]->targetedByBlack, $index);
      if($board[$upLeft]->piece === "-") array_push($result, $upLeft);
      else if($board[$upLeft]->piece[0] === "W") { if(!$white) array_push($result, $upLeft); }
      else if($board[$upLeft]->piece[0] === "B") { if($white) array_push($result, $upLeft); }; };
    
    if($downRight !== -1) {
      if($white) array_push($board[$downRight]->targetedByWhite, $index);
      else array_push($board[$downRight]->targetedByBlack, $index);
      if($board[$downRight]->piece === "-") array_push($result, $downRight);
      else if($board[$downRight]->piece[0] === "W") { if(!$white) array_push($result, $downRight); }
      else if($board[$downRight]->piece[0] === "B") { if($white) array_push($result, $downRight); }; };
    if($downLeft !== -1) {
      if($white) array_push($board[$downLeft]->targetedByWhite, $index);
      else array_push($board[$downLeft]->targetedByBlack, $index);
      if($board[$downLeft]->piece === "-") array_push($result, $downLeft);
      else if($board[$downLeft]->piece[0] === "W") { if(!$white) array_push($result, $downLeft); }
      else if($board[$downLeft]->piece[0] === "B") { if($white) array_push($result, $downLeft); }; };
      
    // $white - establish castle rights if king on start $square and hasn't moved
    if($white && $index === 4 && $board[$index]->firstMove && count($board[$index]->targetedByBlack) === 0)
    {
      for($i = 0; $i < count($square->leftLine); $i++)
      {
        // if all squares but the last one are either not empty or under threat then cancel
        if($i < (count($square->leftLine) - 1) && ($board[$square->leftLine[$i]]->piece !== "-"
        || count($board[$square->leftLine[$i]]->targetedByBlack) > 0)) break;
        // if last $square isn't a rook with no threat then cancel
        if($i === count($square->leftLine) && ($board[$square->leftLine[$i]]->piece !== "WR") && $board[$i]->firstMove) break;
        // if passed those tests then add to move list
        array_push($result, 2);
      }
      for($i = 0; $i < count($square->rightLine); $i++)
      {
        // if all squares but the last one are either not empty or under threat then cancel
        if($i < (count($square->rightLine) - 1) && ($board[$square->rightLine[$i]]->piece !== "-"
        || count($board[$square->rightLine[$i]]->targetedByBlack) > 0)) break;
        // if last $square isn't a rook with no threat then cancel
        if($i === count($square->rightLine) && ($board[$square->rightLine[$i]]->piece !== "WR") && $board[$i]->firstMove) break;
        // if passed those tests then add to move list
        array_push($result, 6);
      }
    }
    // BLACK
    if(!$white && $index === 60 && $board[$index]->firstMove && count($board[$index]->targetedByWhite) === 0)
    {
      for($i = 0; $i < count($square->leftLine); $i++)
      {
        // if all squares but the last one are either not empty or under threat then cancel
        if($i < (count($square->leftLine) - 1) && ($board[$square->leftLine[$i]]->piece !== "-"
        || count($board[$square->leftLine[$i]]->targetedByWhite) > 0)) break;
        // if last $square isn't a rook with no threat then cancel
        if($i === count($square->leftLine) && ($board[$square->leftLine[$i]]->piece !== "BR") && $board[$i]->firstMove) break;
        // if passed those tests then add to move list
        array_push($result, 58);
      }
      for($i = 0; $i < count($square->rightLine); $i++)
      {
        // if all squares but the last one are either not empty or under threat then cancel
        if($i < (count($square->rightLine) - 1) && ($board[$square->rightLine[$i]]->piece !== "-"
        || count($board[$square->rightLine[$i]]->targetedByWhite) > 0)) break;
        // if last $square isn't a rook with no threat then cancel
        if($i === count($square->rightLine) && ($board[$square->rightLine[$i]]->piece !== "BR") && $board[$i]->firstMove) break;
        // if passed those tests then add to move list
        array_push($result, 62);
      }
    }
    
    return $result;
  }

}