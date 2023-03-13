<?php

declare(strict_types=1);

namespace App\Models\Chress;

class ChessRules
{
  private array $board;

  private bool $turn; // true = $white, false = black
  private int $lastMoved = -1; // $index of the last moved $piece

  private bool $whiteAI; // if $white is AI
  private bool $blackAI; // if black is AI

  private int $currentMove; // for tracking along game history
  private array $saveList = []; // document of saved turns
  private float $fifty = 0; // counts 50 move draw

  // PGN information about the game
  private string $state;

  public function __construct(
    GameModel $game
  )
  {
    $this->board = $game->board;

    $this->turn = $game->turn;
    $this->lastMoved = $game->lastMoved;

    $this->whiteAI = $game->whiteAI;
    $this->blackAI = $game->blackAI;

    $this->currentMove = $game->currentMove;
    $this->saveList = $game->saveList;
    $this->fifty = $game->fifty;

    $this->state = $game->state;
  }

  public function GetBoard() : array
  {
    $count = count($this->board);

    if($count === 0) return [];

    $output = [];

    for($i = 0; $i < $count; $i++)
    {
      $saveData = [$i, $this->board[$i]->GetPiece()];
      array_push($output, $saveData);
    }

    return $output;
  }

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
      if($piece == "WX" || $piece == "BX") $board[$i]->moves = $this->FindMovesKing($i, $board);
    }
    
    $this->board = $board;
  }

  private function FindIndex(int $index, $square)
  {
    $indexInt = $index;
    $square->index = $index;

    $col = (int)$indexInt % 8;
    $row = (int)floor($indexInt / 8);
    
    $square->col = $col;
    $square->row = $row;
    
    if($row < 7) $square->up = ($indexInt + 8); else $square->up = -1;
    if($row > 0) $square->down = ($indexInt - 8); else $square->down = -1;
    
    if($col > 0) $square->left = ($indexInt - 1); else $square->left = -1;
    if($col < 7) $square->right = ($indexInt + 1); else $square->right = -1;
    
    if($row < 7 && $col > 0) $square->upLeft = ($indexInt + 7); else $square->upLeft = -1;
    if($row < 7 && $col < 7) $square->upRight = ($indexInt + 9); else $square->upRight = -1;
    
    if($row > 0 && $col > 0) $square->downLeft = ($indexInt - 9); else $square->downLeft = -1;
    if($row > 0 && $col < 7) $square->downRight = ($indexInt - 7); else $square->downRight = -1;
    
    if($row < 6 && $col < 7) $square->kUpRight = ($indexInt + 17); else $square->kUpRight = -1;
    if($row < 6 && $col > 0) $square->kUpLeft = ($indexInt + 15); else $square->kUpLeft = -1;
    
    if($row < 7 && $col > 1) $square->kLeftUp = ($indexInt + 6); else $square->kLeftUp = -1;
    if($row > 0 && $col > 1) $square->kLeftDown = ($indexInt - 10); else $square->kLeftDown = -1;
    
    if($row > 1 && $col < 7) $square->kDownRight = ($indexInt - 15); else $square->kDownRight = -1;
    if($row > 1 && $col > 0) $square->kDownLeft = ($indexInt - 17); else $square->kDownLeft = -1;
    
    if($row < 7 && $col < 6) $square->kRightUp = ($indexInt + 10); else $square->kRightUp = -1;
    if($row > 0 && $col < 6) $square->kRightDown = ($indexInt - 6); else $square->kRightDown = -1;
  }

  public function GetMoves(int $index) : array
  {
    $square = $this->board[$index];

    if($square->piece === "-") return [];
    if($this-> turn === true && $square->piece[0] === "B") return [];
    if($this-> turn === false && $square->piece[0] === "W") return [];

    $this->lastMoved = $index;

    return $square->moves;
  }

  public function MovePiece(int $index) : array
  {
    $from = $this->lastMoved;
    $to = $index;
    $board = $this->board;
    
    // stop any manipulation, can't move to a square not in the move list
    if(in_array($to, $board[$from]->moves) === false) return ["MOVE NOT VALID"];
    
    // reset the game state flag
    $this->state = "";
    
    // execute the piece move
    $this->UpdateBoard((int)$from, (int)$to, $board, "Q");
    // swap turns and generate the new move list
    $this->turn = !$this->turn;
    $this->EvaluateBoard();
    $this->currentMove++;
    
    if($this->state === "CHECKMATEWHITE" || $this->state === "CHECKMATEBLACK" ||
    $this->state === "DRAW50" || $this->state === "DRAWMATERIAL" ||
    $this->state === "DRAWSTALEMATE" || $this->state === "DRAWTHREE")
    {
      for($i = 0; $i < count($this->board); $i++)
      {
        $this->board[$i]->moves = [];
      }
    }
    
    // if the player is creating a new branch game, for now overwrite any future moves
    // in the future can turn savelist into a multidimensional array to save multiple branches of a game
    if($this->currentMove !== count($this->saveList))
    {
      $this->saveList = array_slice($this->saveList, 0, $this->currentMove);
    }
    // save the move
    $newMove = [[$from, $this->board[$from]->piece], [$to, $board[$to]->piece]];
    $sArray = $this->GetSaveTurn($newMove, $this->state);
    array_push($this->saveList, $sArray);
    
    // set an ai move if either side is run by the ai and it is it's turn
    // set custom diversion for cases where both ai sides are running
    if($this->blackAI && $this->whiteAI) return ["AI V AI NOT SET UP"];
    if($this->blackAI || $this->whiteAI)
    {
      /*
      $aiMove = [-1, -1];
      if((!$this->turn && $this->blackAI) || 
      ($this->turn && $this->whiteAI)) aiMove = GetHalMove(gArray[currentG]);

      // if an ai move was running then update the board for that move
      if(aiMove[0] != -1 && aiMove[1] != -1)
      {
        // reset the game state flag
        $this->state = "";
    
        UpdateBoard(aiMove[0], aiMove[1], $this->board, gArray[currentG]);
        $this->turn = !$this->turn;
        EvaluateBoard(gArray[currentG]);
        $this->currentMove++;
        
        if($this->state == "CHECKMATEWHITE" || $this->state == "CHECKMATEBLACK" ||
        $this->state == "DRAW50" || $this->state == "DRAWMATERIAL" ||
        $this->state == "DRAWSTALEMATE" || $this->state == "DRAWTHREE")
        {
          for($i = 0; i < $this->board.length; i++)
          {
            $this->board[i].moves = [];
          }
        }
        
        // save the move
        $newMove1 = [[from, board[from].piece], [to, board[to].piece]];
        $sArray1 = GetSaveTurn(gArray[currentG], newMove1, $this->state);
        $this->saveList.push(sArray1);
        
      }
      */
    }
    
    $score = $this->ScoreBoard();
    // get the final piece array to export back to display
    $newPieces = $this->GetBoard();
    $r = [$newPieces, $from, $to, $this->currentMove, count($this->saveList), $this->state, $score];

    return $r;
  }
  
  private function UpdateBoard(int $from, int $to, array $board, string $promoteTo) : void
  {
    // CHECK if castle move - in which case reallocate Rook
    // left side white castle
    if($board[$from]->piece === "WX" && $from === 4 
    && $board[$from]->firstMove && $to === 2)
    {
      $board[0]->piece = "-";
      $board[3]->piece = "WR";
    }
    // right side white castle
    if($board[$from]->piece === "WX" && $from === 4 
    && $board[$from]->firstMove && $to === 6)
    {
      $board[7]->piece = "-";
      $board[5]->piece = "WR";
    }
    // left side black castle
    if($board[$from]->piece === "BX" && $from === 60 
    && $board[$from]->firstMove && $to === 58)
    {
      $board[56]->piece = "-";
      $board[59]->piece = "BR";
    }
    // right side black castle
    if($board[$from]->piece === "BX" && $from === 60 
    && $board[$from]->firstMove && $to === 62)
    {
      $board[63]->piece = "-";
      $board[61]->piece = "BR";
    }
    
    // enpassant LOG white pawn
    if($board[$from]->piece === "WP" && $board[$from]->firstMove 
    && $to === $board[$board[$from]->up]->up)
    {
      $board[$to]->enPassant = 2;
    }
    
    // enpassant LOG black pawn
    if($board[$from]->piece === "BP" && $board[$from]->firstMove 
      && $to === $board[$board[$from]->down]->down)
    {
      $board[$to]->enPassant = 2;
    }
    
    // enpassant CAPTURE white
    if($board[$from]->piece === "WP" && $board[$to]->piece === "-"
    && $board[$from]->col !== $board[$to]->col)
    {
      $this->fifty = 0;
      $board[($to - 8)]->piece = "-";
    }
    
    // enpassant CAPTURE black
    if($board[$from]->piece === "BP" && $board[$to]->piece === "-"
    && $board[$from]->col !== $board[$to]->col)
    {
      $this->fifty = 0;
      $board[($to + 8)]->piece = "-";
    }
    
    // increment fifty by 0->5 each side so can trigger startin $from black or white
    $this->fifty += 0.5;
    // reset fifty rule if $to contains a piece
    if($board[$to]->piece !== "-") $this->fifty = 0;
    // reset fifty rule if $from piece was a pawn
    if($board[$from]->piece[1] === "P") $this->fifty = 0;
    // move the actual piece and overwrite the target if it did contain a piece
    $board[$to]->piece = $board[$from]->piece;
    $board[$from]->piece = "-";
    
    // change firstMove status
    if($board[$from]->firstMove === true) $board[$from]->firstMove = false;
    
    // auto promote $to queen for now
    if($board[$to]->piece === "WP" && $board[$to]->row === 7)
    {
      if($promoteTo !== null) $board[$to]->piece = "W" + $promoteTo;
      else $board[$to]->piece = "WQ";
    }
    if($board[$to]->piece === "BP" && $board[$to]->row === 0)
    {
      if($promoteTo !== null) $board[$to]->piece = "B" + $promoteTo;
      else $board[$to]->piece = "BQ";
    }
  }

  private function EvaluateBoard()
  {
  // clear previous moves data
  for($i = 0; $i < count($this->board); $i++)
  {
    $this->board[$i]->moves = [];
    $this->board[$i]->targetedByWhite = [];
    $this->board[$i]->targetedByBlack = [];
    $this->board[$i]->xRayWhite = [];
    $this->board[$i]->xRayBlack = [];
    if($this->board[$i]->enPassant > 0) $this->board[$i]->enPassant--;
  }

  // get the raw moves for each $piece that can move
  // find index for $king

  $king = -1;
  $kingW = -1;
  $kingB = -1;

  for($i = 0; $i < count($this->board); $i++)
  {
    $piece = $this->board[$i]->piece;
    if($piece === "WP" || $piece === "BP") $this->board[$i]->moves = $this->FindMovesPawn($i, $this->board);
    if($piece === "WR" || $piece === "BR") $this->board[$i]->moves = $this->FindMovesRook($i, $this->board);
    if($piece === "WK" || $piece === "BK") $this->board[$i]->moves = $this->FindMovesKnight($i, $this->board);
    if($piece === "WB" || $piece === "BB") $this->board[$i]->moves = $this->FindMovesBishops($i, $this->board);
    if($piece === "WQ" || $piece === "BQ") $this->board[$i]->moves = $this->FindMovesQueen($i, $this->board);
    if($piece === "WX" || $piece === "BX") $this->board[$i]->moves = $this->FindMovesKing($i, $this->board);
    if($piece === "WX"){
      if($this->turn) $king = $i; 
      $kingW = $i;
    };
    if($piece === "BX"){ 
      if(!$this->turn) $king = $i; 
      $kingB = $i;
    };
  }
  
  //if($kingW != -1) $this->board[$kingW]->moves = $this->FindMovesKing($kingW, $this->board);
  //if($kingB != -1) $this->board[$kingB]->moves = $this->FindMovesKing($kingB, $this->board);
  
  // FREEZE XRAY PIECES
  if($this->turn && count($this->board[$king]->xRayBlack) > 0)
  {
    for($x = 0; $x < count($this->board[$king]->xRayBlack); $x++)
    {
      $xLine = $this->FindXRayLine($king, $this->board[$king]->xRayBlack[$x]);
      
      // if there is more than 1 black piece between king and white piece then don't freeze any
      // if there is only 1 piece freeze it
      // don't go past the white $piece

      $piecesToFreeze = [];
      $hitOther = false;

      for($i = 0; $i < count($xLine); $i++)
      {
        if($hitOther === false)
        {
          if($this->board[$xLine[$i]]->piece[0] === "W")
          {
            array_push($piecesToFreeze, $xLine[$i]);
          }
          if($this->board[$xLine[$i]]->piece[0] === "B")
          {
            $hitOther = true;
          }
        }
      }
      
      if(count($piecesToFreeze) === 1)
      {
        $newMoves1 = [];
        for($m = 0; $m < count($this->board[$piecesToFreeze[0]]->moves); $m++)
        {
          if(in_array($xLine, $this->board[$piecesToFreeze[0]]->moves[$m])) array_push($newMoves1, $this->board[$piecesToFreeze[0]]->moves[$m]);
        }
        // frozen pieces can move along the XRayLine
        $this->board[$piecesToFreeze[0]]->moves = [];
        $this->board[$piecesToFreeze[0]]->moves = $newMoves1;
      }
    }
  }
  // freeze black pieces
  if(!$this->turn && count($this->board[$king]->xRayWhite) > 0)
  {
    
    for($x = 0; $x < count($this->board[$king]->xRayWhite); $x++)
    {
      $xLine = $this->FindXRayLine($king, $this->board[$king]->xRayWhite[$x]);
      
      // if there is more than 1 black $piece between $king and white $piece then don'$t freeze any
      // if there is only 1 $piece freeze it
      // don'$t go past the white $piece
      $piecesToFreeze = [];
      $hitOther = false;
      for($i = 0; $i < count($xLine); $i++)
      {
        if($hitOther === false)
        {
          if($this->board[$xLine[$i]]->piece[0] === "B")
          {
            array_push($piecesToFreeze, $xLine[$i]);
          }
          if($this->board[$xLine[$i]]->piece[0] === "W")
          {
            $hitOther = true;
          }
        }
      }
      
      if(count($piecesToFreeze) === 1)
      {
        $newMoves1 = [];
        $flatMoves2 = $this->board[$piecesToFreeze[0]]->moves->flat();
        for($m = 0; $m < count($flatMoves2); $m++)
        {
          if(in_array($xLine, $flatMoves2[$m])) array_push($newMoves1, $flatMoves2[$m]);
        }
        // frozen pieces can move along the XRayLine
        $this->board[$piecesToFreeze[0]]->moves = [];
        $this->board[$piecesToFreeze[0]]->moves = $newMoves1;
      }
    }
  }
  
  // fifty move rule draw
  if($this->fifty >= 50)
  {
    $this->state = "DRAW50";
  }
  
  // insufficient material
  // king v king - done
  // king and bishop v king - done
  // king and knight v king - done
  // king and bishop v king and bishop of same colours
  $whiteRemaining = [];
  $blackRemaining = [];
  $bishopWhite = false;
  $bishopBlack = false;
  for($i = 0; $i < count($this->board); $i++)
  {
    if($this->board[$i]->piece[0] === "W")
    {
      array_push($whiteRemaining, $this->board[$i]->piece);
      if($this->board[$i]->piece[1] === "B") $bishopWhite = $this->board[$i]->white;
    }
    if($this->board[$i]->piece[0] === "B")
    {
      array_push($blackRemaining, $this->board[$i]->piece);
      if($this->board[$i]->piece[1] === "B") $bishopBlack = $this->board[$i]->white;
    }
  }
  // king v king
  if(count($whiteRemaining) === 1 && $whiteRemaining[0] === "WX" &&
  count($blackRemaining) === 1 && $blackRemaining[0] === "BX")
  {
    $this->state = "DRAWMATERIAL";
  }
  // white king and bishop v black king
  if(count($whiteRemaining) === 2 && in_array($whiteRemaining, ["WX"]) && in_array($whiteRemaining, ["WB"]) &&
  count($blackRemaining) === 1 && $blackRemaining[0] === "BX")
  {
    $this->state = "DRAWMATERIAL";
  }
  // black king and bishop v white king
  if(count($blackRemaining) === 2 && in_array($blackRemaining, ["BX"]) && in_array($blackRemaining, ["BB"]) &&
  count($whiteRemaining) === 1 && $whiteRemaining[0] === "WX")
  {
    $this->state = "DRAWMATERIAL";
  }
  // white king and knight v black king
  if(count($whiteRemaining) === 2 && in_array($whiteRemaining, ["WX"]) && in_array($whiteRemaining, ["WK"]) &&
  count($blackRemaining) === 1 && $blackRemaining[0] === "BX")
  {
    $this->state = "DRAWMATERIAL";
  }
  // black king and knight v white king
  if(count($blackRemaining) === 2 && in_array($blackRemaining, ["BX"]) && in_array($blackRemaining, ["BK"]) &&
  count($whiteRemaining) === 1 && $whiteRemaining[0] === "WX")
  {
    $this->state = "DRAWMATERIAL";
  }
  // king and bishop v king and bishop same colour
  if(count($blackRemaining) === 2 && in_array($blackRemaining, ["BX"]) && in_array($blackRemaining, ["BB"]) &&
  count($whiteRemaining) === 2 && in_array($whiteRemaining, ["WX"]) && in_array($whiteRemaining, ["WB"]))
  {
    if($bishopWhite === $bishopBlack) $this->state = "DRAWMATERIAL";
  }

  // threefold repetition
  $threeFoldArray = [];
  $threeFoldCount = [];
  for($i = 0; $i < count($this->saveList); $i++)
  {
    $testString = json_encode($this->saveList[$i]);
    $check = true;
    
    for($t = 0; $t < count($threeFoldArray); $t++) if($testString === $threeFoldArray[$t])
    {
      $check = false;
    }
    
    if($check)
    {
      array_push($threeFoldArray, $testString);
      array_push($threeFoldCount, 1);
    }
    else
    {
      $io = array_search($testString, $threeFoldArray);
      $threeFoldCount[$io]++;
    }
  }
  for($i = 0; $i < count($threeFoldArray); $i++)
  {
    if($threeFoldCount[$i] >= 3) $this->state = "DRAWTHREE";
  }
  
  // Stalemate check - if king not in check
  if(($this->turn && count($this->board[$king]->targetedByBlack) === 0) ||
  (!$this->turn && count($this->board[$king]->targetedByWhite) === 0))
  {
    $moveCount = 0;
    for($i = 0; $i < count($this->board); $i++)
    {
      $piece = $this->board[$i]->piece;
      if($this->turn && $piece[0] === "W") { $moveCount += count($this->board[$i]->moves); };
      if(!$this->turn && $piece[0] === "B") { $moveCount += count($this->board[$i]->moves); };
    }
    if($moveCount === 0)
    {
      $this->state = "DRAWSTALEMATE";
    }
  }

  // if king is attacked then in check
  // white king in $check
  if($this->turn && count($this->board[$king]->targetedByBlack) > 0)
  {
    $this->state = "CHECKWHITE";    
    
    // list of all squares that saves check, 
    $checkSaves = [];
    $checkLine = [];
    // if targetedbyBlack > 1, only escape is for king to move
    $doubleCheck = false;
    if(count($this->board[$king]->targetedByBlack) > 1) $doubleCheck = true;
    
    for($i = 0; $i < count($this->board[$king]->targetedByBlack); $i++)
    {
      // get the square of the checking piece
      $checkingSquare = $this->board[$this->board[$king]->targetedByBlack[$i]];
      // need to remove all squares from behind the king so doesn't escape check along it
      // if queen bishop or rook then need to add all squares along line between king and piece as checksaves
      // this will include the checking square
      if($checkingSquare->piece === "BR" || $checkingSquare->piece === "BB" || $checkingSquare->piece === "BQ")
      {
        array_push($checkSaves, $this->GetCheckSaves($king, $this->board[$king]->targetedByBlack[$i]));
        array_push($checkLine, $this->GetCheckLine($king, $this->board[$king]->targetedByBlack[$i]));
      }
      else
      {
        // can always save check by capturing the checking piece
        array_push($checkSaves, $this->GetCheckSaves($king, $this->board[$king]->targetedByBlack[$i]));
      }
    }
    
    // stop the king from trying to escape check by moving backwards along the checking line
    if(count($checkLine) > 0) $checkLine = $this->MergeArrays($checkLine);
    if(count($checkLine) > 0)
    {
      $newKingMoves = [];
      for($i = 0; $i < count($this->board[$king]->moves); $i++)
      {
        if(!in_array($checkLine, [$this->board[$king]->moves[$i]])) array_push($newKingMoves, $this->board[$king]->moves[$i]);
      }
      $this->board[$king]->moves = [];
      $this->board[$king]->moves = $newKingMoves;
    }
    
    if(count($checkSaves) > 0) $checkSaves = $this->MergeArrays($checkSaves);
    
    // check if the checking piece was a pawn which can be captured en passant, so other pawns can check if they can capture it in response
    $enPassantCheck = [];
    for($i = 0; $i < count($this->board[$king]->targetedByBlack); $i++)
    {
      $checkingSquare = $this->board[$this->board[$king]->targetedByBlack[$i]];
      if($checkingSquare->piece === "BP" && $checkingSquare->enPassant > 0)
      {
        array_push($enPassantCheck, $this->board[$this->board[$king]->targetedByBlack[$i]]->up);
      }
    }
    if(count($checkSaves) > 0)
    {
      $gameSaveMoves = [];
      // once have checksave list, remove all moves that aren't on it
      for($i = 0; $i < count($this->board); $i++)
      {
        if($this->board[$i]->piece === "-" || $this->board[$i]->piece[0] === "B") continue;
        
        if(count($this->board[$i]->moves) > 0)
        {
          // check if the piece is a pawn and can capture in the enPassantCheck array, in which case save those moves to re-add to moves array
          $saveEnPassant = [];
          if($this->board[$i]->piece === "WP" && count($enPassantCheck) > 0)
          {
            for($m = 0; $m < count($this->board[$i]->moves); $m++)
            {
              if(in_array($enPassantCheck, [$this->board[$i]->moves[$m]]))
              {
                array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
                array_push($saveEnPassant, $this->board[$i]->moves[$m]);
              }
            }
          }
        
          // if the piece is not the king, remove all moves that aren't in checkmoves (i.e. block or capture only)
          if($this->board[$i]->piece !== "WX")
          {
            // if double check then only king can move
            if(!$doubleCheck)
            {
              $newMoves = [];
              for($m = 0; $m < count($this->board[$i]->moves); $m++)
              {
                if(in_array($checkSaves, [$this->board[$i]->moves[$m]]))
                {
                  array_push($newMoves, $this->board[$i]->moves[$m]);
                  array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
                }
              }
              $this->board[$i]->moves = $newMoves;
              if(count($saveEnPassant) > 0) for($s = 0; $s < count($saveEnPassant); $s++) array_push($this->board[$i]->move, $saveEnPassant[$s]);
            }
          }
          else
          {
            // if the king piece, only add moves that arent in checksaves
            // except for if the king can capture the piece checking, and that piece isn't itself threatByWhite
            $newMoves = [];
            for($m = 0; $m < count($this->board[$i]->moves); $m++)
            {
              // run away from $check
              if(!in_array($checkSaves, [$this->board[$i]->moves[$m]]))
              {
                array_push($newMoves, $this->board[$i]->moves[$m]);
                array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
              }
              // or capture the checking piece if it isn't itself targetted (can't capture into check)
              if(in_array($this->board[$king]->targetedByBlack, [$this->board[$i]->moves[$m]]))
              {
                if(count($this->board[$this->board[$i]->moves[$m]]->targetedByBlack) === 0)
                {
                  array_push($newMoves, $this->board[$i]->moves[$m]);
                  array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
                }
              }
            }
            $this->board[$i]->moves = [];
            $this->board[$i]->moves = $newMoves;
          }
        }
      }
      // if $king has no moves and doublecheck, checkmate
      if(count($this->board[$king]->moves) === 0 && $doubleCheck)
      {
        $this->state = "CHECKMATEWHITE";
      }
      // if none then checkmate
      if(count($gameSaveMoves) === 0)
      {
        $this->state = "CHECKMATEWHITE";
      }
    }
    else if(count($checkSaves) === 0 && count($enPassantCheck) > 0)
    {
      // if no checksaves, still might be en passant is an option
      $gameSaveMoves = [];
      
      for($i = 0; $i < count($this->board); $i++)
      {
        // ignore anything not a pawn
        if($this->board[$i]->piece !== "WP") continue;
        
        if(count($this->board[$i]->moves) > 0)
        {
          // $check if the piece is a pawn and can capture in the enPassantCheck array, in which case save those moves to re-add to moves array
          $saveEnPassant = [];
          if(count($enPassantCheck) > 0)
          {
            for($m = 0; $m < count($this->board[$i]->moves); $m++)
            {
              if(in_array($enPassantCheck, [$this->board[$i]->moves[$m]]))
              {
                array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
                array_push($saveEnPassant, $this->board[$i]->moves[$m]);
              }
            }
          }
          
          // if any saving en passant moves, replace pawns move array with them
          if(count($saveEnPassant) > 0)
          {
            $this->board[$i]->moves = [];
            for($s = 0; $s < count($saveEnPassant); $s++) array_push($this->board[$i]->moves, $saveEnPassant[$s]);
          }
        }
      }
      
      // if king has no moves and doublecheck, checkmate
      if(count($this->board[$king]->moves) === 0 && $doubleCheck)
      {
        $this->state = "CHECKMATEWHITE";
      }
      // if none then checkmate
      if(count($gameSaveMoves) === 0)
      {
        $this->state = "CHECKMATEWHITE";
      }
    }
    else
    {
      // if no checkmoves or en passant saves then must be checkmate
      $this->state = "CHECKMATEWHITE";
    }
  }
  // black king in check
  if(!$this->turn && count($this->board[$king]->targetedByWhite) > 0)
  {
    $this->state = "CHECKBLACK";
    // list of all squares that saves check, 
    $checkSaves = [];
    $checkLine = [];
    // if targetedbyWhite > 1, only escape is for king to move
    $doubleCheck = false;
    if(count($this->board[$king]->targetedByWhite) > 1) $doubleCheck = true;
    
    for($i = 0; $i < count($this->board[$king]->targetedByWhite); $i++)
    {
      // get the square of the checking $piece
      $checkingSquare = $this->board[$this->board[$king]->targetedByWhite[$i]];
      // need to remove all squares from behind the king so doesn't escape check along it
      // if queen bishop or rook then need to add all squares along line between king and piece as checksaves
      // this will include the checking square
      if($checkingSquare->piece === "WR" || $checkingSquare->piece === "WB" || $checkingSquare->piece === "WQ")
      {
        array_push($checkSaves, $this->GetCheckSaves($king, $this->board[$king]->targetedByWhite[$i]));
        array_push($checkLine, $this->GetCheckLine($king, $this->board[$king]->targetedByWhite[$i]));
      }
      else
      {
        // can always save check by capturing the checking piece
        array_push($checkSaves, $this->GetCheckSaves($king, $this->board[$king]->targetedByWhite[$i]));
      }
    }

    if(count($checkLine) > 0)
    {
      if(count($checkLine) > 0) $checkLine = $this->MergeArrays($checkLine);
      $newKingMoves = [];
      for($i = 0; $i < count($this->board[$king]->moves); $i++)
      {
        if(!in_array($checkLine, [$this->board[$king]->moves[$i]])) array_push($newKingMoves, $this->board[$king]->moves[$i]);
      }
      $this->board[$king]->moves = [];
      $this->board[$king]->moves = $newKingMoves;
    }

    if(count($checkSaves) > 0) $checkSaves = $this->MergeArrays($checkSaves);
    
    // check if the checking piece was a pawn which can be captured en passant, so other pawns can check if they can capture it in response
    $enPassantCheck = [];
    for($i = 0; $i < count($this->board[$king]->targetedByWhite); $i++)
    {
      $checkingSquare = $this->board[$this->board[$king]->targetedByWhite[$i]];

      if($checkingSquare->piece === "WP" && $checkingSquare->enPassant > 0)
      {
        array_push($enPassantCheck, $this->board[$this->board[$king]->targetedByWhite[$i]]->down);
      }
    }

    if(count($checkSaves) > 0)
    {
      $gameSaveMoves = [];
      // once have checksave list, remove all moves that aren't on it
      for($i = 0; $i < count($this->board); $i++)
      {
        if($this->board[$i]->piece === "-" || $this->board[$i]->piece[0] === "W") continue;
        if(count($this->board[$i]->moves) > 0)
        {
          // check if the piece is a pawn and can capture in the enPassantCheck array, in which case save those moves to re-add to moves array
          $saveEnPassant = [];
          if($this->board[$i]->piece === "BP" && count($enPassantCheck) > 0)
          {
            for($m = 0; $m < count($this->board[$i]->moves); $m++)
            {
              if(in_array($enPassantCheck, [$this->board[$i]->moves[$m]]))
              {
                array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
                array_push($saveEnPassant, $this->board[$i]->moves[$m]);
              }
            }
          }
          
          // if the piece is not the king, only keep moves that are in checksaves (i.e. block or capture only)
          if($this->board[$i]->piece !== "BX")
          {
            if(!$doubleCheck)
            {
              $newMoves = [];
              for($m = 0; $m < count($this->board[$i]->moves); $m++)
              {
                if(in_array($checkSaves, [$this->board[$i]->moves[$m]]))
                {
                  array_push($newMoves, $this->board[$i]->moves[$m]);
                  array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
                }
              }
              $this->board[$i]->moves = [];
              $this->board[$i]->moves = $newMoves;
              if(count($saveEnPassant) > 0) for($s = 0; $s < count($saveEnPassant); $s++) array_push($this->board[$i]->moves, $saveEnPassant[$s]);
            }
          }
          else
          {
            // if the king piece, only add moves that arent in checksaves
            // except for if the king can capture the piece checking, and that piece isn't itself threatByWhite
            $newMoves = [];
            for($m = 0; $m < count($this->board[$i]->moves); $m++)
            {
              // run away from check
              if(!in_array($checkSaves, [$this->board[$i]->moves[$m]]))
              {
                array_push($newMoves, $this->board[$i]->moves[$m]);
                array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
              }
              // or capture the checking piece if it isn't itself targeted (can't capture into check)
              if(in_array($this->board[$king]->targetedByWhite, [$this->board[$i]->moves[$m]]))
              {
                if(count($this->board[$this->board[$i]->moves[$m]]->targetedByWhite) === 0 && $this->board[$this->board[$i]->moves[$m]]->piece != "-")
                {
                  array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
                  array_push($newMoves, $this->board[$i]->moves[$m]);
                }
              }
            }
            $this->board[$i]->moves = [];
            $this->board[$i]->moves = $newMoves;
          }
        }
      }
      // if king has no moves and doublecheck, checkmate
      if(count($this->board[$king]->moves) === 0 && $doubleCheck)
      {
        $this->state = "CHECKMATEBLACK";
      }
      // if none then checkmate
      if(count($gameSaveMoves) === 0)
      {
        $this->state = "CHECKMATEBLACK";
      }
    }
    else if(count($checkSaves) === 0 && count($enPassantCheck) > 0)
    {
      // if no checksaves, still might be en passant is an option
      $gameSaveMoves = [];
      
      for($i = 0; $i < count($this->board); $i++)
      {
        // ignore anything not a pawn
        if($this->board[$i]->piece !== "BP") continue;
        
        if(count($this->board[$i]->moves) > 0)
        {
          // $check if the $piece is a pawn and can capture in the enPassantCheck array, in which case save those moves to re-add to moves array
          $saveEnPassant = [];
          if(count($enPassantCheck) > 0)
          {
            for($m = 0; $m < count($this->board[$i]->moves); $m++)
            {
              if(in_array($enPassantCheck, [$this->board[$i]->moves[$m]]))
              {
                array_push($gameSaveMoves, $this->board[$i]->moves[$m]);
                array_push($newMoves, $this->board[$i]->moves[$m]);
              }
            }
          }
          
          // if any saving en passant moves, replace pawns move array with them
          if(count($saveEnPassant) > 0)
          {
            $this->board[$i]->moves = [];
            for($s = 0; $s < count($saveEnPassant); $s++) array_push($this->board[$i]->moves, $saveEnPassant[$s]);
          }
        }
      }
      
      // if king has no moves and doublecheck, checkmate
      if(count($this->board[$king]->moves) === 0 && $doubleCheck)
      {
        $this->state = "CHECKMATEWHITE";
      }
      // if none then checkmate
      if(count($gameSaveMoves) === 0)
      {
        $this->state = "CHECKMATEWHITE";
      }
    }
    else
    {
      // if no checkmoves or en passant saves then must be checkmate
      $this->state = "CHECKMATEWHITE";
    }
  }
}

// if a piece has xray from other side, find the line and return if the king is on it
private function FindXRayLine($king, $targetedBy)
{
  $lineToCheck = [];
  if(count($this->board[$king]->leftLine) > 0) if(in_array($this->board[$king]->leftLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->leftLine;
  if(count($this->board[$king]->rightLine) > 0) if(in_array($this->board[$king]->rightLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->rightLine;
  if(count($this->board[$king]->downLine) > 0) if(in_array($this->board[$king]->downLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->downLine;
  if(count($this->board[$king]->upLine) > 0) if(in_array($this->board[$king]->upLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->upLine;
  if(count($this->board[$king]->upRightLine) > 0) if(in_array($this->board[$king]->upRightLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->upRightLine;
  if(count($this->board[$king]->upLeftLine) > 0) if(in_array($this->board[$king]->upLeftLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->upLeftLine;
  if(count($this->board[$king]->downRightLine) > 0) if(in_array($this->board[$king]->downRightLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->downRightLine;
  if(count($this->board[$king]->downLeftLine) > 0) if(in_array($this->board[$king]->downLeftLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->downLeftLine;
  return $lineToCheck;
}

// finds the line that a checking piece is on, where pieces can therefore move to block
function GetCheckSaves($king, $targetedBy)
{
  $lineToCheck = [];
  if(count($this->board[$king]->leftLine) > 0) if(in_array($this->board[$king]->leftLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->leftLine;
  if(count($this->board[$king]->rightLine) > 0) if(in_array($this->board[$king]->rightLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->rightLine;
  if(count($this->board[$king]->downLine) > 0) if(in_array($this->board[$king]->downLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->downLine;
  if(count($this->board[$king]->upLine) > 0) if(in_array($this->board[$king]->upLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->upLine;
  if(count($this->board[$king]->upRightLine) > 0) if(in_array($this->board[$king]->upRightLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->upRightLine;
  if(count($this->board[$king]->upLeftLine) > 0) if(in_array($this->board[$king]->upLeftLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->upLeftLine;
  if(count($this->board[$king]->downRightLine) > 0) if(in_array($this->board[$king]->downRightLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->downRightLine;
  if(count($this->board[$king]->downLeftLine) > 0) if(in_array($this->board[$king]->downLeftLine, [$targetedBy]))
    $lineToCheck = $this->board[$king]->downLeftLine;
  if(count($lineToCheck) === 0) return;
  $result = [];
  for($i = 0; $i < count($lineToCheck); $i++)
  {
    if($this->board[$lineToCheck[$i]]->piece === "-") array_push($result, $lineToCheck[$i]);
    else
    {
      array_push($result, $lineToCheck[$i]);
      break;
    }
  }
  
  return $result;
}

// gets the opposite check line to remove all squares from the king, so doesn't escape backwards along it
function GetCheckLine($king, $targetedBy)
{
  $lineToCheck = [];
  if(count($this->board[$king]->leftLine) > 0) if(in_array($this->board[$king]->leftLine, [$targetedBy]))
    if(count($this->board[$king]->rightLine) > 0) $lineToCheck = $this->board[$king]->rightLine;
  if(count($this->board[$king]->rightLine) > 0) if(in_array($this->board[$king]->rightLine, [$targetedBy]))
    if(count($this->board[$king]->leftLine) > 0) $lineToCheck = $this->board[$king]->leftLine;
  
  if(count($this->board[$king]->downLine) > 0) if(in_array($this->board[$king]->downLine, [$targetedBy]))
    if(count($this->board[$king]->upLine) > 0) $lineToCheck = $this->board[$king]->upLine;
  if(count($this->board[$king]->upLine) > 0) if(in_array($this->board[$king]->upLine, [$targetedBy]))
    if(count($this->board[$king]->downLine) > 0) $lineToCheck = $this->board[$king]->downLine;
  
  if(count($this->board[$king]->upRightLine) > 0) if(in_array($this->board[$king]->upRightLine, [$targetedBy]))
    if(count($this->board[$king]->downLeftLine) > 0) $lineToCheck = $this->board[$king]->downLeftLine;
  if(count($this->board[$king]->upLeftLine) > 0) if(in_array($this->board[$king]->upLeftLine, [$targetedBy]))
    if(count($this->board[$king]->downRightLine) > 0) $lineToCheck = $this->board[$king]->downRightLine;
  
  if(count($this->board[$king]->downRightLine) > 0) if(in_array($this->board[$king]->downRightLine, [$targetedBy]))
    if(count($this->board[$king]->upLeftLine) > 0) $lineToCheck = $this->board[$king]->upLeftLine;
  if(count($this->board[$king]->downLeftLine) > 0) if(in_array($this->board[$king]->downLeftLine, [$targetedBy]))
    if(count($this->board[$king]->upRightLine) > 0) $lineToCheck = $this->board[$king]->upRightLine;
  
  if(count($lineToCheck) === 0) return;
  return $lineToCheck;
}

function GetSaveTurn($move, $state)
{
  $newSave = new SaveTurn();
  $newSave->turn = $this->turn;
  $newSave->move = $move;
  $newSave->state = $state;
  $newSave->board = [];
  
  for($i = 0; $i < count($this->board); $i++)
  {
    $newSquare = new SaveSquare();
    $newSquare->firstMove = $this->board[$i]->firstMove;
    $newSquare->enPassant = $this->board[$i]->enPassant;
    $newSquare->piece = $this->board[$i]->piece;
    array_push($newSave->board, $newSquare);
  }
  
  return $newSave;
}

  private function GetLine(int $index, string $direction, array $board) : array
  {
    if($index == -1) return -1;
    
    $result = [];
    $nextIndex = $index;
    $counter = 0;
    
    while($nextIndex != -1)
    {
      $counter++;
      
      if($counter > 10) break;
      
      if($nextIndex == -1) break;
      
      if($direction == "up") $nextIndex = $board[$nextIndex]->up;
      if($direction == "down") $nextIndex = $board[$nextIndex]->down;
      
      if($direction == "left") $nextIndex = $board[$nextIndex]->left;
      if($direction == "right") $nextIndex = $board[$nextIndex]->right;
      
      if($direction == "upRight") $nextIndex = $board[$nextIndex]->upRight;
      if($direction == "upLeft") $nextIndex = $board[$nextIndex]->upLeft;
      
      if($direction == "downRight") $nextIndex = $board[$nextIndex]->downRight;
      if($direction == "downLeft") $nextIndex = $board[$nextIndex]->downLeft;

      if($nextIndex != -1) array_push($result, $nextIndex);
    }

    if(count($result) > 0) return $result; else return [-1];
  }

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
    if($board[$index]->piece == "WK") $white = true; else $white = false;
    
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
      else array_push($board[$kUpLeft]->targetedByWhite, $index);
      if($board[$kUpLeft]->piece == "-") array_push($result,$kUpLeft);
      else if($board[$kUpLeft]->piece[0] == "W") { if(!$white) array_push($result,$kUpLeft); }
      else if($board[$kUpLeft]->piece[0] == "B") { if($white) array_push($result,$kUpLeft); }; };
    if($kUpRight != -1) {
      if($white) array_push($board[$kUpRight]->targetedByWhite, $index);
      else array_push($board[$kUpLeft]->targetedByBlack, $index);
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

  function FindMovesKing($index, $board) : array
  {
    $square = $board[$index];
    
    $white = true;
    if($board[$index]->piece == "WX") $white = true; else $white = false;
    
    $up = $square->up;
    if($up != -1 && $white && count($board[$up]->targetedByBlack) > 0) $up = -1;
    if($up != -1 && !$white && count($board[$up]->targetedByWhite) > 0) $up = -1;
    $down = $square->down;
    if($down != -1 && $white && count($board[$down]->targetedByBlack) > 0) $down = -1;
    if($down != -1 && !$white && count($board[$down]->targetedByWhite) > 0) $down = -1;
    
    $left = $square->left;
    if($left != -1 && $white && count($board[$left]->targetedByBlack) > 0) $left = -1;
    if($left != -1 && !$white && count($board[$left]->targetedByWhite) > 0) $left = -1;
    $right = $square->right;
    if($right != -1 && $white && count($board[$right]->targetedByBlack) > 0) $right = -1;
    if($right != -1 && !$white && count($board[$right]->targetedByWhite) > 0) $right = -1;
    
    $upRight = $square->upRight;
    if($upRight != -1 && $white && count($board[$upRight]->targetedByBlack) > 0) $upRight = -1;
    if($upRight != -1 && !$white && count($board[$upRight]->targetedByWhite) > 0) $upRight = -1;
    $upLeft = $square->upLeft;
    if($upLeft != -1 && $white && count($board[$upLeft]->targetedByBlack) > 0) $upLeft = -1;
    if($upLeft != -1 && !$white && count($board[$upLeft]->targetedByWhite) > 0) $upLeft = -1;
    
    $downRight = $square->downRight;
    if($downRight != -1 && $white && count($board[$downRight]->targetedByBlack) > 0) $downRight = -1;
    if($downRight != -1 && !$white && count($board[$downRight]->targetedByWhite) > 0) $downRight = -1;
    $downLeft = $square->downLeft;
    if($downLeft != -1 && $white && count($board[$downLeft]->targetedByBlack) > 0) $downLeft = -1;
    if($downLeft != -1 && !$white && count($board[$downLeft]->targetedByWhite) > 0) $downLeft = -1;
    
    $result = [];
    
    if($up != -1) {
      if($white) array_push($board[$up]->targetedByWhite, $index);
      else array_push($board[$up]->targetedByBlack, $index);
      if($board[$up]->piece == "-") array_push($result,$up);
      else if($board[$up]->piece[0] == "W") { if(!$white) array_push($result,$up); }
      else if($board[$up]->piece[0] == "B") { if($white) array_push($result,$up); }; };
    if($down != -1) {
      if($white) array_push($board[$down]->targetedByWhite, $index);
      else array_push($board[$down]->targetedByBlack, $index);
      if($board[$down]->piece == "-") array_push($result,$down);
      else if($board[$down]->piece[0] == "W") { if(!$white) array_push($result,$down); }
      else if($board[$down]->piece[0] == "B") { if($white) array_push($result,$down); }; };
    
    if($left != -1) {
      if($white) array_push($board[$left]->targetedByWhite, $index);
      else array_push($board[$left]->targetedByBlack, $index);
      if($board[$left]->piece == "-") array_push($result,$left);
      else if($board[$left]->piece[0] == "W") { if(!$white) array_push($result,$left); }
      else if($board[$left]->piece[0] == "B") { if($white) array_push($result,$left); }; };
    if($right != -1) {
      if($white) array_push($board[$right]->targetedByWhite, $index);
      else array_push($board[$right]->targetedByBlack, $index);
      if($board[$right]->piece == "-") array_push($result,$right);
      else if($board[$right]->piece[0] == "W") { if(!$white) array_push($result,$right); }
      else if($board[$right]->piece[0] == "B") { if($white) array_push($result,$right); }; };
    
    if($upRight != -1) {
      if($white) array_push($board[$upRight]->targetedByWhite, $index);
      else array_push($board[$upRight]->targetedByBlack, $index);
      if($board[$upRight]->piece == "-") array_push($result,$upRight);
      else if($board[$upRight]->piece[0] == "W") { if(!$white) array_push($result,$upRight); }
      else if($board[$upRight]->piece[0] == "B") { if($white) array_push($result,$upRight); }; };
    if($upLeft != -1) {
      if($white) array_push($board[$upLeft]->targetedByWhite, $index);
      else array_push($board[$upLeft]->targetedByBlack, $index);
      if($board[$upLeft]->piece == "-") array_push($result,$upLeft);
      else if($board[$upLeft]->piece[0] == "W") { if(!$white) array_push($result,$upLeft); }
      else if($board[$upLeft]->piece[0] == "B") { if($white) array_push($result,$upLeft); }; };
    
    if($downRight != -1) {
      if($white) array_push($board[$downRight]->targetedByWhite, $index);
      else array_push($board[$downRight]->targetedByBlack, $index);
      if($board[$downRight]->piece == "-") array_push($result,$downRight);
      else if($board[$downRight]->piece[0] == "W") { if(!$white) array_push($result,$downRight); }
      else if($board[$downRight]->piece[0] == "B") { if($white) array_push($result,$downRight); }; };
    if($downLeft != -1) {
      if($white) array_push($board[$downLeft]->targetedByWhite, $index);
      else array_push($board[$downLeft]->targetedByBlack, $index);
      if($board[$downLeft]->piece == "-") array_push($result,$downLeft);
      else if($board[$downLeft]->piece[0] == "W") { if(!$white) array_push($result,$downLeft); }
      else if($board[$downLeft]->piece[0] == "B") { if($white) array_push($result,$downLeft); }; };
      
    // $white - establish castle rights if king on start $square and hasn't moved
    if($white && $index == 4 && $board[$index]->firstMove && count($board[$index]->targetedByBlack) == 0)
    {
      $sLen = count($square->leftLine);
      for($i = 0; $i < $sLen; $i++)
      {
        // if all squares but the last one are either not empty or under threat then cancel
        if($i < ($sLen - 1) && ($board[$square->leftLine[$i]]->piece != "-"
        || count($board[$square->leftLine[$i]]->targetedByBlack) > 0)) break;
        // if last $square isn't a rook with no threat then cancel
        if($i == $sLen && ($board[$square->leftLine[$i]]->piece != "WR") && $board[$i]->firstMove) break;
        // if passed those tests then add to move list
        array_push($result,2);
      }
      $sLen = count($square->rightLine);
      for($i = 0; $i < $sLen; $i++)
      {
        // if all squares but the last one are either not empty or under threat then cancel
        if($i < ($sLen - 1) && ($board[$square->rightLine[$i]]->piece != "-"
        || count($board[$square->rightLine[$i]]->targetedByBlack) > 0)) break;
        // if last $square isn't a rook with no threat then cancel
        if($i == $sLen && ($board[$square->rightLine[$i]]->piece != "WR") && $board[$i]->firstMove) break;
        // if passed those tests then add to move list
        array_push($result,6);
      }
    }
    // BLACK
    if(!$white && $index == 60 && $board[$index]->firstMove && count($board[$index]->targetedByWhite) == 0)
    {
      $sLen = count($square->leftLine);
      for($i = 0; $i < $sLen; $i++)
      {
        // if all squares but the last one are either not empty or under threat then cancel
        if($i < ($sLen - 1) && ($board[$square->leftLine[$i]]->piece != "-"
        || count($board[$square->leftLine[$i]]->targetedByWhite) > 0)) break;
        // if last $square isn't a rook with no threat then cancel
        if($i == $sLen && ($board[$square->leftLine[$i]]->piece != "BR") && $board[$i]->firstMove) break;
        // if passed those tests then add to move list
        array_push($result,58);
      }
      $sLen = count($square->rightLine);
      for($i = 0; $i < $sLen; $i++)
      {
        // if all squares but the last one are either not empty or under threat then cancel
        if($i < ($sLen - 1) && ($board[$square->rightLine[$i]]->piece != "-"
        || count($board[$square->rightLine[$i]]->targetedByWhite) > 0)) break;
        // if last $square isn't a rook with no threat then cancel
        if($i == $sLen && ($board[$square->rightLine[$i]]->piece != "BR") && $board[$i]->firstMove) break;
        // if passed those tests then add to move list
        array_push($result,62);
      }
    }
    
    return $result;
  }

  function AddFromLine($array, $board, $white, $index) : array
  {
    $len = count($array);

    if($len === 0) return [];
    if($len === 1 && $array[0] === -1) return [];
    
    $result = [];
    // $xRay is turned on after reach the first piece, turned off after (including) the second piece
    // if piece is white, mark each $square up to the first black piece as a result and targeted by white
    // if the first piece is white mark don't add that to result
    // if first piece was opposite colour, run $xRay following on until it hits a piece and mark all squares as $xRay
    // don't run $xRay if first piece hit was same colour
    $xRay = false;
    
    for($i = 0; $i < $len; $i++)
    {
      $square = $array[$i];
      if($board[$square] !== null)
      {
        // for white pieces
        if($board[$index]->piece[0] == "W")
        {
          // if $xRay is on
          if($xRay)
          {
            // mark all empty squares as xrayed
            if($board[$square]->piece == "-")
            {
              array_push($board[$square]->xRayWhite, $index);
            }
            // mark the first piece and end
            if($board[$square]->piece[0] != "-")
            {
              array_push($board[$square]->xRayWhite, $index);
              break;
            }
          }
          else
          {
            // if $xRay is off
            // mark all empty squares in result and targeted by white
            if($board[$square]->piece == "-")
            {
              array_push($board[$square]->targetedByWhite, $index);
              array_push($result, $square);
            }
            // if hit a black piece first
            if($board[$square]->piece[0] == "B")
            {
              // actiate $xRay
              array_push($board[$square]->targetedByWhite, $index);
              array_push($result, $square);
              $xRay = true;
            }
            // if hit a white piece first
            if($board[$square]->piece[0] == "W")
            {
              // dont activate $xRay, just target and end
              array_push($board[$square]->targetedByWhite, $index);
              $xRay = true;
              break;
            }
          }
        }
        // for black pieces
        if($board[$index]->piece[0] == "B")
        {
          // if $xRay is on
          if($xRay)
          {
            // mark all empty squares as xrayed
            if($board[$square]->piece == "-")
            {
              array_push($board[$square]->xRayBlack, $index);
            }
            // mark the first piece and end
            if($board[$square]->piece[0] != "-")
            {
              array_push($board[$square]->xRayBlack, $index);
              break;
            }
          }
          else
          {
            // if $xRay is off
            // mark all empty squares in result and targeted by white
            if($board[$square]->piece == "-")
            {
              array_push($board[$square]->targetedByBlack, $index);
              array_push($result, $square);
            }
            // if hit a same colour piece first
            if($board[$square]->piece[0] == "W")
            {
              // actiate $xRay
              array_push($board[$square]->targetedByBlack, $index);
              array_push($result, $square);
              $xRay = true;
            }
            // if hit an opposite colour piece first
            if($board[$square]->piece[0] == "B")
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

  private function ScoreBoard()
  {
    $score = 0;
    for($i = 0; $i < count($this->board); $i++)
    {
      if($this->board[$i]->piece == "-") continue;
      
      if($this->board[$i]->piece == "WP") $score += 100;
      if($this->board[$i]->piece == "WR") $score += 500;
      if($this->board[$i]->piece == "WB") $score += 300;
      if($this->board[$i]->piece == "WK") $score += 300;
      if($this->board[$i]->piece == "WQ") $score += 900;
      if($this->board[$i]->piece == "WX") $score += 1000000;
      
      if($this->board[$i]->piece == "BP") $score -= 100;
      if($this->board[$i]->piece == "BR") $score -= 500;
      if($this->board[$i]->piece == "BB") $score -= 300;
      if($this->board[$i]->piece == "BK") $score -= 300;
      if($this->board[$i]->piece == "BQ") $score -= 900;
      if($this->board[$i]->piece == "BX") $score -= 1000000;
    }
    return $score;
  }

  private function MergeArrays(array $input): array
  {
    if(count($input) === 0) return [];

    $output = [];

    foreach($input as $item)
    {
      if(gettype($item) === "array")
      {
        if(count($item) > 0)
        {
          foreach($item as $subItem)
          {
            array_push($output, $subItem);
          }
        }
      }
    }

    return $output;
  }

}