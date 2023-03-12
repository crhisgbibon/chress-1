<?php

declare(strict_types=1);

/** Model Class
 * 
 * 
 * 
*/

class PGNModel
{

  public function __construct()
  {

  }

  public function PGNToGame(string $data) : GameModel
  {
    $rawPGN = $data;
      
    $eventPos = strpos($rawPGN, "Event");
    $sitePos = strpos($rawPGN, "Site");
    $datePos = strpos($rawPGN, "Date");
    $roundPos = strpos($rawPGN, "Round");
    $whitePos = strpos($rawPGN, "White");
    $blackPos = strpos($rawPGN, "Black");
    $resultPos = strpos($rawPGN, "Result");
    $gamePos = strrpos($rawPGN, "]");
    
    $eventString = substr($rawPGN, $eventPos, $sitePos);
    $eventOne = strpos($eventString, '"');
    $eventString = substr($eventString, $eventOne + 1);
    $eventTwo = strpos($eventString, '"');
    $eventString = substr($eventString, 0, $eventTwo);
    
    $siteString = substr($rawPGN, $sitePos, $datePos);
    $siteOne = strpos($siteString, '"');
    $siteString = substr($siteString, $siteOne + 1);
    $siteTwo = strpos($siteString, '"');
    $siteString = substr($siteString, 0, $siteTwo);
    
    $dateString = substr($rawPGN, $datePos, $roundPos);
    $dateOne = strpos($dateString, '"');
    $dateString = substr($dateString, $dateOne + 1);
    $dateTwo = strpos($dateString, '"');
    $dateString = substr($dateString, 0, $dateTwo);
    
    $roundString = substr($rawPGN, $roundPos, $whitePos);
    $roundOne = strpos($roundString, '"');
    $roundString = substr($roundString, $roundOne + 1);
    $roundTwo = strpos($roundString, '"');
    $roundString = substr($roundString, 0, $roundTwo);
    
    $whiteString = substr($rawPGN, $whitePos, $blackPos);
    $dateOne = strpos($whiteString, '"');
    $whiteString = substr($whiteString, $dateOne + 1);
    $dateTwo = strpos($whiteString, '"');
    $whiteString = substr($whiteString, 0, $dateTwo);
    
    $blackString = substr($rawPGN, $blackPos, $resultPos);
    $dateOne = strpos($blackString, '"');
    $blackString = substr($blackString, $dateOne + 1);
    $dateTwo = strpos($blackString, '"');
    $blackString = substr($blackString, 0, $dateTwo);
    
    $resultString = substr($rawPGN, $resultPos, $gamePos);
    $dateOne = strpos($resultString, '"');
    $resultString = substr($resultString, $dateOne + 1);
    $dateTwo = strpos($resultString, '"');
    $resultString = substr($resultString, 0, $dateTwo);
    
    $gameString = substr($rawPGN, $gamePos + 1);
    
    $turnList = explode(".", $gameString);

    $newTurnList = [];
    $tLength = count($turnList);
    
    for($t = 1; $t < $tLength; $t++)
    {
      $moveList = explode( " ", $turnList[$t]);
      $newMoveList = [];
      $mCount = count($moveList);
      for($m = 0; $m < $mCount; $m++)
      {
        if($moveList[$m] != "")
        {
          array_push($newMoveList, $moveList[$m]);
          if(count($newMoveList) >= 2) break;
        }
      }
      $turnList[$t] = $newMoveList;
      array_push($newTurnList, $turnList[$t]);
    }
    
    $info = [$newTurnList,
    $eventString,
    $siteString,
    $dateString,
    $roundString,
    $whiteString,
    $blackString,
    $resultString];

    $moveList = $this->ConvertToStandardForm($info);

    $game = $this->StandardFormToGame($moveList, $info);

    $d = new Debug();
    $d->Debug("newTurnList", "array", $newTurnList);

    return $game;
  }

  private function ConvertToStandardForm(array $data) : array
  {
    $moveList = $data[0];

    $mLen = count($moveList);

    for($m = 0; $m < $mLen; $m++)
    {
      $whiteData = $moveList[$m][0];
      $blackData = $moveList[$m][1];
      
      $whitePiece = "";
      $whiteMove = "";
      
      if($whiteData !== "1-0" && $whiteData !== "0-1" && $whiteData !== "*" && $whiteData !== "1/2-1/2")
      {
        if($whiteData === "O-O" || $whiteData === "O-O-O")
        {
          $whiteMove = $whiteData;
          $whitePiece = "X";
        }
        else
        {
          $whitePiece = substr($moveList[$m][0], 0, (strlen($moveList[$m][0]) - 2));
          $whiteMove = substr($moveList[$m][0], (strlen($moveList[$m][0]) - 2));
          if(strpos($whitePiece, "R") === false &&
          strpos($whitePiece, "N") === false &&
          strpos($whitePiece, "B") === false &&
          strpos($whitePiece, "Q") === false &&
          strpos($whitePiece, "K") === false)
          {
            $whitePiece = "P" . $whitePiece;
          }
          if($whitePiece === "") $whitePiece = "P";
        }
      }

      $blackPiece = "";
      $blackMove = "";

      if($blackData != "1-0" && $blackData != "0-1" && $blackData != "*" && $blackData != "1/2-1/2")
      {
        if($blackData == "O-O" || $blackData == "O-O-O")
        {
          $blackMove = $blackData;
          $blackPiece = "X";
        }
        else
        {
          $blackPiece = substr($moveList[$m][1], 0, (strlen($moveList[$m][1]) - 2));
          $blackMove = substr($moveList[$m][1], (strlen($moveList[$m][1]) - 2));
          if(strpos($blackPiece, "R") === false &&
          strpos($blackPiece, "N") === false &&
          strpos($blackPiece, "B") === false &&
          strpos($blackPiece, "Q") === false &&
          strpos($blackPiece, "K") === false)
          {
            $blackPiece = "P" . $blackPiece;
          }
          if($blackPiece == "") $blackPiece = "P";
        }
      }

      $whitePiece = str_replace("x", "", $whitePiece);
      $blackPiece = str_replace("x", "", $blackPiece);

      $moveList[$m] = [ [$whitePiece, $whiteMove] , [$blackPiece, $blackMove] ];
    }

    $d = new Debug();
    $d->Debug("moveList", "array", $moveList);

    return $moveList;
  }

  private function StandardFormToGame(array $moveList, array $info) : GameModel
  {
    $debug = array();

    $game = new GameModel(
      -1,
      true,
      false,
      false,
      0,
      -1,
      -1,
      0,
      false
    );

    $game->moveList = $moveList;

    $game->eventT = (string)$info[1];
    $game->siteT = (string)$info[2];
    $game->dateT = (string)$info[3];

    $game->roundT = (string)$info[4];
    $game->whiteT = (string)$info[5];
    $game->blackT = (string)$info[6];

    $game->resultT = (string)$info[7];

    $game->NewBoard();

    $mLen = count($moveList);

    for($m = 0; $m < $mLen; $m++)
    {
      // for each move in the turn (2, white then black, unless black didn't go)
      $nLen = count($moveList[$m]);
      for($n = 0; $n < $nLen; $n++)
      {
        // ignore win conditions
        if($moveList[$m][$n] === "1-0" ||
        $moveList[$m][$n] === "0-1" ||
        $moveList[$m][$n] === "1/2-1/2" ||
        $moveList[$m][$n] === "*")
        {
          continue;
        }
        
        // the information to identify the piece - piece type and board position
        $pieceToMove = $moveList[$m][$n][0];
        // where the piece is moving to converted into 0-63 index number
        $moveTo = $this->ToIndex($moveList[$m][$n][0], $moveList[$m][$n][1]);
        
        // shortcut promotion
        if(strlen($moveList[$m][$n][1]) > 0 && $moveList[$m][$n][1][0] === "=")
        {
          $promoteToPiece = $moveList[$m][$n][1][1];
          if($promoteToPiece === "N") $promoteToPiece = "K";
          if(count($moveList[$m][$n][0]) === 2)
          {
            $indexPromote = $this->ToIndex("P", $moveList[$m][$n][0]);
            $possiblePieces1 = [];

            $pLen = count($game->board);
            for($p = 0; $p < $pLen; $p++)
            {
              if($game->board[$p]->piece[1] !== "P") continue;
              // avoid black pieces if white move
              if($n === 0) if($game->board[$p]->piece[0] === "B") continue;
              // avoid white pieces if black move
              if($n === 1) if($game->board[$p]->piece[0] === "W") continue;
              
              if(in_array($indexPromote, $game->board[$p]->moves))
              {
                array_push($possiblePieces1, $p);
              }
            }
            
            if(count($possiblePieces1) > 0)
            {
              $game->UpdateBoard($possiblePieces1[0], $indexPromote, $game->board, $promoteToPiece);

              // save the move
              $newMove = [[$possiblePieces1[0], $game->board[$possiblePieces1[0]]->piece], [$indexPromote, $game->board[$indexPromote]->piece]];
              $sArray = $game->GetSaveTurn($newMove, $game->state);
              array_push($game->saveList, $sArray);
    
              $game->turn = !$game->turn;
              $game->state = "";
              $game->EvaluateBoard(-1);
              continue;
            }
          }
          if($moveList[$m][$n][0]->length === 4)
          {
            $promoteTo = $moveList[$m][$n][0][2] + $moveList[$m][$n][0][3];
            $indexPromote = $this->ToIndex("P", $promoteTo);
            $possiblePieces1 = [];

            $bLen = count($game->board);

            for($p = 0; $p < $bLen; $p++)
            {
              if($game->board[$p]->piece[1] !== "P") continue;
              // avoid black pieces if white move
              if($n === 0) if($game->board[$p]->piece[0] === "B") continue;
              // avoid white pieces if black move
              if($n === 1) if($game->board[$p]->piece[0] === "W") continue;
              
              if(in_array($indexPromote, $game->board[$p]->moves))
              {
                array_push($possiblePieces1, $p);
              }
            }
            
            if(count($possiblePieces1) > 0)
            {
              $game->UpdateBoard($possiblePieces1[0], $indexPromote, $game->board, $promoteToPiece);

              // save the move
              $newMove = [[$possiblePieces1[0], $game->board[$possiblePieces1[0]]->piece], [$indexPromote, $game->board[$indexPromote]->piece]];
              $sArray = $game->GetSaveTurn($newMove, $game->state);
              array_push($game->saveList, $sArray);
    
              $game->turn = !$game->turn;
              $game->state = "";
              $game->EvaluateBoard(-1);
              continue;
            }
          }
        }
        
        // shortcut castling as hardcoded
        // white
        if($n === 0)
        {
          // kingside
          if($moveTo === "O-O")
          {
            $game->UpdateBoard(4, 6, $game->board, "");

            // save the move
            $newMove = [[4, $game->board[4]->piece], [6, $game->board[6]->piece]];
            $sArray = $game->GetSaveTurn($newMove, $game->state);
            array_push($game->saveList, $sArray);
  
            $game->turn = !$game->turn;
            $game->state = "";
            $game->EvaluateBoard(-1);
            continue;
          }
          // queenside
          if($moveTo === "O-O-O")
          {
            $game->UpdateBoard(4, 2, $game->board, "");

            // save the move
            $newMove = [[4, $game->board[4]->piece], [2, $game->board[2]->piece]];
            $sArray = $game->GetSaveTurn($newMove, $game->state);
            array_push($game->saveList, $sArray);
  
            $game->turn = !$game->turn;
            $game->state = "";
            $game->EvaluateBoard(-1);
            continue;
          }
        }
        // black
        if($n === 1)
        {
          // kingside
          if($moveTo === "O-O")
          {
            $game->UpdateBoard(60, 62, $game->board, "");

            // save the move
            $newMove = [[60, $game->board[60]->piece], [62, $game->board[62]->piece]];
            $sArray = $game->GetSaveTurn($newMove, $game->state);
            array_push($game->saveList, $sArray);
  
            $game->turn = !$game->turn;
            $game->state = "";
            $game->EvaluateBoard(-1);
            continue;
          }
          // queenside
          if($moveTo === "O-O-O")
          {
            $game->UpdateBoard(60, 58, $game->board, "");

            // save the move
            $newMove = [[60, $game->board[60]->piece], [58, $game->board[58]->piece]];
            $sArray = $game->GetSaveTurn($newMove, $game->state);
            array_push($game->saveList, $sArray);
  
            $game->turn = !$game->turn;
            $game->state = "";
            $game->EvaluateBoard(-1);
            continue;
          }
        }
        
        
        // used to identify the piece to move
        $possiblePieces = [];

        $pLen = count($game->board);

        for($p = 0; $p < $pLen; $p++)
        {
          if($game->board[$p]->piece === "-") continue;
          // avoid black pieces if white move
          if($n === 0) if($game->board[$p]->piece[0] === "B") continue;
          // avoid white pieces if black move
          if($n === 1) if($game->board[$p]->piece[0] === "W") continue;
          
          /*
          identify the nature of the piece being moved, i.e. piece type and if needed the row/col to match
          possible variations
          - if alphabet length only 1 then only 1 piece that can move
          P = pawn
          R = rook
          N = knight
          B = bishop
          Q = queen
          X = king
          
          - if 2 length then can either be a pawn capture, if first letter lower case
          - or a piece capture if first capital and second x - can ignore the x
          - or can be conflict resolution if second not x
          
          - if second is not x then need to check if a third for both row and col specification
          e->g ax = a column pawn capture - ignore the x just move the pawn
          Bx = bishop is capturing, can also ignore the x
          Ba = Bishop on a column a to move (assuming another bishop will also have moves to target square
          Bac = Bishop on column a and row c (assuming multiple bishops on column a)        
          */
          
          // if 1 piece length info then normal piece move
          if(strlen($pieceToMove) === 1)
          {
            if($pieceToMove[0] === "P" && $game->board[$p]->piece[1] !== "P") continue;
            if($pieceToMove[0] === "R" && $game->board[$p]->piece[1] !== "R") continue;
            if($pieceToMove[0] === "N" && $game->board[$p]->piece[1] !== "K") continue;
            if($pieceToMove[0] === "B" && $game->board[$p]->piece[1] !== "B") continue;
            if($pieceToMove[0] === "Q" && $game->board[$p]->piece[1] !== "Q") continue;
            if($pieceToMove[0] === "K" && $game->board[$p]->piece[1] !== "X") continue;

            if(in_array($moveTo, $game->board[$p]->moves))
            {
              array_push($possiblePieces, $p);
            }
          }
          else if(strlen($pieceToMove) > 1)
          {
            if($pieceToMove[0] === "P" && $game->board[$p]->piece[1] !== "P") continue;
            if($pieceToMove[0] === "R" && $game->board[$p]->piece[1] !== "R") continue;
            if($pieceToMove[0] === "N" && $game->board[$p]->piece[1] !== "K") continue;
            if($pieceToMove[0] === "B" && $game->board[$p]->piece[1] !== "B") continue;
            if($pieceToMove[0] === "Q" && $game->board[$p]->piece[1] !== "Q") continue;
            if($pieceToMove[0] === "K" && $game->board[$p]->piece[1] !== "X") continue;
            
            // find rows or columns present to identify square

            $colIndex = -1;
            $rowIndex = -1;

            $colInfo = -1;
            $rowInfo = -1;

            // columns
            $letters = ["a", "b", "c", "d", "e", "f", "g", "h"];
            $lCount = count($letters);

            for($i = 0; $i < $lCount; $i++)
            {
              $colIndex = strpos($pieceToMove, $letters[$i]);
              if(is_numeric($colIndex))
              {
                $colInfo = $this->GetColumn($pieceToMove[$colIndex]);
                break;
              }
              $debugLine = ["col", $pieceToMove, $colIndex, $letters[$colIndex], $colInfo];
              array_push($debug, $debugLine);
            }

            // rows
            $numbers = ["1", "2", "3", "4", "5", "6", "7", "8"];
            $nCount = count($numbers);

            for($i = 0; $i < $nCount; $i++)
            {
              $rowIndex = strpos($pieceToMove, $numbers[$i]);
              if(is_numeric($rowIndex))
              {
                $rowInfo = $this->GetRow($pieceToMove[$rowIndex]);
                break;
              }
              $debugLine = ["row", $pieceToMove, $rowIndex, $numbers[$rowIndex], $rowInfo];
              array_push($debug, $debugLine);
            }

            if($rowInfo === -1 && $colInfo === -1)
            {
              continue;
            }
            else if($rowInfo !== -1 && $colInfo === -1)
            {
              $debugLine = [$pieceToMove, $colInfo, $rowInfo];
              array_push($debug, $debugLine);

              if($game->board[$p]->row === $rowInfo && 
              in_array($moveTo, $game->board[$p]->moves))
              {
                array_push($possiblePieces, $p);
              }
            }
            else if($rowInfo === -1 && $colInfo !== -1)
            {
              $debugLine = [$pieceToMove, $colInfo, $rowInfo];
              array_push($debug, $debugLine);

              if($game->board[$p]->col === $colInfo &&
              in_array($moveTo, $game->board[$p]->moves))
              {
                array_push($possiblePieces, $p);
              }
            }
            else if($rowInfo !== -1 && $colInfo !== -1)
            {
              $debugLine = [$pieceToMove, $colInfo, $rowInfo];
              array_push($debug, $debugLine);

              if($game->board[$p]->row === $rowInfo && 
              $game->board[$p]->col === $colInfo && 
              in_array($moveTo, $game->board[$p]->moves))
              {
                array_push($possiblePieces, $p);
              }
            }
          }
        }

        $pLength = count($possiblePieces);
        if($pLength > 0)
        {
          $game->UpdateBoard($possiblePieces[0], $moveTo, $game->board, "");

          $game->turn = !$game->turn;
          $game->state = "";
          $game->EvaluateBoard(-1);

          // save the move
          $newMove = [[$possiblePieces[0], $game->board[$possiblePieces[0]]->piece], [$moveTo, $game->board[$moveTo]->piece]];
          $sArray = $game->GetSaveTurn($newMove, $game->state);
          array_push($game->saveList, $sArray);
        }
      }
    }

    $d = new Debug();
    $d->Debug("rowCol", "array", $debug);

    $game->LoadState("START", -1);

    return $game;
  }

  private function ToIndex($piece, $index)
  {
    if($index === "-1" || $index == null || $index == "") return;
    if($piece === "X" && $index == "O-O") return "O-O";
    if($piece === "X" && $index == "O-O-O") return "O-O-O";
    $row = 0;
    $col = 0;
    
    switch($index[0])
    {
      case "a":
        $col = 0;
        break;
      case "b":
        $col = 1;
        break;
      case "c":
        $col = 2;
        break;
      case "d":
        $col = 3;
        break;
      case "e":
        $col = 4;
        break;
      case "f":
        $col = 5;
        break;
      case "g":
        $col = 6;
        break;
      case "h":
        $col = 7;
        break;
      default: $col = 0;
    }
    switch($index[1])
    {
      case "1":
        $row = 0;
        break;
      case "2":
        $row = 1;
        break;
      case "3":
        $row = 2;
        break;
      case "4":
        $row = 3;
        break;
      case "5":
        $row = 4;
        break;
      case "6":
        $row = 5;
        break;
      case "7":
        $row = 6;
        break;
      case "8":
        $row = 7;
        break;
      default: $row = 0;
    }
    $result = ($row * 8) + $col;
    return $result;
  }

  private function GetPieceArray($board)
  {
    $result = [];
    $len = count($board);
    for($i = 0; $i < $len; $i++)
    {
      array_push($result, $board[$i]->piece);
    }
    return $result;
  }

  private function GetColumn($input)
  {
    $col = 0;
    
    switch($input)
    {
      case "a":
        $col = 0;
        break;
      case "b":
        $col = 1;
        break;
      case "c":
        $col = 2;
        break;
      case "d":
        $col = 3;
        break;
      case "e":
        $col = 4;
        break;
      case "f":
        $col = 5;
        break;
      case "g":
        $col = 6;
        break;
      case "h":
        $col = 7;
        break;
      default: $col = 0;
    }
    return $col;
  }

  private function GetRow($input)
  {
    $col = 0;
    
    switch($input)
    {
      case "1":
        $col = 0;
        break;
      case "2":
        $col = 1;
        break;
      case "3":
        $col = 2;
        break;
      case "4":
        $col = 3;
        break;
      case "5":
        $col = 4;
        break;
      case "6":
        $col = 5;
        break;
      case "7":
        $col = 6;
        break;
      case "8":
        $col = 7;
        break;
      default: $col = 0;
    }
    return $col;
  }
}