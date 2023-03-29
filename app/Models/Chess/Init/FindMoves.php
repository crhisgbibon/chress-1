<?php

declare(strict_types=1);

namespace App\Models\Chess\Init;

class FindMoves
{
  private function FindMovesPawn($index, $board) : array
  {
    $square = $board[$index];
    
    $up = $square->up;
    $down = $square->down;
    
    $upRight = $square->upRight;
    $upLeft = $square->upLeft;
    $downRight = $square->downRight;
    $downLeft = $square->downLeft;
    
    $result = [];
    
    $white = true;
    if($board[$index]->piece == "WP") $white = true; else $white = false;
    
    if($white) if($up != -1 && ($board[$up]->piece == "-")) array_push($result,$up);
    if($white) if($upRight != -1) { array_push($board[$upRight]->targetedByWhite, $index); };
    if($white) if($upRight != -1 && ($board[$upRight]->piece[0] == "B")) { array_push($result,$upRight); };
    if($white) if($upLeft != -1) { array_push($board[$upLeft]->targetedByWhite, $index); };
    if($white) if($upLeft != -1 && ($board[$upLeft]->piece[0] == "B")) { array_push($result,$upLeft); };

    if(!$white) if($down != -1 && ($board[$down]->piece == "-")) array_push($result,$down);
    if(!$white) if($downRight != -1) { array_push($board[$downRight]->targetedByBlack, $index); };
    if(!$white) if($downRight != -1 && ($board[$downRight]->piece[0] == "W")) { array_push($result,$downRight); };
    if(!$white) if($downLeft != -1) { array_push($board[$downLeft]->targetedByBlack, $index); };
    if(!$white) if($downLeft != -1 && ($board[$downLeft]->piece[0] == "W")) { array_push($result,$downLeft); };

    if($square->firstMove)
    {
      if($white && $square->row == 1)
      {
        if($board[$up]->piece == "-" && $board[$board[$square->up]->up]->piece == "-") array_push($result,$board[$square->up]->up);
      }
      else if(!$white && $square->row == 6)
      {
        if($board[$down]->piece == "-" && $board[$board[$square->down]->down]->piece == "-") array_push($result,$board[$square->down]->down);
      }
    }
    
    // en passant check
    $left = $square->left;
    $right = $square->right;
    if($left != -1 && $white && $board[$left]->enPassant > 0) array_push($result,$upLeft);
    if($right != -1 && $white && $board[$right]->enPassant > 0) array_push($result,$upRight);
    
    if($left != -1 && !$white && $board[$left]->enPassant > 0) array_push($result,$downLeft);
    if($right != -1 && !$white && $board[$right]->enPassant > 0) array_push($result,$downRight);
    
    return $result;
  }

  function FindMovesRook($index, $board) : array
  {
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

    if(count($result) > 0) $result = $this->MergeArrays($result);

    return $result;
  }

  function FindMovesKnight($index, $board) : array
  {
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
    
    if($kDownLeft != -1) {
      if($white) array_push($board[$kDownLeft]->targetedByWhite, $index); 
      else array_push($board[$kDownLeft]->targetedByBlack, $index);
      if($board[$kDownLeft]->piece == "-") array_push($result,$kDownLeft);
      else if($board[$kDownLeft]->piece[0] == "W") { if(!$white) array_push($result,$kDownLeft);  }
      else if($board[$kDownLeft]->piece[0] == "B") { if($white) array_push($result,$kDownLeft); }; };
    if($kDownRight != -1) {
      if($white) array_push($board[$kDownRight]->targetedByWhite, $index);
      else array_push($board[$kDownRight]->targetedByBlack, $index);
      if($board[$kDownRight]->piece == "-") array_push($result,$kDownRight);
      else if($board[$kDownRight]->piece[0] == "W") { if(!$white) array_push($result,$kDownRight); }
      else if($board[$kDownRight]->piece[0] == "B") { if($white) array_push($result,$kDownRight); }; };
    
    if($kUpLeft != -1) {
      if($white) array_push($board[$kUpLeft]->targetedByWhite, $index);
      else array_push($board[$kUpLeft]->targetedByBlack, $index);
      if($board[$kUpLeft]->piece == "-") array_push($result,$kUpLeft);
      else if($board[$kUpLeft]->piece[0] == "W") { if(!$white) array_push($result,$kUpLeft); }
      else if($board[$kUpLeft]->piece[0] == "B") { if($white) array_push($result,$kUpLeft); }; };
    if($kUpRight != -1) {
      if($white) array_push($board[$kUpRight]->targetedByWhite, $index);
      else array_push($board[$kUpRight]->targetedByBlack, $index);
      if($board[$kUpRight]->piece == "-") array_push($result,$kUpRight);
      else if($board[$kUpRight]->piece[0] == "W") { if(!$white) array_push($result,$kUpRight); }
      else if($board[$kUpRight]->piece[0] == "B") { if($white) array_push($result,$kUpRight); }; };
    
    if($kLeftUp != -1) {
      if($white) array_push($board[$kLeftUp]->targetedByWhite, $index);
      else array_push($board[$kLeftUp]->targetedByBlack, $index);
      if($board[$kLeftUp]->piece == "-") array_push($result,$kLeftUp);
      else if($board[$kLeftUp]->piece[0] == "W") { if(!$white) array_push($result,$kLeftUp); }
      else if($board[$kLeftUp]->piece[0] == "B") { if($white) array_push($result,$kLeftUp); }; };
    if($kLeftDown != -1) {
      if($white) array_push($board[$kLeftDown]->targetedByWhite, $index);
      else array_push($board[$kLeftDown]->targetedByBlack, $index);
      if($board[$kLeftDown]->piece == "-") array_push($result,$kLeftDown);
      else if($board[$kLeftDown]->piece[0] == "W") { if(!$white) array_push($result,$kLeftDown); }
      else if($board[$kLeftDown]->piece[0] == "B") { if($white) array_push($result,$kLeftDown); }; };
    
    if($kRightUp != -1) {
      if($white) array_push($board[$kRightUp]->targetedByWhite, $index);
      else array_push($board[$kRightUp]->targetedByBlack, $index);
      if($board[$kRightUp]->piece == "-") array_push($result,$kRightUp);
      else if($board[$kRightUp]->piece[0] == "W") { if(!$white) array_push($result,$kRightUp); }
      else if($board[$kRightUp]->piece[0] == "B") { if($white) array_push($result,$kRightUp); }; };
    if($kRightDown != -1) {
      if($white) array_push($board[$kRightDown]->targetedByWhite, $index);
      else array_push($board[$kRightDown]->targetedByBlack, $index);
      if($board[$kRightDown]->piece == "-") array_push($result,$kRightDown);
      else if($board[$kRightDown]->piece[0] == "W") { if(!$white) array_push($result,$kRightDown); }
      else if($board[$kRightDown]->piece[0] == "B") { if($white) array_push($result,$kRightDown); }; };
    
    return $result;
  }

  function FindMovesBishops($index, $board) : array
  {
    $square = $board[$index];
    
    $upRightLine = $square->upRightLine;
    $upLeftLine = $square->upLeftLine;
    
    $downRightLine = $square->downRightLine;
    $downLeftLine = $square->downLeftLine;
    
    $result = [];
    
    $white = true;
    if($board[$index]->piece == "WB") $white = true; else $white = false;

    array_push($result,$this->AddFromLine($upRightLine, $board, $white, $index));
    array_push($result,$this->AddFromLine($upLeftLine, $board, $white, $index));
    
    array_push($result,$this->AddFromLine($downRightLine, $board, $white, $index));
    array_push($result,$this->AddFromLine($downLeftLine, $board, $white, $index));

    if(count($result) > 0) $result = $this->MergeArrays($result);
    
    return $result;
  }

  function FindMovesQueen($index, $board) : array
  {
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
    if($board[$index]->piece == "WQ") $white = true; else $white = false;
    
    array_push($result, $this->AddFromLine($leftLine, $board, $white, $index));
    array_push($result, $this->AddFromLine($rightLine, $board, $white, $index));
    
    array_push($result,$this->AddFromLine($upLine, $board, $white, $index));
    array_push($result,$this->AddFromLine($downLine, $board, $white, $index));

    array_push($result,$this->AddFromLine($upRightLine, $board, $white, $index));
    array_push($result,$this->AddFromLine($upLeftLine, $board, $white, $index));
    
    array_push($result,$this->AddFromLine($downRightLine, $board, $white, $index));
    array_push($result,$this->AddFromLine($downLeftLine, $board, $white, $index));

    if(count($result) > 0) $result = $this->MergeArrays($result);
    
    return $result;
  }

  function FindMovesKing($index, $board, $target) : array
  {
    $square = $board[$index];
    
    if($board[$index]->piece == "WX") $white = true; else $white = false;
    
    $up = $square->up;
    $down = $square->down;
    $left = $square->left;
    $right = $square->right;
    $upRight = $square->upRight;
    $upLeft = $square->upLeft;
    $downRight = $square->downRight;
    $downLeft = $square->downLeft;

    if($target === true)
    {
      if($up != -1) {
        if($white) array_push($board[$up]->targetedByWhite, $index);
        else array_push($board[$up]->targetedByBlack, $index);
      }
      if($down != -1) {
        if($white) array_push($board[$down]->targetedByWhite, $index);
        else array_push($board[$down]->targetedByBlack, $index);
      }
      if($left != -1) {
        if($white) array_push($board[$left]->targetedByWhite, $index);
        else array_push($board[$left]->targetedByBlack, $index);
      }
      if($right != -1) {
        if($white) array_push($board[$right]->targetedByWhite, $index);
        else array_push($board[$right]->targetedByBlack, $index);
      }
      if($upRight != -1) {
        if($white) array_push($board[$upRight]->targetedByWhite, $index);
        else array_push($board[$upRight]->targetedByBlack, $index);
      }
      if($upLeft != -1) {
        if($white) array_push($board[$upLeft]->targetedByWhite, $index);
        else array_push($board[$upLeft]->targetedByBlack, $index);
      }
      if($downLeft != -1) {
        if($white) array_push($board[$downLeft]->targetedByWhite, $index);
        else array_push($board[$downLeft]->targetedByBlack, $index);
      }
      if($downRight != -1) {
        if($white) array_push($board[$downRight]->targetedByWhite, $index);
        else array_push($board[$downRight]->targetedByBlack, $index);
      }
      return [];
    }
    
    $result = [];
    
    if($up != -1 && 
    ( ( $white === true && count($board[$up]->targetedByBlack) === 0 ) ||
    ( $white === false && count($board[$up]->targetedByWhite) === 0 ) ) ) {
      if($board[$up]->piece == "-") array_push($result,$up);
      else if($board[$up]->piece[0] == "W") { if(!$white) array_push($result,$up); }
      else if($board[$up]->piece[0] == "B") { if($white) array_push($result,$up); }; };
    if($down != -1 && 
    ( ( $white === true && count($board[$down]->targetedByBlack) === 0 ) ||
    ( $white === false && count($board[$down]->targetedByWhite) === 0 ) ) ) {
      if($board[$down]->piece == "-") array_push($result,$down);
      else if($board[$down]->piece[0] == "W") { if(!$white) array_push($result,$down); }
      else if($board[$down]->piece[0] == "B") { if($white) array_push($result,$down); }; };
    
    if($left != -1 && 
    ( ( $white === true && count($board[$left]->targetedByBlack) === 0 ) ||
    ( $white === false && count($board[$left]->targetedByWhite) === 0 ) ) ) {
      if($board[$left]->piece == "-") array_push($result,$left);
      else if($board[$left]->piece[0] == "W") { if(!$white) array_push($result,$left); }
      else if($board[$left]->piece[0] == "B") { if($white) array_push($result,$left); }; };
    if($right != -1 && 
    ( ( $white === true && count($board[$right]->targetedByBlack) === 0 ) ||
    ( $white === false && count($board[$right]->targetedByWhite) === 0 ) ) ) {
      if($board[$right]->piece == "-") array_push($result,$right);
      else if($board[$right]->piece[0] == "W") { if(!$white) array_push($result,$right); }
      else if($board[$right]->piece[0] == "B") { if($white) array_push($result,$right); }; };
    
    if($upRight != -1 && 
    ( ( $white === true && count($board[$upRight]->targetedByBlack) === 0 ) ||
    ( $white === false && count($board[$upRight]->targetedByWhite) === 0 ) ) ) {
      if($board[$upRight]->piece == "-") array_push($result,$upRight);
      else if($board[$upRight]->piece[0] == "W") { if(!$white) array_push($result,$upRight); }
      else if($board[$upRight]->piece[0] == "B") { if($white) array_push($result,$upRight); }; };
    if($upLeft != -1 && 
    ( ( $white === true && count($board[$upLeft]->targetedByBlack) === 0 ) ||
    ( $white === false && count($board[$upLeft]->targetedByWhite) === 0 ) ) ) {
      if($board[$upLeft]->piece == "-") array_push($result,$upLeft);
      else if($board[$upLeft]->piece[0] == "W") { if(!$white) array_push($result,$upLeft); }
      else if($board[$upLeft]->piece[0] == "B") { if($white) array_push($result,$upLeft); }; };
    
    if($downRight != -1 && 
    ( ( $white === true && count($board[$downRight]->targetedByBlack) === 0 ) ||
    ( $white === false && count($board[$downRight]->targetedByWhite) === 0 ) ) ) {
      if($board[$downRight]->piece == "-") array_push($result,$downRight);
      else if($board[$downRight]->piece[0] == "W") { if(!$white) array_push($result,$downRight); }
      else if($board[$downRight]->piece[0] == "B") { if($white) array_push($result,$downRight); }; };
    if($downLeft != -1 && 
    ( ( $white === true && count($board[$downLeft]->targetedByBlack) === 0 ) ||
    ( $white === false && count($board[$downLeft]->targetedByWhite) === 0 ) ) ) {
      if($board[$downLeft]->piece == "-") array_push($result,$downLeft);
      else if($board[$downLeft]->piece[0] == "W") { if(!$white) array_push($result,$downLeft); }
      else if($board[$downLeft]->piece[0] == "B") { if($white) array_push($result,$downLeft); }; };
      
    // $white - establish castle rights if king on start $square and hasn't moved
    if($white && $index == 4 && $board[$index]->firstMove && count($board[$index]->targetedByBlack) == 0)
    {
      $check = true;
      $sLen = count($square->leftLine);
      for($i = 0; $i < $sLen; $i++)
      {
        // if any squares but the last one are either not empty or under threat then cancel
        if($i < ($sLen - 1) && ($board[$square->leftLine[$i]]->piece != "-"
        || count($board[$square->leftLine[$i]]->targetedByBlack) > 0))
        {
          $check = false;
          break;
        }
        // if last $square isn't a rook with no threat then cancel
        if($i == $sLen && ($board[$square->leftLine[$i]]->piece != "WR") && $board[$i]->firstMove)
        {
          $check = false;
          break;
        }
      }
      if($check === true) array_push($result,2);

      $check = true;
      $sLen = count($square->rightLine);
      // $d = new Debug();
      for($i = 0; $i < $sLen; $i++)
      {
        // if any squares but the last one are either not empty or under threat then cancel
        if( $i < ($sLen - 1) && ( $board[$square->rightLine[$i]]->piece != "-"
        || count($board[$square->rightLine[$i]]->targetedByBlack) > 0 ) )
        {
          $check = false;
          break;
        }
        // if last $square isn't a rook with no threat then cancel
        if($i == $sLen && ($board[$square->rightLine[$i]]->piece != "WR") && $board[$i]->firstMove)
        {
          $check = false;
          break;
        }
      }
      if($check === true) array_push($result,6);
    }
    // BLACK
    if(!$white && $index == 60 && $board[$index]->firstMove && count($board[$index]->targetedByWhite) == 0)
    {
      $check = true;
      $sLen = count($square->leftLine);
      for($i = 0; $i < $sLen; $i++)
      {
        // if any squares but the last one are either not empty or under threat then cancel
        if($i < ($sLen - 1) && ($board[$square->leftLine[$i]]->piece != "-"
        || count($board[$square->leftLine[$i]]->targetedByWhite) > 0))
        {
          $check = false;
          break;
        }
        // if last $square isn't a rook with no threat then cancel
        if($i == $sLen && ($board[$square->leftLine[$i]]->piece != "BR") && $board[$i]->firstMove)
        {
          $check = false;
          break;
        }
      }
      if($check === true) array_push($result,58);

      $check = true;
      $sLen = count($square->rightLine);
      for($i = 0; $i < $sLen; $i++)
      {
        // if any squares but the last one are either not empty or under threat then cancel
        if($i < ($sLen - 1) && ($board[$square->rightLine[$i]]->piece != "-"
        || count($board[$square->rightLine[$i]]->targetedByWhite) > 0))
        {
          $check = false;
          break;
        }
        // if last $square isn't a rook with no threat then cancel
        if($i == $sLen && ($board[$square->rightLine[$i]]->piece != "BR") && $board[$i]->firstMove)
        {
          $check = false;
          break;
        }
      }
      if($check === true) array_push($result,62);
    }
    
    return $result;
  }
}