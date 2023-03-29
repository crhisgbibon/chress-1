<?php

declare(strict_types=1);

namespace App\Models\Chess\Init;

use App\Models\Chress\Square;

class NewGame
{
  public function NewBoard()
  {
    $board = [];

    $alternate = false;
    $counter = 0;
    
    for($x = 0; $x < 8; $x++)
    {
      $alternate = !$alternate;
      for($y = 0; $y < 8; $y++)
      {
        $alternate = !$alternate;
        $newSquare = new Square(
          "-",
          true,
          $alternate
        );
        $this->FindIndex($counter, $newSquare);
        array_push($board, $newSquare);
        $counter++;
      }
    }
    
    for($i = 0; $i < 64; $i++)
    {
      $board[$i]->upLine = $this->GetLine($i, "up", $board);
      $board[$i]->downLine = $this->GetLine($i, "down", $board);
      
      $board[$i]->leftLine = $this->GetLine($i, "left", $board);
      $board[$i]->rightLine = $this->GetLine($i, "right", $board);
      
      $board[$i]->upRightLine = $this->GetLine($i, "upRight", $board);
      $board[$i]->upLeftLine = $this->GetLine($i, "upLeft", $board);
      
      $board[$i]->downRightLine = $this->GetLine($i, "downRight", $board);
      $board[$i]->downLeftLine = $this->GetLine($i, "downLeft", $board);
    }
    
    $board[0]->piece = "WR";
    $board[1]->piece = "WK";
    $board[2]->piece = "WB";
    $board[3]->piece = "WQ";
    $board[4]->piece = "WX";
    $board[5]->piece = "WB";
    $board[6]->piece = "WK";
    $board[7]->piece = "WR";
    
    $i = 8;
    
    for($i; $i < 16; $i++)
    {
      $board[$i]->firstMove = true;
      $board[$i]->piece = "WP";
    }
    
    $empty = (4 * 8) + 16;
    
    for($i; $i < $empty; $i++)
    {
      $board[$i]->piece = "-";
    }
    
    $bPawn = $i + 8;
    
    for($i; $i < $bPawn; $i++)
    {
      $board[$i]->firstMove = true;
      $board[$i]->piece = "BP";
    }
    
    $board[56]->piece = "BR";
    $board[57]->piece = "BK";
    $board[58]->piece = "BB";
    $board[59]->piece = "BQ";
    $board[60]->piece = "BX";
    $board[61]->piece = "BB";
    $board[62]->piece = "BK";
    $board[63]->piece = "BR";
    
    $nLen = count($board);
    
    for($i = 0; $i < $nLen; $i++)
    {
      $board[$i]->moves = [];
      $board[$i]->targetedByWhite = [];
      $board[$i]->targetedByBlack = [];
    }
    
    for($i = 0; $i < $nLen; $i++)
    {
      $piece = $board[$i]->piece;
      if($piece == "WP" || $piece == "BP") $board[$i]->moves = $this->FindMovesPawn($i, $board);
      if($piece == "WR" || $piece == "BR") $board[$i]->moves = $this->FindMovesRook($i, $board);
      if($piece == "WK" || $piece == "BK") $board[$i]->moves = $this->FindMovesKnight($i, $board);
      if($piece == "WB" || $piece == "BB") $board[$i]->moves = $this->FindMovesBishops($i, $board);
      if($piece == "WQ" || $piece == "BQ") $board[$i]->moves = $this->FindMovesQueen($i, $board);
      if($piece === "WX"){
        $kingW = $i;
      };
      if($piece === "BX"){ 
        $kingB = $i;
      };
    }

    // assign king moves
    $this->FindMovesKing($kingW, $board, true);
    $this->FindMovesKing($kingB, $board, true);
    $board[$kingW]->moves = $this->FindMovesKing($kingW, $board, false);
    $board[$kingB]->moves = $this->FindMovesKing($kingB, $board, false);
    
    $this->board = $board;
    $this->currentMove = 0;
    $this->currentMoveWhite = 0;
    $this->currentMoveBlack = 0;

    $newMove = [[0, 0], [0, 0]];
    $sArray = $this->GetSaveTurn($newMove, $this->state);
    array_push($this->saveList, $sArray);
  }
}