"use strict";

let debugB = false;

const pawnValueBlack = [
    +90, +90, +90, +90, +90, +90, +90, +90,
    +50, +50, +50, +50, +50, +50, +50, +50,
    +10, +10, +20, +30, +30, +20, +10, +10,
    +5, +5, +10, +25, +25, +10, +5, +5,
    +0, +0, +0, +40, +40, +0, +0, +0,
    -5, -5, -10, +0, +0, -10, -5, -5,
    +5, +10, +10, -20, -20, +10, +10, +5,
    +0, +0, +0, +0, +0, +0, +0, +0 ];

const pawnValueWhite = [
    +0, +0, +0, +0, +0, +0, +0, +0,
    +5, +10, +10, -20, -20, +10, +10, +5,
    -5, -5, -10, +0, +0, -10, -5, -5,
    +0, +0, +0, +40, +40, +0, +0, +0,
    +5, +5, +10, +25, +25, +10, +5, +5,
    +10, +10, +20, +30, +30, +20, +10, +10,
    +50, +50, +50, +50, +50, +50, +50, +50,
    +90, +90, +90, +90, +90, +90, +90, +90 ];

const rookValueBlack = [
    +0, +0, +0, +0, +0, +0, +0, +0,
    +5, +10, +10, +10, +10, +10, +10, +5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    +0, +0, +0, +5, +5, +0, +0, +0 ];

const rookValueWhite = [
    +0, +0, +0, +5, +5, +0, +0, +0,
    -5, +0, +0, +0, +0, +0, +0, -5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    -5, +0, +0, +0, +0, +0, +0, -5,
    +5, +10, +10, +10, +10, +10, +10, +5,
    +0, +0, +0, +0, +0, +0, +0, +0 ];

const knightValueBlack = [
    -50, -30, +0, +0, +0, +0, -30, -50,
    -40, -20, +0, +0, +0, +0, -20, -40,
    -30, +0, +10, +15, +15, +10, +0, -30,
    -30, +5, +15, +20, +20, +15, +5, -30,
    -30, +0, +15, +20, +20, +15, +0, -30,
    -30, +5, +10, +15, +15, +10, +5, -30,
    -40, -20, +0, +5, +5, +0, -20, -40,
    -50, -30, -30, -30, -30, -30, -30, -50 ];
    
const knightValueWhite = [
    -50, -30, -30, -30, -30, -30, -30, -50,
    -40, -20, +0, +5, +5, +0, -20, -40,
    -30, +5, +10, +15, +15, +10, +5, -30,
    -30, +0, +15, +20, +20, +15, +0, -30,
    -30, +5, +15, +20, +20, +15, +5, -30,
    -30, +0, +10, +15, +15, +10, +0, -30,
    -40, -20, +0, +0, +0, +0, -20, -40,
    -50, -30, +0, +0, +0, +0, -30, -50 ];
    
const bishopValueBlack = [
    -20, -10, -10, -10, -10, -10, -10, -20,
    -10, +0, +0, +0, +0, +0, +0, -10,
    -10, +0, +5, +10, +10, +5, +0, -10,
    -10, +5, +5, +10, +10, +5, +5, -10,
    -10, +0, +10, +10, +10, +10, +0, -10,
    -10, +10, +10, +10, +10, +10, +10, -10,
    -10, +5, +0, +0, +0, +0, +5, -10,
    -20, -10, -10, -10, -10, -10, -10, -20 ];
    
const bishopValueWhite = [
    -20, -10, -10, -10, -10, -10, -10, -20,
    -10, +5, +0, +0, +0, +0, +5, -10,
    -10, +10, +10, +10, +10, +10, +10, -10,
    -10, +0, +10, +10, +10, +10, +0, -10,
    -10, +5, +5, +10, +10, +5, +5, -10,
    -10, +0, +5, +10, +10, +5, +0, -10,
    -10, +0, +0, +0, +0, +0, +0, -10,
    -20, -10, -10, -10, -10, -10, -10, -20 ];

const queenValueBlack = [
    -20, -10, -10, -5, -5, -10, -10, -20,
    -10, +0, +0, +0, +0, +0, +0, -10,
    -10, +0, +5, +5, +5, +5, +0, -10,
    -5, +0, +5, +5, +5, +5, +0, -5,
    -5, +0, +5, +5, +5, +5, +0, -5,
    -10, +5, +5, +5, +5, +5, +0, -10,
    -10, +0, +5, +0, +0, +0, +0, -10,
    -20, -10, -10, -5, -5, -10, -10, -20 ];

const queenValueWhite = [
    -20, -10, -10, -5, -5, -10, -10, -20,
    -10, +0, +5, +0, +0, +0, +0, -10,
    -10, +5, +5, +5, +5, +5, +0, -10,
    -5, +0, +5, +5, +5, +5, +0, -5,
    -5, +0, +5, +5, +5, +5, +0, -5,
    -10, +0, +5, +5, +5, +5, +0, -10,
    -10, +0, +0, +0, +0, +0, +0, -10,
    -20, -10, -10, -5, -5, -10, -10, -20 ];

const kingValueBlack = [
    +0, +0, +0, +0, +0, +0, +0, +0,
    +50, +50, +50, +50, +50, +50, +50, +50,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0 ];

const kingValueWhite = [
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +0, +0, +0, +0, +0, +0, +0, +0,
    +50, +50, +50, +50, +50, +50, +50, +50,
    +0, +0, +0, +0, +0, +0, +0, +0 ];

class Square{
  constructor(index, col, row, up, down, left, right, upLeft, upRight, downLeft, downRight, kUpRight, kUpLeft, kLeftUp, kLeftDown, kDownRight, kDownLeft, kRightUp, kRightDown) {
    this.index = index;
    
    this.col = col;
    this.row = row;
    // true or false depending on square colour
    this.white
    
    this.up = up;
    this.down = down;
    
    this.left = left;
    this.right = right;
    
    this.upLeft = upLeft;
    this.upRight = upRight;
    
    this.downLeft = downLeft;
    this.downRight = downRight;
    
    this.kUpRight = kUpRight;
    this.kUpLeft = kUpLeft;
    
    this.kLeftUp = kLeftUp;
    this.kLeftDown = kLeftDown;
    
    this.kDownRight = kDownRight;
    this.kDownLeft = kDownLeft;
    
    this.kRightUp = kRightUp;
    this.kRightDown = kRightDown;
    
    this.leftLine = [];
    this.rightLine = [];
    
    this.upLine = [];
    this.downLine = [];
    
    this.upRightLine = [];
    this.upLeftLine = [];
    
    this.downRightLine = [];
    this.downLeftLine = [];
    
    this.firstMove = false;
    this.enPassant = 0;
    
    this.piece = "-";
    this.moves = [];
    
    // log all the squares the piece could move to or threatens to capture on
    // includes both enemy squares and squares of own pieces it is supporting
    this.targetedByWhite = [];
    this.targetedByBlack = [];
    
    // goes beyond targeted squares to log all empty squares and the first piece
    // used to stop own pieces moving and revealing check
    this.xRayWhite = [];
    this.xRayBlack = [];
  }
}

class Game{
  constructor(index, board, pieces, turn) {
    // index of the game in the game array
    this.index = index
    
    // info on the squares
    this.board = board;
    
    // true = white, false = black
    this.turn = turn;
    
    // save the last moved piece
    this.lastMoved = 0;
    
    // whether ai should play black or white
    this.blackAI = false;
    this.whiteAI = false;
    
    // save the board history for checking 3x repetition and navigating in game
    this.currentMove = 0;
    // list of saveTurns documenting the game to current move
    this.saveList = [];
    // counts the fifty move draw condition
    this.fifty = 0;
    // to return to the display, including checks, draw flag etc
    this.state = "";
    
    this.eventT = "";
    this.siteT = "";
    this.dateT = "";
    this.roundT = "";
    this.whiteT = "";
    this.blackT = "";
    this.resultT = "";
    this.gameT = "";
  }
}

// holds the info to reconstitute the turn when switching moves so can play on, and 3fold check
class SaveTurn{
  constructor(board, turn, move, state) {
    this.board = board;
    this.turn = turn;
    this.move = move;
    // stores whether check, checkmate or draw on the turn to display movelist/notation
    this.state = state;
  }
}

// square save information
class SaveSquare{
  constructor(firstMove, enPassant, piece) {
    this.firstMove = false;
    this.enPassant = 0;
    this.piece = "-";
  }
}

// array of games
let gArray = [];
let currentG = 0;

onmessage = function(event) {
  
  let query = JSON.parse(event.data);
  
  if(query[0] == "NEWGAME")
  {
    AddNewGame();
    return;
  }
  
  if(query[0] == "QUERYSQUARE")
  {
    GetMove(query);
    return;
  }
  
  if(query[0] == "MOVEPIECE")
  {
    MovePiece(query);
    return;
  }
  
  if(query[0] == "NEXTGAME" || query[0] == "LASTGAME")
  {
    let message = "";
    
    if(query[0] == "NEXTGAME")
    {
      currentG++;
      if(currentG >= gArray.length) currentG = 0;
      message = "NEXTGAME";
    }
    else if(query[0] == "LASTGAME")
    {
      currentG--;
      if(currentG < 0) currentG = gArray.length - 1;
      message = "LASTGAME";
    }
    console.log(currentG);
    let r = [];
    let pArray = GetPieceArray(gArray[currentG]);
    r.push(message);
    r.push(pArray);
    r.push(currentG);
    r.push(gArray.length);
    r.push(gArray[currentG].currentMove);
    r.push(gArray[currentG].saveList.length);
    let metaData = ["-1", gArray[currentG].eventT,
                    gArray[currentG].siteT,
                    gArray[currentG].dateT,
                    gArray[currentG].roundT,
                    gArray[currentG].whiteT,
                    gArray[currentG].blackT,
                    gArray[currentG].resultT];
    r.push(metaData);
    r.push(gArray[currentG].gameT);
    
    let rString = JSON.stringify(r);
    postMessage(rString);
    //console.log(gArray);
    return;
  }
  
  if(query[0] == "NEXTMOVE" || query[0] == "LASTMOVE")
  {
    if(gArray[currentG].saveList.length == 1) return;
    
    let message = "";
    
    if(query[0] == "NEXTMOVE")
    {
      gArray[currentG].currentMove++;
      if(gArray[currentG].currentMove >= gArray[currentG].saveList.length) gArray[currentG].currentMove = 0;
      message = "NEXTMOVE";
    }
    else if(query[0] == "LASTMOVE")
    {
      gArray[currentG].currentMove--;
      if(gArray[currentG].currentMove < 0) gArray[currentG].currentMove = gArray[currentG].saveList.length - 1;
      message = "LASTMOVE";
    }
    
    gArray[currentG].turn = gArray[currentG].saveList[gArray[currentG].currentMove].turn;
    gArray[currentG].state = gArray[currentG].saveList[gArray[currentG].currentMove].state;
    
    for(let i = 0; i < gArray[currentG].saveList[gArray[currentG].currentMove].board.length; i++)
    {
      gArray[currentG].board[i].piece = gArray[currentG].saveList[gArray[currentG].currentMove].board[i].piece;
      gArray[currentG].board[i].enPassant = gArray[currentG].saveList[gArray[currentG].currentMove].board[i].enPassant;
      gArray[currentG].board[i].firstMove = gArray[currentG].saveList[gArray[currentG].currentMove].board[i].firstMove;
    }
    
    EvaluateBoard(gArray[currentG]);

    let r = [];
    let newPieces = GetPieceArray(gArray[currentG]);
    r.push(message);
    r.push(newPieces);
    r.push(currentG);
    r.push(gArray.length);
    r.push(gArray[currentG].currentMove);
    r.push(gArray[currentG].saveList.length);
    r.push(gArray[currentG].state);
    
    let rString = JSON.stringify(r);
    postMessage(rString);
  
    return;
  }
  
  if(query[0] == "SKIPTOMOVE")
  {
    let message = "NEXTMOVE";
    console.log(query[1]);
    console.log(gArray[currentG].saveList.length);
    
    gArray[currentG].currentMove = query[1];
    
    gArray[currentG].turn = gArray[currentG].saveList[gArray[currentG].currentMove].turn;
    gArray[currentG].state = gArray[currentG].saveList[gArray[currentG].currentMove].state;
    
    for(let i = 0; i < gArray[currentG].saveList[gArray[currentG].currentMove].board.length; i++)
    {
      gArray[currentG].board[i].piece = gArray[currentG].saveList[gArray[currentG].currentMove].board[i].piece;
      gArray[currentG].board[i].enPassant = gArray[currentG].saveList[gArray[currentG].currentMove].board[i].enPassant;
      gArray[currentG].board[i].firstMove = gArray[currentG].saveList[gArray[currentG].currentMove].board[i].firstMove;
    }
    
    EvaluateBoard(gArray[currentG]);

    let r = [];
    let newPieces = GetPieceArray(gArray[currentG]);
    r.push(message);
    r.push(newPieces);
    r.push(currentG);
    r.push(gArray.length);
    r.push(gArray[currentG].currentMove);
    r.push(gArray[currentG].saveList.length);
    r.push(gArray[currentG].state);
    
    let rString = JSON.stringify(r);
    postMessage(rString);
  
    return;
  }
  
  if(query[0] == "AI")
  {
    gArray[currentG].blackAI = !gArray[currentG].blackAI;
    
    // if player turned on ai on blacks turn, return a move
    let aiResponse = null;
    if(!gArray[currentG].turn)
    {
      let aiMove = GetHalMove(gArray[currentG]);
      
      if(aiMove[0] != -1 && aiMove[1] != -1)
      {
        UpdateBoard(aiMove[0], aiMove[1], gArray[currentG].board, gArray[currentG]);
        gArray[currentG].turn = !gArray[currentG].turn;
        EvaluateBoard(gArray[currentG]);
      }
      // get the final piece array to export back to display
      let newPieces = GetPieceArray(gArray[currentG]);
      aiResponse = JSON.stringify(newPieces);
    }
    
    let r = [];
    let message = "AI";
    r.push(message, gArray[currentG].blackAI);
    if(aiResponse != null) r.push(aiResponse);
    let rString = JSON.stringify(r);
    postMessage(rString);
    return;
  }
  
  if(query[0] == "PGNTOMOVELOG")
  {
    if(query[1][0].length == 0) return;
    
    //console.log("parsing " + query[1][0].length + " records...");
    
    for(let i = 0; i < query[1][0].length; i+= 500)
    {
      let arrayResponse = [];
      
      for(let r = 0; r < 500; r++)
      {
        let index = (i + r);
        //console.log(index);
        if(index < query[1][0].length)
        {
          arrayResponse.push(query[1][0][index]);
        }
        else break;
      }
      //console.log(arrayResponse);
      let resultReturn = ConvertArrayPGN(arrayResponse);
      
      let r = [];
      let message = "PGNTOMOVELOG";
      r.push(message, resultReturn, i, resultReturn.length);
      let rString = JSON.stringify(r);
      postMessage(rString);
      //console.log("parsed records " + (i) + " to " + (i + resultReturn.length));
    }
    //console.log("parsed all records");
    let r1 = [];
    let message1 = "PARSEDALL";
    r1.push(message1);
    let rString1 = JSON.stringify(r1);
    postMessage(rString1);
    return;
  }
  
  if(query[0] == "FILLPGN")
  {
      let gameToPGN = JSON.parse(query[1]);
      
      GameToPGN(gameToPGN);
  }
}

function AddNewGame()
{  
  let newG = new Game();
  newG.index = gArray.length;
  newG.turn = true;
  newG.whiteAI = false;
  newG.blackAI = true;
  newG.board = [];
  newG.saveList = [];
  newG.currentMove = 0;
  
  currentG = gArray.length;
  
  let alternate = false;
  let counter = 0;
  
  for(let x = 0; x < 8; x++)
  {
    alternate = !alternate;
    for(let y = 0; y < 8; y++)
    {
      alternate = !alternate;
      let newSquare = new Square();
      FindIndex(counter, newSquare);
      newG.board.push(newSquare);
      newSquare.piece = "-";
      newSquare.firstMove = true;
      newSquare.moves = [];
      newSquare.white = alternate;
      counter++;
    }
  }
  
  for(let i = 0; i < 64; i++)
  {
    newG.board[i].upLine = GetLine(i, "up", newG.board);
    newG.board[i].downLine = GetLine(i, "down", newG.board);
    
    newG.board[i].leftLine = GetLine(i, "left", newG.board);
    newG.board[i].rightLine = GetLine(i, "right", newG.board);
    
    newG.board[i].upRightLine = GetLine(i, "upRight", newG.board);
    newG.board[i].upLeftLine = GetLine(i, "upLeft", newG.board);
    
    newG.board[i].downRightLine = GetLine(i, "downRight", newG.board);
    newG.board[i].downLeftLine = GetLine(i, "downLeft", newG.board);
  }
  
  newG.board[0].piece = "WR";
  newG.board[1].piece = "WK";
  newG.board[2].piece = "WB";
  newG.board[3].piece = "WQ";
  newG.board[4].piece = "WX";
  newG.board[5].piece = "WB";
  newG.board[6].piece = "WK";
  newG.board[7].piece = "WR";
  
  let i = 8;
  
  for(i; i < 16; i++)
  {
    newG.board[i].firstMove = true;
    newG.board[i].piece = "WP";
  }
  
  let empty = (4 * 8) + 16;
  
  for(i; i < empty; i++)
  {
    newG.board[i].piece = "-";
  }
  
  let bPawn = i + 8;
  
  for(i; i < bPawn; i++)
  {
    newG.board[i].firstMove = true;
    newG.board[i].piece = "BP";
  }
  
  newG.board[56].piece = "BR";
  newG.board[57].piece = "BK";
  newG.board[58].piece = "BB";
  newG.board[59].piece = "BQ";
  newG.board[60].piece = "BX";
  newG.board[61].piece = "BB";
  newG.board[62].piece = "BK";
  newG.board[63].piece = "BR";
  
  let nLen = newG.board.length;
  
  for(i = 0; i < nLen; i++)
  {
    newG.board[i].moves = [];
    newG.board[i].targetedByWhite = [];
    newG.board[i].targetedByBlack = [];
  }
  
  for(i = 0; i < nLen; i++)
  {
    let piece = newG.board[i].piece;
    if(piece == "WP" || piece == "BP") newG.board[i].moves = FindMovesPawn(i, newG.board);
    if(piece == "WR" || piece == "BR") newG.board[i].moves = FindMovesRook(i, newG.board);
    if(piece == "WK" || piece == "BK") newG.board[i].moves = FindMovesKnight(i, newG.board);
    if(piece == "WB" || piece == "BB") newG.board[i].moves = FindMovesBishops(i, newG.board);
    if(piece == "WQ" || piece == "BQ") newG.board[i].moves = FindMovesQueen(i, newG.board);
    if(piece == "WX" || piece == "BX") newG.board[i].moves = FindMovesKing(i, newG.board);
  }
  
  gArray.push(newG);
  
  let r = [];
  let message = "NEWGAME";
  let pArray = GetPieceArray(newG);
  
  let newMove = [0];
  let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
  gArray[currentG].saveList.push(sArray);
  
  r.push(message);
  r.push(pArray);
  r.push(currentG);
  r.push(gArray.length);
  r.push(gArray[currentG].currentMove);
  r.push(gArray[currentG].saveList.length);
  
  let rString = JSON.stringify(r);
  postMessage(rString);
}

function GetPieceArray(game)
{
  let result = [];
  for(let i = 0; i < game.board.length; i++)
  {
    result.push(game.board[i].piece);
  }
  return result;
}

function FindIndex(index, square)
{
  let indexInt = parseInt(index);
  square.index = index;

  let col = indexInt % 8;
  let row = Math.floor(indexInt / 8);
  
  square.col = col;
  square.row = row;
  
  if(row < 7) square.up = (indexInt + 8); else square.up = -1;
  if(row > 0) square.down = (indexInt - 8); else square.down = -1;
  
  if(col > 0) square.left = (indexInt - 1); else square.left = -1;
  if(col < 7) square.right = (indexInt + 1); else square.right = -1;
  
  if(row < 7 && col > 0) square.upLeft = (indexInt + 7); else square.upLeft = -1;
  if(row < 7 && col < 7) square.upRight = (indexInt + 9); else square.upRight = -1;
  
  if(row > 0 && col > 0) square.downLeft = (indexInt - 9); else square.downLeft = -1;
  if(row > 0 && col < 7) square.downRight = (indexInt - 7); else square.downRight = -1;
  
  if(row < 6 && col < 7) square.kUpRight = (indexInt + 17); else square.kUpRight = -1;
  if(row < 6 && col > 0) square.kUpLeft = (indexInt + 15); else square.kUpLeft = -1;
  
  if(row < 7 && col > 1) square.kLeftUp = (indexInt + 6); else square.kLeftUp = -1;
  if(row > 0 && col > 1) square.kLeftDown = (indexInt - 10); else square.kLeftDown = -1;
  
  if(row > 1 && col < 7) square.kDownRight = (indexInt - 15); else square.kDownRight = -1;
  if(row > 1 && col > 0) square.kDownLeft = (indexInt - 17); else square.kDownLeft = -1;
  
  if(row < 7 && col < 6) square.kRightUp = (indexInt + 10); else square.kRightUp = -1;
  if(row > 0 && col < 6) square.kRightDown = (indexInt - 6); else square.kRightDown = -1;
}

function GetLine(index, direction, board)
{
  if(index == -1) return -1;
  
  let result = [];
  let nextIndex = index;
  let counter = 0;
  
  while(nextIndex != -1)
  {
    counter++;
    
    if(counter > 10) break;
    
    if(nextIndex == -1) break;
    
    if(direction == "up") nextIndex = board[nextIndex].up;
    if(direction == "down") nextIndex = board[nextIndex].down;
    
    if(direction == "left") nextIndex = board[nextIndex].left;
    if(direction == "right") nextIndex = board[nextIndex].right;
    
    if(direction == "upRight") nextIndex = board[nextIndex].upRight;
    if(direction == "upLeft") nextIndex = board[nextIndex].upLeft;
    
    if(direction == "downRight") nextIndex = board[nextIndex].downRight;
    if(direction == "downLeft") nextIndex = board[nextIndex].downLeft;

    if(nextIndex != -1) result.push(nextIndex);
  }

  if(result.length > 0) return result; else return -1;
}

function GetMove(data)
{
  let index = data[1];
  
  console.log(gArray[currentG].board[index]);
  //console.log(gArray[currentG]);
  
  // turn on to ensure moves restricted to the active turn
  if(gArray[currentG].board[index].piece == "-") return;
  if(gArray[currentG].turn && gArray[currentG].board[index].piece[0] == "B") return;
  if(!gArray[currentG].turn && gArray[currentG].board[index].piece[0] == "W") return;
  
  gArray[currentG].lastMoved = parseInt(index);
  
  let header = "SHOWMOVES";
  let moves = gArray[currentG].board[index].moves;
  
  let r = [header, moves, gArray[currentG].board[index]];
  let rString = JSON.stringify(r);
  postMessage(rString);
}

function FindMovesPawn(index, board)
{
  let square = board[index];
  
  let up = square.up;
  let down = square.down;
  
  let upRight = square.upRight;
  let upLeft = square.upLeft;
  let downRight = square.downRight;
  let downLeft = square.downLeft;
  
  let result = [];
  
  let white = true;
  if(board[index].piece == "WP") white = true; else white = false;
  
  if(white) if(up != -1 && (board[up].piece == "-")) result.push(up);
  if(white) if(upRight != -1) { board[upRight].targetedByWhite.push(index) };
  if(white) if(upRight != -1 && (board[upRight].piece[0] == "B")) { result.push(upRight); };
  if(white) if(upLeft != -1) { board[upLeft].targetedByWhite.push(index) };
  if(white) if(upLeft != -1 && (board[upLeft].piece[0] == "B")) { result.push(upLeft); };

  if(!white) if(down != -1 && (board[down].piece == "-")) result.push(down);
  if(!white) if(downRight != -1) { board[downRight].targetedByBlack.push(index) };
  if(!white) if(downRight != -1 && (board[downRight].piece[0] == "W")) { result.push(downRight); };
  if(!white) if(downLeft != -1) { board[downLeft].targetedByBlack.push(index) };
  if(!white) if(downLeft != -1 && (board[downLeft].piece[0] == "W")) { result.push(downLeft); };

  if(square.firstMove)
  {
    if(white && square.row == 1)
    {
      if(board[up].piece == "-" && board[board[square.up].up].piece == "-") result.push(board[square.up].up);
    }
    else if(!white && square.row == 6)
    {
      if(board[down].piece == "-" && board[board[square.down].down].piece == "-") result.push(board[square.down].down);
    }
  }
  
  // en passant check
  let left = square.left;
  let right = square.right;
  if(debugB) if(left != -1 && white && index == 39 && board[left].enPassant > 0) console.log("EN PASSANT OF LEFT IS " + board[left].enPassant);
  if(debugB) if(left != -1 && white && board[left].enPassant > 0) console.log("UPLEFT IS " + upLeft);
  if(left != -1 && white && board[left].enPassant > 0) result.push(upLeft);
  if(right != -1 && white && board[right].enPassant > 0) result.push(upRight);
  
  if(left != -1 && !white && board[left].enPassant > 0) result.push(downLeft);
  if(right != -1 && !white && board[right].enPassant > 0) result.push(downRight);
  
  if(debugB) if(index == 39) console.log(result);
  
  return result;
}

function FindMovesRook(index, board)
{
  let square = board[index];
  
  let leftLine = square.leftLine;
  let rightLine = square.rightLine;
  
  let upLine = square.upLine;
  let downLine = square.downLine;
  
  let result = [];
  
  let white = true;
  if(board[index].piece == "WR") white = true; else white = false;
  
  result.push(AddFromLine(leftLine, board, white, index));
  result.push(AddFromLine(rightLine, board, white, index));
  
  result.push(AddFromLine(upLine, board, white, index));
  result.push(AddFromLine(downLine, board, white, index));

  return result;
}

function FindMovesKnight(index, board)
{
  let square = board[index];
  
  let kDownLeft = square.kDownLeft;
  let kDownRight = square.kDownRight;
  
  let kUpLeft = square.kUpLeft;
  let kUpRight = square.kUpRight;
  
  let kLeftUp = square.kLeftUp;
  let kLeftDown = square.kLeftDown;
  
  let kRightUp = square.kRightUp;
  let kRightDown = square.kRightDown;
  
  let result = [];
  
  let white = true;
  if(board[index].piece == "WK") white = true; else white = false;
  
  if(kDownLeft != -1) {
    if(white) board[kDownLeft].targetedByWhite.push(index); else board[kDownLeft].targetedByBlack.push(index);
    if(board[kDownLeft].piece == "-") result.push(kDownLeft);
    else if(board[kDownLeft].piece[0] == "W") { if(!white) result.push(kDownLeft) }
    else if(board[kDownLeft].piece[0] == "B") { if(white) result.push(kDownLeft)}; };
  if(kDownRight != -1) {
    if(white) board[kDownRight].targetedByWhite.push(index); else board[kDownRight].targetedByBlack.push(index);
    if(board[kDownRight].piece == "-") result.push(kDownRight);
    else if(board[kDownRight].piece[0] == "W") { if(!white) result.push(kDownRight)}
    else if(board[kDownRight].piece[0] == "B") { if(white) result.push(kDownRight)}; };
  
  if(kUpLeft != -1) {
    if(white) board[kUpLeft].targetedByWhite.push(index); else board[kUpLeft].targetedByBlack.push(index);
    if(board[kUpLeft].piece == "-") result.push(kUpLeft);
    else if(board[kUpLeft].piece[0] == "W") { if(!white) result.push(kUpLeft)}
    else if(board[kUpLeft].piece[0] == "B") { if(white) result.push(kUpLeft)}; };
  if(kUpRight != -1) {
    if(white) board[kUpRight].targetedByWhite.push(index); else board[kUpRight].targetedByBlack.push(index);
    if(board[kUpRight].piece == "-") result.push(kUpRight);
    else if(board[kUpRight].piece[0] == "W") { if(!white) result.push(kUpRight)}
    else if(board[kUpRight].piece[0] == "B") { if(white) result.push(kUpRight)}; };
  
  if(kLeftUp != -1) {
    if(white) board[kLeftUp].targetedByWhite.push(index); else board[kLeftUp].targetedByBlack.push(index);
    if(board[kLeftUp].piece == "-") result.push(kLeftUp);
    else if(board[kLeftUp].piece[0] == "W") { if(!white) result.push(kLeftUp)}
    else if(board[kLeftUp].piece[0] == "B") { if(white) result.push(kLeftUp)}; };
  if(kLeftDown != -1) {
    if(white) board[kLeftDown].targetedByWhite.push(index); else board[kLeftDown].targetedByBlack.push(index);
    if(board[kLeftDown].piece == "-") result.push(kLeftDown);
    else if(board[kLeftDown].piece[0] == "W") { if(!white) result.push(kLeftDown)}
    else if(board[kLeftDown].piece[0] == "B") { if(white) result.push(kLeftDown)}; };
  
  if(kRightUp != -1) {
    if(white) board[kRightUp].targetedByWhite.push(index); else board[kRightUp].targetedByBlack.push(index);
    if(board[kRightUp].piece == "-") result.push(kRightUp);
    else if(board[kRightUp].piece[0] == "W") { if(!white) result.push(kRightUp)}
    else if(board[kRightUp].piece[0] == "B") { if(white) result.push(kRightUp)}; };
  if(kRightDown != -1) {
    if(white) board[kRightDown].targetedByWhite.push(index); else board[kRightDown].targetedByBlack.push(index);
    if(board[kRightDown].piece == "-") result.push(kRightDown);
    else if(board[kRightDown].piece[0] == "W") { if(!white) result.push(kRightDown)}
    else if(board[kRightDown].piece[0] == "B") { if(white) result.push(kRightDown)}; };
  
  return result;
}

function FindMovesBishops(index, board)
{
  let square = board[index];
  
  let upRightLine = square.upRightLine;
  let upLeftLine = square.upLeftLine;
  
  let downRightLine = square.downRightLine;
  let downLeftLine = square.downLeftLine;
  
  let result = [];
  
  let white = true;
  if(board[index].piece == "WB") white = true; else white = false;

  result.push(AddFromLine(upRightLine, board, white, index));
  result.push(AddFromLine(upLeftLine, board, white, index));
  
  result.push(AddFromLine(downRightLine, board, white, index));
  result.push(AddFromLine(downLeftLine, board, white, index));
  
  return result;
}

function FindMovesQueen(index, board)
{
  let square = board[index];
  
  let leftLine = square.leftLine;
  let rightLine = square.rightLine;
  
  let upLine = square.upLine;
  let downLine = square.downLine;
  
  let upRightLine = square.upRightLine;
  let upLeftLine = square.upLeftLine;
  
  let downRightLine = square.downRightLine;
  let downLeftLine = square.downLeftLine;
  
  let result = [];
  
  let white = true;
  if(board[index].piece == "WQ") white = true; else white = false;
  
  result.push(AddFromLine(leftLine, board, white, index));
  result.push(AddFromLine(rightLine, board, white, index));
  
  result.push(AddFromLine(upLine, board, white, index));
  result.push(AddFromLine(downLine, board, white, index));

  result.push(AddFromLine(upRightLine, board, white, index));
  result.push(AddFromLine(upLeftLine, board, white, index));
  
  result.push(AddFromLine(downRightLine, board, white, index));
  result.push(AddFromLine(downLeftLine, board, white, index));
  
  return result;
}

function FindMovesKing(index, board)
{
  let square = board[index];
  
  let white = true;
  if(board[index].piece == "WX") white = true; else white = false;
  
  let up = square.up;
  if(up != -1 && white && board[up].targetedByBlack.length > 0) up = -1;
  if(up != -1 && !white && board[up].targetedByWhite.length > 0) up = -1;
  let down = square.down;
  if(down != -1 && white && board[down].targetedByBlack.length > 0) down = -1;
  if(down != -1 && !white && board[down].targetedByWhite.length > 0) down = -1;
  
  let left = square.left;
  if(left != -1 && white && board[left].targetedByBlack.length > 0) left = -1;
  if(left != -1 && !white && board[left].targetedByWhite.length > 0) left = -1;
  let right = square.right;
  if(right != -1 && white && board[right].targetedByBlack.length > 0) right = -1;
  if(right != -1 && !white && board[right].targetedByWhite.length > 0) right = -1;
  
  let upRight = square.upRight;
  if(upRight != -1 && white && board[upRight].targetedByBlack.length > 0) upRight = -1;
  if(upRight != -1 && !white && board[upRight].targetedByWhite.length > 0) upRight = -1;
  let upLeft = square.upLeft;
  if(upLeft != -1 && white && board[upLeft].targetedByBlack.length > 0) upLeft = -1;
  if(upLeft != -1 && !white && board[upLeft].targetedByWhite.length > 0) upLeft = -1;
  
  let downRight = square.downRight;
  if(downRight != -1 && white && board[downRight].targetedByBlack.length > 0) downRight = -1;
  if(downRight != -1 && !white && board[downRight].targetedByWhite.length > 0) downRight = -1;
  let downLeft = square.downLeft;
  if(downLeft != -1 && white && board[downLeft].targetedByBlack.length > 0) downLeft = -1;
  if(downLeft != -1 && !white && board[downLeft].targetedByWhite.length > 0) downLeft = -1;
  
  let result = [];
  
  if(up != -1) {
    if(white) board[up].targetedByWhite.push(index); else board[up].targetedByBlack.push(index);
    if(board[up].piece == "-") result.push(up);
    else if(board[up].piece[0] == "W") { if(!white) result.push(up)}
    else if(board[up].piece[0] == "B") { if(white) result.push(up)}; };
  if(down != -1) {
    if(white) board[down].targetedByWhite.push(index); else board[down].targetedByBlack.push(index);
    if(board[down].piece == "-") result.push(down);
    else if(board[down].piece[0] == "W") { if(!white) result.push(down)}
    else if(board[down].piece[0] == "B") { if(white) result.push(down)}; };
  
  if(left != -1) {
    if(white) board[left].targetedByWhite.push(index); else board[left].targetedByBlack.push(index);
    if(board[left].piece == "-") result.push(left);
    else if(board[left].piece[0] == "W") { if(!white) result.push(left)}
    else if(board[left].piece[0] == "B") { if(white) result.push(left)}; };
  if(right != -1) {
    if(white) board[right].targetedByWhite.push(index); else board[right].targetedByBlack.push(index);
    if(board[right].piece == "-") result.push(right);
    else if(board[right].piece[0] == "W") { if(!white) result.push(right)}
    else if(board[right].piece[0] == "B") { if(white) result.push(right)}; };
  
  if(upRight != -1) {
    if(white) board[upRight].targetedByWhite.push(index); else board[upRight].targetedByBlack.push(index);
    if(board[upRight].piece == "-") result.push(upRight);
    else if(board[upRight].piece[0] == "W") { if(!white) result.push(upRight)}
    else if(board[upRight].piece[0] == "B") { if(white) result.push(upRight)}; };
  if(upLeft != -1) {
    if(white) board[upLeft].targetedByWhite.push(index); else board[upLeft].targetedByBlack.push(index);
    if(board[upLeft].piece == "-") result.push(upLeft);
    else if(board[upLeft].piece[0] == "W") { if(!white) result.push(upLeft)}
    else if(board[upLeft].piece[0] == "B") { if(white) result.push(upLeft)}; };
  
  if(downRight != -1) {
    if(white) board[downRight].targetedByWhite.push(index); else board[downRight].targetedByBlack.push(index);
    if(board[downRight].piece == "-") result.push(downRight);
    else if(board[downRight].piece[0] == "W") { if(!white) result.push(downRight)}
    else if(board[downRight].piece[0] == "B") { if(white) result.push(downRight)}; };
  if(downLeft != -1) {
    if(white) board[downLeft].targetedByWhite.push(index); else board[downLeft].targetedByBlack.push(index);
    if(board[downLeft].piece == "-") result.push(downLeft);
    else if(board[downLeft].piece[0] == "W") { if(!white) result.push(downLeft)}
    else if(board[downLeft].piece[0] == "B") { if(white) result.push(downLeft)}; };
    
  // WHITE - establish castle rights if king on start square and hasn't moved
  if(white && index == 4 && board[index].firstMove && board[index].targetedByBlack.length == 0)
  {
    for(let i = 0; i < square.leftLine.length; i++)
    {
      // if all squares but the last one are either not empty or under threat then cancel
      if(i < (square.leftLine.length - 1) && (board[square.leftLine[i]].piece != "-"
      || board[square.leftLine[i]].targetedByBlack.length > 0)) break;
      // if last square isn't a rook with no threat then cancel
      if(i == square.leftLine.length && (board[square.leftLine[i]].piece != "WR") && board[i].firstMove) break;
      // if passed those tests then add to move list
      result.push(2);
    }
    for(let i = 0; i < square.rightLine.length; i++)
    {
      // if all squares but the last one are either not empty or under threat then cancel
      if(i < (square.rightLine.length - 1) && (board[square.rightLine[i]].piece != "-"
      || board[square.rightLine[i]].targetedByBlack.length > 0)) break;
      // if last square isn't a rook with no threat then cancel
      if(i == square.rightLine.length && (board[square.rightLine[i]].piece != "WR") && board[i].firstMove) break;
      // if passed those tests then add to move list
      result.push(6);
    }
  }
  // BLACK
  if(!white && index == 60 && board[index].firstMove && board[index].targetedByWhite.length == 0)
  {
    for(let i = 0; i < square.leftLine.length; i++)
    {
      // if all squares but the last one are either not empty or under threat then cancel
      if(i < (square.leftLine.length - 1) && (board[square.leftLine[i]].piece != "-"
      || board[square.leftLine[i]].targetedByWhite.length > 0)) break;
      // if last square isn't a rook with no threat then cancel
      if(i == square.leftLine.length && (board[square.leftLine[i]].piece != "BR") && board[i].firstMove) break;
      // if passed those tests then add to move list
      result.push(58);
    }
    for(let i = 0; i < square.rightLine.length; i++)
    {
      // if all squares but the last one are either not empty or under threat then cancel
      if(i < (square.rightLine.length - 1) && (board[square.rightLine[i]].piece != "-"
      || board[square.rightLine[i]].targetedByWhite.length > 0)) break;
      // if last square isn't a rook with no threat then cancel
      if(i == square.rightLine.length && (board[square.rightLine[i]].piece != "BR") && board[i].firstMove) break;
      // if passed those tests then add to move list
      result.push(62);
    }
  }
  
  return result;
}

// array = line along which to count
// board = square array
// white = turn, true = white false = black
// index = the starting square
function AddFromLine(array, board, white, index)
{
  if(array.length == 0) return;
  
  let result = [];
  // xRay is turned on after reach the first piece, turned off after (including) the second piece
  // if piece is white, mark each square up to the first black piece as a result and targeted by white
  // if the first piece is white mark don't add that to result
  // if first piece was opposite colour, run xray following on until it hits a piece and mark all squares as xray
  // don't run xray if first piece hit was same colour
  let xRay = false;
  
  for(let i = 0; i < array.length; i++)
  {
    let square = array[i];
    if(board[square] != null)
    {
      // for white pieces
      if(board[index].piece[0] == "W")
      {
        // if xray is on
        if(xRay)
        {
          // mark all empty squares as xrayed
          if(board[square].piece == "-")
          {
            board[square].xRayWhite.push(index);
          }
          // mark the first piece and end
          if(board[square].piece[0] != "-")
          {
            board[square].xRayWhite.push(index);
            break;
          }
        }
        else
        {
          // if xray is off
          // mark all empty squares in result and targeted by white
          if(board[square].piece == "-")
          {
            board[square].targetedByWhite.push(index);
            result.push(square);
          }
          // if hit a black piece first
          if(board[square].piece[0] == "B")
          {
            // actiate xray
            board[square].targetedByWhite.push(index);
            result.push(square);
            xRay = true;
          }
          // if hit a white piece first
          if(board[square].piece[0] == "W")
          {
            // dont activate xRay, just target and end
            board[square].targetedByWhite.push(index);
            xRay = true;
            break;
          }
        }
      }
      // for black pieces
      if(board[index].piece[0] == "B")
      {
        // if xray is on
        if(xRay)
        {
          // mark all empty squares as xrayed
          if(board[square].piece == "-")
          {
            board[square].xRayBlack.push(index);
          }
          // mark the first piece and end
          if(board[square].piece[0] != "-")
          {
            board[square].xRayBlack.push(index);
            break;
          }
        }
        else
        {
          // if xray is off
          // mark all empty squares in result and targeted by white
          if(board[square].piece == "-")
          {
            board[square].targetedByBlack.push(index);
            result.push(square);
          }
          // if hit a same colour piece first
          if(board[square].piece[0] == "W")
          {
            // actiate xray
            board[square].targetedByBlack.push(index);
            result.push(square);
            xRay = true;
          }
          // if hit an opposite colour piece first
          if(board[square].piece[0] == "B")
          {
            // dont activate xRay, just target and end
            board[square].targetedByBlack.push(index);
            xRay = true;
            break;
          }
        }
      }
    }
  }
  return result;
}

function MovePiece(data)
{
  let from = gArray[currentG].lastMoved;
  let to = data[1][0];
  let board = gArray[currentG].board;
  
  // stop any manipulation, can't move to a square not in the move list
  let mArray = board[from].moves.flat();
  if(!mArray.includes(to)) return;
  
  // reset the game state flag
  gArray[currentG].state = "";
  
  // execute the piece move
  UpdateBoard(from, to, gArray[currentG].board, gArray[currentG]);
  // swap turns and generate the new move list
  gArray[currentG].turn = !gArray[currentG].turn;
  EvaluateBoard(gArray[currentG]);
  gArray[currentG].currentMove++;
  
  if(gArray[currentG].state == "CHECKMATEWHITE" || gArray[currentG].state == "CHECKMATEBLACK" ||
  gArray[currentG].state == "DRAW50" || gArray[currentG].state == "DRAWMATERIAL" ||
  gArray[currentG].state == "DRAWSTALEMATE" || gArray[currentG].state == "DRAWTHREE")
  {
    for(let i = 0; i < gArray[currentG].board.length; i++)
    {
      gArray[currentG].board[i].moves = [];
    }
  }
  
  // if the player is creating a new branch game, for now overwrite any future moves
  // in the future can turn savelist into a multidimensional array to save multiple branches of a game
  if(gArray[currentG].currentMove != gArray[currentG].saveList.length)
  {
    gArray[currentG].saveList = gArray[currentG].saveList.slice(0, gArray[currentG].currentMove);
  }
  // save the move
  let newMove = [[from, board[from].piece], [to, board[to].piece]];
  let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
  gArray[currentG].saveList.push(sArray);
  
  // set an ai move if either side is run by the ai and it is it's turn
  // set custom diversion for cases where both ai sides are running
  if(gArray[currentG].blackAI && gArray[currentG].whiteAI) return;
  if(gArray[currentG].blackAI || gArray[currentG].whiteAI)
  {
    let aiMove = [-1, -1];
    if((!gArray[currentG].turn && gArray[currentG].blackAI) || 
    (gArray[currentG].turn && gArray[currentG].whiteAI)) aiMove = GetHalMove(gArray[currentG]);

    // if an ai move was running then update the board for that move
    if(aiMove[0] != -1 && aiMove[1] != -1)
    {
      // reset the game state flag
      gArray[currentG].state = "";
  
      UpdateBoard(aiMove[0], aiMove[1], gArray[currentG].board, gArray[currentG]);
      gArray[currentG].turn = !gArray[currentG].turn;
      EvaluateBoard(gArray[currentG]);
      gArray[currentG].currentMove++;
      
      if(gArray[currentG].state == "CHECKMATEWHITE" || gArray[currentG].state == "CHECKMATEBLACK" ||
      gArray[currentG].state == "DRAW50" || gArray[currentG].state == "DRAWMATERIAL" ||
      gArray[currentG].state == "DRAWSTALEMATE" || gArray[currentG].state == "DRAWTHREE")
      {
        for(let i = 0; i < gArray[currentG].board.length; i++)
        {
          gArray[currentG].board[i].moves = [];
        }
      }
      
      // save the move
      let newMove1 = [[from, board[from].piece], [to, board[to].piece]];
      let sArray1 = GetSaveTurn(gArray[currentG], newMove1, gArray[currentG].state);
      gArray[currentG].saveList.push(sArray1);
    }
  }
  
  let header = "MOVEPIECE";
  // get the final piece array to export back to display
  let newPieces = GetPieceArray(gArray[currentG]);
  let r = [header, newPieces, from, gArray[currentG], gArray[currentG].currentMove, gArray[currentG].saveList.length, gArray[currentG].state];
  let rString = JSON.stringify(r);
  postMessage(rString);
}

function UpdateBoard(from, to, board, game, promoteTo)
{
  // CHECK if castle move - in which case reallocate Rook
  // left side white castle
  if(game.board[from].piece == "WX" && from == 4 
    && game.board[from].firstMove && to == 2)
  {
    game.board[0].piece = "-";
    game.board[3].piece = "WR";
  }
  // right side white castle
  if(game.board[from].piece == "WX" && from == 4 
    && game.board[from].firstMove && to == 6)
  {
    game.board[7].piece = "-";
    game.board[5].piece = "WR";
  }
  // left side black castle
  if(game.board[from].piece == "BX" && from == 60 
    && game.board[from].firstMove && to == 58)
  {
    game.board[56].piece = "-";
    game.board[59].piece = "BR";
  }
  // right side black castle
  if(game.board[from].piece == "BX" && from == 60 
    && game.board[from].firstMove && to == 62)
  {
    game.board[63].piece = "-";
    game.board[61].piece = "BR";
  }
  
  // enpassant LOG white pawn
  if(game.board[from].piece == "WP" && game.board[from].firstMove 
     && to == game.board[game.board[from].up].up)
  {
    game.board[to].enPassant = 2;
  }
  
  // enpassant LOG black pawn
  if(game.board[from].piece == "BP" && game.board[from].firstMove 
     && to == game.board[game.board[from].down].down)
  {
    game.board[to].enPassant = 2;
  }
  
  // enpassant CAPTURE white
  if(game.board[from].piece == "WP" && game.board[to].piece == "-"
  && game.board[from].col != game.board[to].col)
  {
    if(debugB) console.log("CAPTURING EN PASSANT AT " + (to - 8));
    game.fifty = 0;
    game.board[(to - 8)].piece = "-";
  }
  
  // enpassant CAPTURE black
  if(game.board[from].piece == "BP" && game.board[to].piece == "-"
  && game.board[from].col != game.board[to].col)
  {
    if(debugB) console.log("CAPTURING EN PASSANT AT " + (to + 8));
    game.fifty = 0;
    game.board[(to + 8)].piece = "-";
  }
  
  // increment fifty by 0.5 each side so can trigger startin from black or white
  game.fifty += 0.5;
  // reset fifty rule if to contains a piece
  if(game.board[to].piece != "-") game.fifty = 0;
  // reset fifty rule if from piece was a pawn
  if(game.board[from].piece[1] == "P") game.fifty = 0;
  // move the actual piece and overwrite the target if it did contain a piece
  game.board[to].piece = game.board[from].piece;
  game.board[from].piece = "-";
  
  // change firstMove status
  if(game.board[from].firstMove === true) game.board[from].firstMove = false;
  
  // auto promote to queen for now
  if(board[to].piece === "WP" && board[to].row === 7)
  {
    if(debugB) console.log(promoteTo);
    if(promoteTo != null) game.board[to].piece = "W" + promoteTo;
    else game.board[to].piece = "WQ";
  }
  if(board[to].piece === "BP" && board[to].row === 0)
  {
    if(debugB) console.log(promoteTo);
    if(promoteTo != null) game.board[to].piece = "B" + promoteTo;
    else game.board[to].piece = "BQ";
  }
}

function EvaluateBoard(game)
{
  //console.log("EVALUATING");
  // clear previous moves data
  for(let i = 0; i < game.board.length; i++)
  {
    game.board[i].moves = [];
    game.board[i].targetedByWhite = [];
    game.board[i].targetedByBlack = [];
    game.board[i].xRayWhite = [];
    game.board[i].xRayBlack = [];
    if(game.board[i].enPassant > 0) game.board[i].enPassant--;
  }
  // get the raw moves for each piece that can move
  // find index for king

  let king = -1;
  let kingW = -1;
  let kingB = -1;
  for(let i = 0; i < game.board.length; i++)
  {
    let piece = game.board[i].piece;
    if(piece == "WP" || piece == "BP") game.board[i].moves = FindMovesPawn(i, game.board);
    if(piece == "WR" || piece == "BR") game.board[i].moves = FindMovesRook(i, game.board);
    if(piece == "WK" || piece == "BK") game.board[i].moves = FindMovesKnight(i, game.board);
    if(piece == "WB" || piece == "BB") game.board[i].moves = FindMovesBishops(i, game.board);
    if(piece == "WQ" || piece == "BQ") game.board[i].moves = FindMovesQueen(i, game.board);
    if(piece == "WX" || piece == "BX") game.board[i].moves = FindMovesKing(i, game.board);
    if(piece == "WX"){
      if(game.turn) king = i; 
      kingW = i;
    };
    if(piece == "BX"){ 
      if(!game.turn) king = i; 
      kingB = i;
    };
  }
  
  if(kingW != -1) game.board[kingW].moves = FindMovesKing(kingW, game.board);
  if(kingB != -1) game.board[kingB].moves = FindMovesKing(kingB, game.board);
  
  // FREEZE XRAY PIECES
  if(game.turn && game.board[king].xRayBlack.length > 0)
  {
    for(let x = 0; x < game.board[king].xRayBlack.length; x++)
    {
      let xLine = FindXRayLine(king, game.board[king].xRayBlack[x], game);
      //console.log("XRAY BLACK IS " + xLine);
      
      // if there is more than 1 black piece between king and white piece then don't freeze any
      // if there is only 1 piece freeze it
      // don't go past the white piece
      let piecesToFreeze = [];
      let hitOther = false;
      for(let i = 0; i < xLine.length; i++)
      {
        if(hitOther == false)
        {
          if(game.board[xLine[i]].piece[0] == "W")
          {
            piecesToFreeze.push(xLine[i]);
          }
          if(game.board[xLine[i]].piece[0] == "B")
          {
            hitOther = true;
          }
        }
      }
      
      //console.log(piecesToFreeze);
      
      if(piecesToFreeze.length == 1)
      {
        //console.log("XRAY FROZEN IS: ");
        //console.log(game.board[piecesToFreeze[0]]);
        let newMoves1 = [];
        let flatMoves2 = game.board[piecesToFreeze[0]].moves.flat();
        for(let m = 0; m < flatMoves2.length; m++)
        {
          if(xLine.includes(flatMoves2[m])) newMoves1.push(flatMoves2[m]);
        }
        // frozen pieces can move along the XRayLine
        game.board[piecesToFreeze[0]].moves = [];
        game.board[piecesToFreeze[0]].moves = newMoves1;
      }
    }
  }
  if(debugB) console.log("king is " + king);
  // freeze black pieces
  if(!game.turn && game.board[king].xRayWhite.length > 0)
  {
    
    for(let x = 0; x < game.board[king].xRayWhite.length; x++)
    {
      let xLine = FindXRayLine(king, game.board[king].xRayWhite[x], game);
      //console.log("XRAY BLACK IS " + xLine);
      
      // if there is more than 1 black piece between king and white piece then don't freeze any
      // if there is only 1 piece freeze it
      // don't go past the white piece
      let piecesToFreeze = [];
      let hitOther = false;
      for(let i = 0; i < xLine.length; i++)
      {
        if(hitOther == false)
        {
          if(game.board[xLine[i]].piece[0] == "B")
          {
            piecesToFreeze.push(xLine[i]);
          }
          if(game.board[xLine[i]].piece[0] == "W")
          {
            hitOther = true;
          }
        }
      }
      
      //console.log(piecesToFreeze);
      
      if(piecesToFreeze.length == 1)
      {
        //console.log("XRAY FROZEN IS: ");
        //console.log(game.board[piecesToFreeze[0]]);
        let newMoves1 = [];
        let flatMoves2 = game.board[piecesToFreeze[0]].moves.flat();
        for(let m = 0; m < flatMoves2.length; m++)
        {
          if(xLine.includes(flatMoves2[m])) newMoves1.push(flatMoves2[m]);
        }
        // frozen pieces can move along the XRayLine
        game.board[piecesToFreeze[0]].moves = [];
        game.board[piecesToFreeze[0]].moves = newMoves1;
      }
    }
  }
  
  // fifty move rule draw
  if(game.fifty >= 50)
  {
    game.state = "DRAW50";
  }
  
  // insufficient material
  // king v king - done
  // king and bishop v king - done
  // king and knight v king - done
  // king and bishop v king and bishop of same colours
  let whiteRemaining = [];
  let blackRemaining = [];
  let bishopWhite = false;
  let bishopBlack = false;
  for(let i = 0; i < game.board.length; i++)
  {
    if(game.board[i].piece[0] == "W")
    {
      whiteRemaining.push(game.board[i].piece);
      if(game.board[i].piece[1] == "B") bishopWhite = game.board[i].white;
    }
    if(game.board[i].piece[0] == "B")
    {
      blackRemaining.push(game.board[i].piece);
      if(game.board[i].piece[1] == "B") bishopBlack = game.board[i].white;
    }
  }
  // king v king
  if(whiteRemaining.length == 1 && whiteRemaining[0] == "WX" &&
  blackRemaining.length == 1 && blackRemaining[0] == "BX")
  {
    game.state = "DRAWMATERIAL";
  }
  // white king and bishop v black king
  if(whiteRemaining.length == 2 && whiteRemaining.includes("WX") && whiteRemaining.includes("WB") &&
  blackRemaining.length == 1 && blackRemaining[0] == "BX")
  {
    game.state = "DRAWMATERIAL";
  }
  // black king and bishop v white king
  if(blackRemaining.length == 2 && blackRemaining.includes("BX") && blackRemaining.includes("BB") &&
  whiteRemaining.length == 1 && whiteRemaining[0] == "WX")
  {
    game.state = "DRAWMATERIAL";
  }
  // white king and knight v black king
  if(whiteRemaining.length == 2 && whiteRemaining.includes("WX") && whiteRemaining.includes("WK") &&
  blackRemaining.length == 1 && blackRemaining[0] == "BX")
  {
    game.state = "DRAWMATERIAL";
  }
  // black king and knight v white king
  if(blackRemaining.length == 2 && blackRemaining.includes("BX") && blackRemaining.includes("BK") &&
  whiteRemaining.length == 1 && whiteRemaining[0] == "WX")
  {
    game.state = "DRAWMATERIAL";
  }
  // king and bishop v king and bishop same colour
  if(blackRemaining.length == 2 && blackRemaining.includes("BX") && blackRemaining.includes("BB") &&
     whiteRemaining.length == 2 && whiteRemaining.includes("WX") && blackRemaining.includes("WB"))
  {
    if(bishopWhite == bishopBlack) game.state = "DRAWMATERIAL";
  }

  // threefold repetition
  let threeFoldArray = [];
  let threeFoldCount = [];
  for(let i = 0; i < game.saveList.length; i++)
  {
    let testString = JSON.stringify(game.saveList[i]);
    let check = true;
    
    for(let t = 0; t < threeFoldArray.length; t++) if(testString == threeFoldArray[t])
    {
      check = false;
    }
    
    if(check)
    {
      threeFoldArray.push(testString);
      threeFoldCount.push(1);
    }
    else
    {
      let io = threeFoldArray.indexOf(testString);
      threeFoldCount[io]++;
    }
  }
  for(let i = 0; i < threeFoldArray.length; i++)
  {
    if(threeFoldCount[i] >= 3) game.state = "DRAWTHREE";
  }
  
  // Stalemate check - if king not in check
  if((game.turn && game.board[king].targetedByBlack.length == 0) ||
  (!game.turn && game.board[king].targetedByWhite.length == 0))
  {
    let moveCount = 0;
    for(let i = 0; i < game.board.length; i++)
    {
      let piece = game.board[i].piece;
      if(game.turn && piece[0] == "W") { let c = game.board[i].moves.flat(); moveCount += c.length; };
      if(!game.turn && piece[0] == "B") { let c = game.board[i].moves.flat(); moveCount += c.length; };
    }
    if(moveCount == 0)
    {
      game.state = "DRAWSTALEMATE";
    }
  }

  // if king is attacked then in check
  // white king in check
  if(game.turn && game.board[king].targetedByBlack.length > 0)
  {
    if(debugB) console.log("CHECK WHITE");
    game.state = "CHECKWHITE";    
    
    // list of all squares that saves check, 
    let checkSaves = [];
    let checkLine = [];
    // if targetedbyBlack > 1, only escape is for king to move
    let doubleCheck = false;
    if(game.board[king].targetedByBlack.length > 1) doubleCheck = true;
    
    for(let i = 0; i < game.board[king].targetedByBlack.length; i++)
    {
      // get the square of the checking piece
      let checkingSquare = game.board[game.board[king].targetedByBlack[i]];
      // need to remove all squares from behind the king so doesn't escape check along it
      // if queen bishop or rook then need to add all squares along line between king and piece as checksaves
      // this will include the checking square
      if(checkingSquare.piece == "BR" || checkingSquare.piece == "BB" || checkingSquare.piece == "BQ")
      {
        checkSaves.push(GetCheckSaves(king, game.board[king].targetedByBlack[i], game));
        checkLine.push(GetCheckLine(king, game.board[king].targetedByBlack[i], game));
      }
      else
      {
        // can always save check by capturing the checking piece
        checkSaves.push(game.board[king].targetedByBlack[i]);
      }
    }
    
    // stop the king from trying to escape check by moving backwards along the checking line
    checkLine = checkLine.flat();
    if(checkLine.length > 0)
    {
      let newKingMoves = [];
      for(let i = 0; i < game.board[king].moves.length; i++)
      {
        if(!checkLine.includes(game.board[king].moves[i])) newKingMoves.push(game.board[king].moves[i]);
      }
      game.board[king].moves = [];
      game.board[king].moves = newKingMoves;
    }
    
    checkSaves = checkSaves.flat();
    
    // check if the checking piece was a pawn which can be captured en passant, so other pawns can check if they can capture it in response
    let enPassantCheck = [];
    for(let i = 0; i < game.board[king].targetedByBlack.length; i++)
    {
      let checkingSquare = game.board[game.board[king].targetedByBlack[i]];
      if(debugB) console.log("CHECKING SQUARE IS " + checkingSquare.piece);
      if(debugB) console.log("CHECKING SQUARE EN PASSANT IS " + checkingSquare.enPassant);
      if(checkingSquare.piece == "BP" && checkingSquare.enPassant > 0)
      {
        enPassantCheck.push(game.board[game.board[king].targetedByBlack[i]].up);
      }
    }
    if(debugB) console.log("CHECKSAVES LENGTH IS " + checkSaves.length);
    if(debugB) console.log("CHECKSAVES IS " + checkSaves);
    if(debugB) console.log("ENPASSANTECHECK LENGTH IS " + enPassantCheck.length);
    if(debugB) console.log("ENPASSANTECHECK IS " + enPassantCheck);
    if(checkSaves.length > 0)
    {
      let gameSaveMoves = [];
      // once have checksave list, remove all moves that aren't on it
      for(let i = 0; i < game.board.length; i++)
      {
        if(game.board[i].piece == "-" || game.board[i].piece[0] == "B") continue;
        
        if(game.board[i].moves.length > 0)
        {
          // check if the piece is a pawn and can capture in the enPassantCheck array, in which case save those moves to re-add to moves array
          let saveEnPassant = [];
          if(game.board[i].piece == "WP" && enPassantCheck.length > 0)
          {
            for(let m = 0; m < game.board[i].moves.length; m++)
            {
              if(enPassantCheck.includes(game.board[i].moves[m]))
              {
                gameSaveMoves.push(game.board[i].moves[m]);
                saveEnPassant.push(game.board[i].moves[m]);
              }
            }
          }
        
          // if the piece is not the king, remove all moves that aren't in checkmoves (i.e. block or capture only)
          if(game.board[i].piece != "WX")
          {
            // if double check then only king can move
            if(!doubleCheck)
            {
              let newMoves = [];
              let oldMoves = game.board[i].moves.flat();
              for(let m = 0; m < oldMoves.length; m++)
              {
                if(checkSaves.includes(oldMoves[m]))
                {
                  newMoves.push(oldMoves[m]);
                  gameSaveMoves.push(oldMoves[m]);
                }
              }
              game.board[i].moves = newMoves;
              if(saveEnPassant.length > 0) for(let s = 0; s < saveEnPassant.length; s++) game.board[i].moves.push(saveEnPassant[s]);
            }
          }
          else
          {
            // if the king piece, only add moves that arent in checksaves
            // except for if the king can capture the piece checking, and that piece isn't itself threatByWhite
            let newMoves = [];
            let oldMoves = game.board[i].moves.flat();
            for(let m = 0; m < oldMoves.length; m++)
            {
              // run away from check
              if(!checkSaves.includes(oldMoves[m]))
              {
                newMoves.push(oldMoves[m]);
                gameSaveMoves.push(oldMoves[m]);
              }
              // or capture the checking piece if it isn't itself targetted (can't capture into check)
              if(game.board[king].targetedByBlack.includes(oldMoves[m]))
              {
                if(game.board[oldMoves[m]].targetedByBlack.length == 0)
                {
                  newMoves.push(oldMoves[m]);
                  gameSaveMoves.push(oldMoves[m]);
                }
              }
            }
            game.board[i].moves = [];
            game.board[i].moves = newMoves;
          }
        }
      }
      // if king has no moves and doublecheck, checkmate
      if(game.board[king].moves.length == 0 && doubleCheck)
      {
        game.state = "CHECKMATEWHITE";
      }
      // if none then checkmate
      if(gameSaveMoves.length == 0)
      {
        game.state = "CHECKMATEWHITE";
      }
    }
    else if(checkSaves.length == 0 && enPassantCheck.length > 0)
    {
      if(debugB) console.log ("EN PASSANT SAVE ONLY?");
      // if no checksaves, still might be en passant is an option
      let gameSaveMoves = [];
      
      for(let i = 0; i < game.board.length; i++)
      {
        // ignore anything not a pawn
        if(game.board[i].piece != "WP") continue;
        
        if(game.board[i].moves.length > 0)
        {
          // check if the piece is a pawn and can capture in the enPassantCheck array, in which case save those moves to re-add to moves array
          let saveEnPassant = [];
          if(enPassantCheck.length > 0)
          {
            for(let m = 0; m < game.board[i].moves.length; m++)
            {
              if(enPassantCheck.includes(game.board[i].moves[m]))
              {
                gameSaveMoves.push(game.board[i].moves[m]);
                saveEnPassant.push(game.board[i].moves[m]);
              }
            }
          }
          
          // if any saving en passant moves, replace pawns move array with them
          if(saveEnPassant.length > 0)
          {
            game.board[i].moves = [];
            for(let s = 0; s < saveEnPassant.length; s++) game.board[i].moves.push(saveEnPassant[s]);
          }
        }
      }
      
      // if king has no moves and doublecheck, checkmate
      if(game.board[king].moves.length == 0 && doubleCheck)
      {
        game.state = "CHECKMATEWHITE";
      }
      // if none then checkmate
      if(gameSaveMoves.length == 0)
      {
        game.state = "CHECKMATEWHITE";
      }
    }
    else
    {
      // if no checkmoves or en passant saves then must be checkmate
      game.state = "CHECKMATEWHITE";
    }
  }
  // black king in check
  if(!game.turn && game.board[king].targetedByWhite.length > 0)
  {
    game.state = "CHECKBLACK";
    // list of all squares that saves check, 
    let checkSaves = [];
    let checkLine = [];
    // if targetedbyWhite > 1, only escape is for king to move
    let doubleCheck = false;
    if(game.board[king].targetedByWhite.length > 1) doubleCheck = true;
    
    for(let i = 0; i < game.board[king].targetedByWhite.length; i++)
    {
      // get the square of the checking piece
      let checkingSquare = game.board[game.board[king].targetedByWhite[i]];
      // need to remove all squares from behind the king so doesn't escape check along it
      // if queen bishop or rook then need to add all squares along line between king and piece as checksaves
      // this will include the checking square
      if(checkingSquare.piece == "WR" || checkingSquare.piece == "WB" || checkingSquare.piece == "WQ")
      {
        checkSaves.push(GetCheckSaves(king, game.board[king].targetedByWhite[i], game));
        checkLine.push(GetCheckLine(king, game.board[king].targetedByWhite[i], game));
      }
      else
      {
        // can always save check by capturing the checking piece
        checkSaves.push(game.board[king].targetedByWhite[i]);
      }
    }

    if(checkLine.length > 0)
    {
      checkLine = checkLine.flat();
      let newKingMoves = [];
      for(let i = 0; i < game.board[king].moves.length; i++)
      {
        if(!checkLine.includes(game.board[king].moves[i])) newKingMoves.push(game.board[king].moves[i]);
      }
      game.board[king].moves = [];
      game.board[king].moves = newKingMoves;
    }
    checkSaves = checkSaves.flat();
    
    // check if the checking piece was a pawn which can be captured en passant, so other pawns can check if they can capture it in response
    let enPassantCheck = [];
    for(let i = 0; i < game.board[king].targetedByWhite.length; i++)
    {
      let checkingSquare = game.board[game.board[king].targetedByWhite[i]];
      //console.log(checkingSquare.piece);
      //console.log(checkingSquare.enPassant);
      if(checkingSquare.piece == "WP" && checkingSquare.enPassant > 0)
      {
        enPassantCheck.push(game.board[game.board[king].targetedByWhite[i]].down);
      }
    }
    //console.log(enPassantCheck);
    if(checkSaves.length > 0)
    {
      let gameSaveMoves = [];
      // once have checksave list, remove all moves that aren't on it
      for(let i = 0; i < game.board.length; i++)
      {
        if(game.board[i].piece == "-" || game.board[i].piece[0] == "W") continue;
        if(game.board[i].moves.length > 0)
        {
          // check if the piece is a pawn and can capture in the enPassantCheck array, in which case save those moves to re-add to moves array
          let saveEnPassant = [];
          if(game.board[i].piece == "BP" && enPassantCheck.length > 0)
          {
            for(let m = 0; m < game.board[i].moves.length; m++)
            {
              if(enPassantCheck.includes(game.board[i].moves[m]))
              {
                gameSaveMoves.push(game.board[i].moves[m]);
                saveEnPassant.push(game.board[i].moves[m]);
              }
            }
          }
          
          // if the piece is not the king, only keep moves that are in checksaves (i.e. block or capture only)
          if(game.board[i].piece != "BX")
          {
            if(!doubleCheck)
            {
              let newMoves = [];
              let oldMoves = game.board[i].moves.flat();
              for(let m = 0; m < oldMoves.length; m++)
              {
                if(checkSaves.includes(oldMoves[m]))
                {
                  newMoves.push(oldMoves[m]);
                  gameSaveMoves.push(oldMoves[m]);
                }
              }
              game.board[i].moves = [];
              game.board[i].moves = newMoves;
              if(saveEnPassant.length > 0) for(let s = 0; s < saveEnPassant.length; s++) game.board[i].moves.push(saveEnPassant[s]);
            }
          }
          else
          {
            // if the king piece, only add moves that arent in checksaves
            // except for if the king can capture the piece checking, and that piece isn't itself threatByWhite
            let newMoves = [];
            let oldMoves = game.board[i].moves.flat();
            for(let m = 0; m < oldMoves.length; m++)
            {
              // run away from check
              if(!checkSaves.includes(oldMoves[m]))
              {
                newMoves.push(oldMoves[m]);
                gameSaveMoves.push(oldMoves[m]);
              }
              // or capture the checking piece if it isn't itself targeted (can't capture into check)
              if(game.board[king].targetedByWhite.includes(oldMoves[m]))
              {
                if(game.board[oldMoves[m]].targetedByWhite.length == 0 && game.board[oldMoves[m]].piece != "-")
                {
                  gameSaveMoves.push(oldMoves[m]);
                  newMoves.push(oldMoves[m]);
                }
              }
            }
            game.board[i].moves = [];
            game.board[i].moves = newMoves;
          }
        }
      }
      // if king has no moves and doublecheck, checkmate
      if(game.board[king].moves.length == 0 && doubleCheck)
      {
        game.state = "CHECKMATEBLACK";
      }
      // if none then checkmate
      if(gameSaveMoves.length == 0)
      {
        game.state = "CHECKMATEBLACK";
      }
    }
    else if(checkSaves.length == 0 && enPassantCheck.length > 0)
    {
      // if no checksaves, still might be en passant is an option
      let gameSaveMoves = [];
      
      for(let i = 0; i < game.board.length; i++)
      {
        // ignore anything not a pawn
        if(game.board[i].piece != "BP") continue;
        
        if(game.board[i].moves.length > 0)
        {
          // check if the piece is a pawn and can capture in the enPassantCheck array, in which case save those moves to re-add to moves array
          let saveEnPassant = [];
          if(enPassantCheck.length > 0)
          {
            for(let m = 0; m < game.board[i].moves.length; m++)
            {
              if(enPassantCheck.includes(game.board[i].moves[m]))
              {
                gameSaveMoves.push(game.board[i].moves[m]);
                saveEnPassant.push(game.board[i].moves[m]);
              }
            }
          }
          
          // if any saving en passant moves, replace pawns move array with them
          if(saveEnPassant.length > 0)
          {
            game.board[i].moves = [];
            for(let s = 0; s < saveEnPassant.length; s++) game.board[i].moves.push(saveEnPassant[s]);
          }
        }
      }
      
      // if king has no moves and doublecheck, checkmate
      if(game.board[king].moves.length == 0 && doubleCheck)
      {
        game.state = "CHECKMATEWHITE";
      }
      // if none then checkmate
      if(gameSaveMoves.length == 0)
      {
        game.state = "CHECKMATEWHITE";
      }
    }
    else
    {
      // if no checkmoves or en passant saves then must be checkmate
      game.state = "CHECKMATEWHITE";
    }
  }
}

// if a piece has xray from other side, find the line and return if the king is on it
function FindXRayLine(king, targetedBy, game)
{
  let lineToCheck = [];
  if(game.board[king].leftLine.length > 0) if(game.board[king].leftLine.includes(targetedBy))
    lineToCheck = game.board[king].leftLine;
  if(game.board[king].rightLine.length > 0) if(game.board[king].rightLine.includes(targetedBy))
    lineToCheck = game.board[king].rightLine;
  if(game.board[king].downLine.length > 0) if(game.board[king].downLine.includes(targetedBy))
    lineToCheck = game.board[king].downLine;
  if(game.board[king].upLine.length > 0) if(game.board[king].upLine.includes(targetedBy))
    lineToCheck = game.board[king].upLine;
  if(game.board[king].upRightLine.length > 0) if(game.board[king].upRightLine.includes(targetedBy))
    lineToCheck = game.board[king].upRightLine;
  if(game.board[king].upLeftLine.length > 0) if(game.board[king].upLeftLine.includes(targetedBy))
    lineToCheck = game.board[king].upLeftLine;
  if(game.board[king].downRightLine.length > 0) if(game.board[king].downRightLine.includes(targetedBy))
    lineToCheck = game.board[king].downRightLine;
  if(game.board[king].downLeftLine.length > 0) if(game.board[king].downLeftLine.includes(targetedBy))
    lineToCheck = game.board[king].downLeftLine;
  return lineToCheck;
}

// finds the line that a checking piece is on, where pieces can therefore move to block
function GetCheckSaves(king, targetedBy, game)
{
  let lineToCheck = [];
  if(game.board[king].leftLine.length > 0) if(game.board[king].leftLine.includes(targetedBy))
    lineToCheck = game.board[king].leftLine;
  if(game.board[king].rightLine.length > 0) if(game.board[king].rightLine.includes(targetedBy))
    lineToCheck = game.board[king].rightLine;
  if(game.board[king].downLine.length > 0) if(game.board[king].downLine.includes(targetedBy))
    lineToCheck = game.board[king].downLine;
  if(game.board[king].upLine.length > 0) if(game.board[king].upLine.includes(targetedBy))
    lineToCheck = game.board[king].upLine;
  if(game.board[king].upRightLine.length > 0) if(game.board[king].upRightLine.includes(targetedBy))
    lineToCheck = game.board[king].upRightLine;
  if(game.board[king].upLeftLine.length > 0) if(game.board[king].upLeftLine.includes(targetedBy))
    lineToCheck = game.board[king].upLeftLine;
  if(game.board[king].downRightLine.length > 0) if(game.board[king].downRightLine.includes(targetedBy))
    lineToCheck = game.board[king].downRightLine;
  if(game.board[king].downLeftLine.length > 0) if(game.board[king].downLeftLine.includes(targetedBy))
    lineToCheck = game.board[king].downLeftLine;
  if(lineToCheck.length == 0) return;
  let result = [];
  for(let i = 0; i < lineToCheck.length; i++)
  {
    if(game.board[lineToCheck[i]].piece == "-") result.push(lineToCheck[i]);
    else
    {
      result.push(lineToCheck[i]);
      break;
    }
  }
  
  return result;
}

// gets the opposite check line to remove all squares from the king, so doesn't escape backwards along it
function GetCheckLine(king, targetedBy, game)
{
  let lineToCheck = [];
  if(game.board[king].leftLine.length > 0) if(game.board[king].leftLine.includes(targetedBy))
    if(game.board[king].rightLine.length > 0) lineToCheck = game.board[king].rightLine;
  if(game.board[king].rightLine.length > 0) if(game.board[king].rightLine.includes(targetedBy))
    if(game.board[king].leftLine.length > 0) lineToCheck = game.board[king].leftLine;
  
  if(game.board[king].downLine.length > 0) if(game.board[king].downLine.includes(targetedBy))
    if(game.board[king].upLine.length > 0) lineToCheck = game.board[king].upLine;
  if(game.board[king].upLine.length > 0) if(game.board[king].upLine.includes(targetedBy))
    if(game.board[king].downLine.length > 0) lineToCheck = game.board[king].downLine;
  
  if(game.board[king].upRightLine.length > 0) if(game.board[king].upRightLine.includes(targetedBy))
    if(game.board[king].downLeftLine.length > 0) lineToCheck = game.board[king].downLeftLine;
  if(game.board[king].upLeftLine.length > 0) if(game.board[king].upLeftLine.includes(targetedBy))
    if(game.board[king].downRightLine.length > 0) lineToCheck = game.board[king].downRightLine;
  
  if(game.board[king].downRightLine.length > 0) if(game.board[king].downRightLine.includes(targetedBy))
    if(game.board[king].upLeftLine.length > 0) lineToCheck = game.board[king].upLeftLine;
  if(game.board[king].downLeftLine.length > 0) if(game.board[king].downLeftLine.includes(targetedBy))
    if(game.board[king].upRightLine.length > 0) lineToCheck = game.board[king].upRightLine;
  
  if(lineToCheck.length == 0) return;
  return lineToCheck;
}

function GetSaveTurn(game, move, state)
{
  let newSave = new SaveTurn();
  newSave.turn = game.turn;
  newSave.move = move;
  newSave.state = state;
  newSave.board = [];
  
  for(let i = 0; i < game.board.length; i++)
  {
    let newSquare = new SaveSquare();
    newSquare.firstMove = game.board[i].firstMove;
    newSquare.enPassant = game.board[i].enPassant;
    newSquare.piece = game.board[i].piece;
    newSave.board.push(newSquare);
  }
  
  return newSave;
}

function GetHalMove(game)
{
  let result = [];
  
  // create a fake game
  // evaluate it
  // get all the pieces that can move for the players turn
  // for each of those pieces, go through each move and score it
  // order the scored moves by lowest for black, highest for white
  // pick the top % of moves and evaluate those boards
  // rinse and repeat for each of those boards
  // keep going till hit maximum depth
  // return the line with the best score
  
  // set the limit of how many moves ahead to search
  let depth = 0;
  let maxDepth = 10;
  
  // start with the actual game
  let fakeGames = [];
  let rankedMoves = [];
  let fakeGame = FakeGame(game, depth);
  let thisTurn = game.turn;
  EvaluateBoard(fakeGame);
  fakeGames.push(fakeGame);
  
  /*
  UpdateBoard(aiMove[0], aiMove[1], gArray[currentG].board, gArray[currentG]);
  gArray[currentG].turn = !gArray[currentG].turn;
  EvaluateBoard(gArray[currentG]);
  */
  
  let counter = 0;
  
  while (depth < maxDepth)
  {
    counter++;
    if(counter > 100) break;
    let gamesToAdd = [];
    // iterate over the fake games
    for(let i = 0; i < fakeGames.length; i++)
    {
      for(let m = 0; m < fakeGames[i].board.length; m++)
      {
        if(fakeGames[i].board[m].piece == "-") continue;
        if(fakeGames[i].turn == false && fakeGames[i].board[m].piece[0] == "W") continue;
        if(fakeGames[i].turn == true && fakeGames[i].board[m].piece[0] == "B") continue;
        
        let mArray = fakeGames[i].board[m].moves.flat();
        if(mArray.length > 0)
        {
          for(let r = 0; r < mArray.length; r++)
          {
            let fake3 = FakeGame(fakeGames[i], depth + 1);
            let newMove1 = [[fakeGames[i].board[m].index, fake3.board[fakeGames[i].board[m].index].piece], [mArray[r], fake3.board[mArray[r]].piece]];
            let sArray1 = GetSaveTurn(fake3, newMove1, fake3.state);
            fake3.saveList.push(sArray1);
            UpdateBoard(fakeGames[i].board[m].index, mArray[r], fake3.board, fake3);
            fake3.score = ScoreMove(fake3.board);
            fake3.turn = !fake3.turn;
            EvaluateBoard(fake3);
            gamesToAdd.push(fake3);
          }
        }
      }
    }
    fakeGames = [];
    fakeGames = gamesToAdd;
    fakeGames = SortScore(fakeGames, thisTurn);
    thisTurn = !thisTurn;
    if(fakeGames.length > 10) fakeGames.length = 10;
    depth++;
  }
  
  //console.log(fakeGames);
  /*
  for(let i = 0; i < fakeGames.length; i++)
  {
    console.log("SAVEGAME: " + i);
    for(let s = 0; s < fakeGames[i].saveList.length; s++)
    {
      if(fakeGames[i].saveList[s].move.length > 1){
        console.log(fakeGames[i].saveList[s].move[0][0] + fakeGames[i].saveList[s].move[0][1]);
        console.log("to");
        console.log(fakeGames[i].saveList[s].move[1][0] + fakeGames[i].saveList[s].move[1][1]);
      }
    }
  }
  */

  if(fakeGames.length > 0)
  {
    // HIGHEST SCORE PICK
    // 1 = the piece to move
    result.push(fakeGames[0].saveList[gArray[currentG].currentMove + 1].move[0][0]);
    // 2 = where to move it to
    result.push(fakeGames[0].saveList[gArray[currentG].currentMove + 1].move[1][0]);
    return result;
  }
  else return [-1, -1];
}

function FakeGame(game, depth)
{
  let fake = new Game();
  fake.turn = game.turn;
  fake.fifty = game.fifty;
  fake.state = game.state;
  fake.board = [];
  // stores the move history
  fake.saveList = [];
  for(let i = 0; i < game.saveList.length; i++)
  {
    fake.saveList.push(game.saveList[i]);
  }
  fake.depth = depth;
  fake.score = 0;
  
  for(let i = 0; i < game.board.length; i++)
  {
    let nSquare = new Square();
    nSquare.index = game.board[i].index;
    nSquare.col = game.board[i].col;
    nSquare.row = game.board[i].row;
    nSquare.white = game.board[i].white;
    
    nSquare.up = game.board[i].up;
    nSquare.down = game.board[i].down;
    nSquare.left = game.board[i].left;
    nSquare.right = game.board[i].right;
    
    nSquare.upLeft = game.board[i].upLeft;
    nSquare.upRight = game.board[i].upRight;
    nSquare.downLeft = game.board[i].downLeft;
    nSquare.downRight = game.board[i].downRight;
    
    nSquare.kUpRight = game.board[i].kUpRight;
    nSquare.kUpLeft = game.board[i].kUpLeft;
    nSquare.kLeftUp = game.board[i].kLeftUp;
    nSquare.kLeftDown = game.board[i].kLeftDown;
    
    nSquare.kDownRight = game.board[i].kDownRight;
    nSquare.kDownLeft = game.board[i].kDownLeft;
    nSquare.kRightUp = game.board[i].kRightUp;
    nSquare.kRightDown = game.board[i].kRightDown;
    
    nSquare.leftLine = game.board[i].leftLine;
    nSquare.rightLine = game.board[i].rightLine;
    nSquare.upLine = game.board[i].upLine;
    nSquare.downLine = game.board[i].downLine;
    
    nSquare.upRightLine = game.board[i].upRightLine;
    nSquare.upLeftLine = game.board[i].upLeftLine;
    nSquare.downRightLine = game.board[i].downRightLine;
    nSquare.downLeftLine = game.board[i].downLeftLine;
    
    nSquare.firstMove = game.board[i].firstMove;
    nSquare.enPassant = game.board[i].enPassant;
    nSquare.piece = game.board[i].piece;
    nSquare.moves = [];
    
    nSquare.targetedByWhite = [];
    nSquare.targetedByBlack = [];
    nSquare.xRayWhite = [];
    nSquare.xRayBlack = [];
    fake.board.push(nSquare);
  }
  return fake;
}

function ScoreMove(board)
{
  let score = ScoreBoard(board);
  let score2 = ScorePosition(board);
  let total = score + score2;
  return total;
}

function ScoreBoard(board)
{
  let score = 0;
  for(let i = 0; i < board.length; i++)
  {
    if(board[i].piece == "-") continue;
    
    if(board[i].piece == "WP") score += 100;
    if(board[i].piece == "WR") score += 500;
    if(board[i].piece == "WB") score += 300;
    if(board[i].piece == "WK") score += 300;
    if(board[i].piece == "WQ") score += 900;
    if(board[i].piece == "WX") score += 1000000;
    
    if(board[i].piece == "BP") score -= 100;
    if(board[i].piece == "BR") score -= 500;
    if(board[i].piece == "BB") score -= 300;
    if(board[i].piece == "BK") score -= 300;
    if(board[i].piece == "BQ") score -= 900;
    if(board[i].piece == "BX") score -= 1000000;
  }
  return score;
}

function ScorePosition(board, game)
{
  let score = 0;
  for(let i = 0; i < board.length; i++)
  {
    if(board[i].piece == "-") continue;
    
    if(board[i].piece == "WP") { score += pawnValueWhite[board[i].index]; };
    if(board[i].piece == "WR") { score += rookValueWhite[board[i].index]; };
    if(board[i].piece == "WB") { score += bishopValueWhite[board[i].index]; };
    if(board[i].piece == "WK") { score += knightValueWhite[board[i].index]; };
    if(board[i].piece == "WQ") { score += queenValueWhite[board[i].index]; };
    if(board[i].piece == "WX") { score += kingValueWhite[board[i].index]; };
    
    if(board[i].piece == "BP") { score -= pawnValueBlack[board[i].index]; };
    if(board[i].piece == "BR") { score -= rookValueBlack[board[i].index]; };
    if(board[i].piece == "BB") { score -= bishopValueBlack[board[i].index]; };
    if(board[i].piece == "BK") { score -= knightValueBlack[board[i].index]; };
    if(board[i].piece == "BQ") { score -= queenValueBlack[board[i].index]; };
    if(board[i].piece == "BX") { score -= kingValueBlack[board[i].index]; };
  }
  return score;
}

function SortScore(array, turn)
{
  array.sort(function(a, b)
  {
    if(turn)
    {
        return parseInt(a.score) - parseInt(b.score);
    }
    else
    {
        return parseInt(b.score) - parseInt(a.score);
    }
  });
  return array;
}

function ConvertArray(array)
{
  let aLength = array.length;
  
  //console.log(array);
  //console.log(aLength);
  
  let result = [];
  
  for(let i = 0; i < aLength; i++)
  {
    //console.log(result);
    // movelist of the game
    let moveList = array[i][0];
    //console.log(moveList);
    // how many turns in the game (black + white = 1 turn)
    let moveLength = moveList.length;
    // game result
    let winner = array[i][1];
    
    let metaInfo = array[i][1];
    //console.log(metaInfo);
    
    let eventPos = metaInfo.search("Event");
    let sitePos = metaInfo.search("Site");
    let datePos = metaInfo.search("Date");
    let roundPos = metaInfo.search("Round");
    let whitePos = metaInfo.search("White");
    let blackPos = metaInfo.search("Black");
    let resultPos = metaInfo.search("Result");
    
    let eventString = metaInfo.substring(eventPos, sitePos);
    let eventOne = eventString.indexOf(`"`);
    eventString = eventString.substring(eventOne + 1);
    let eventTwo = eventString.indexOf(`"`);
    eventString = eventString.substring(0, eventTwo);
    
    let siteString = metaInfo.substring(sitePos, datePos);
    let siteOne = siteString.indexOf(`"`);
    siteString = siteString.substring(siteOne + 1);
    let siteTwo = siteString.indexOf(`"`);
    siteString = siteString.substring(0, siteTwo);
    
    let dateString = metaInfo.substring(datePos, roundPos);
    let dateOne = dateString.indexOf(`"`);
    dateString = dateString.substring(dateOne + 1);
    let dateTwo = dateString.indexOf(`"`);
    dateString = dateString.substring(0, dateTwo);
    
    let roundString = metaInfo.substring(roundPos, whitePos);
    let roundOne = roundString.indexOf(`"`);
    roundString = roundString.substring(roundOne + 1);
    let roundTwo = roundString.indexOf(`"`);
    roundString = roundString.substring(0, roundTwo);
    
    let whiteString = metaInfo.substring(whitePos, blackPos);
    dateOne = whiteString.indexOf(`"`);
    whiteString = whiteString.substring(dateOne + 1);
    dateTwo = whiteString.indexOf(`"`);
    whiteString = whiteString.substring(0, dateTwo);
    
    let blackString = metaInfo.substring(blackPos, resultPos);
    dateOne = blackString.indexOf(`"`);
    blackString = blackString.substring(dateOne + 1);
    dateTwo = blackString.indexOf(`"`);
    blackString = blackString.substring(0, dateTwo);
    
    let resultString = metaInfo.substring(resultPos);
    dateOne = resultString.indexOf(`"`);
    resultString = resultString.substring(dateOne + 1);
    dateTwo = resultString.indexOf(`"`);
    resultString = resultString.substring(0, dateTwo);
    
    if(debugB) console.log("GAME NUMBER " + i);
    if(debugB) console.log(eventString);
    if(debugB) console.log(siteString);
    if(debugB) console.log(dateString);
    if(debugB) console.log(roundString);
    if(debugB) console.log(whiteString);
    if(debugB) console.log(blackString);
    if(debugB) console.log(resultString);
    
    //dateString.replace(/^\s*\n/gm, "");
    //whiteString.replace(/^\s*\n/gm, "");
    //blackString.replace(/^\s*\n/gm, "");
    
    // output of board states
    let boardStateList = [];
    // set a new game to start manipulating
    let fakeGame = GetFakeGame();

    // save the initial game state and -1-1 to reflect start of the game so no prior move
    let thisMoveBoard1 = GetPieceArray(fakeGame);
    let move = [-1, -1 ];
    boardStateList.push([move, thisMoveBoard1]);
    
    // for each turn in the game
    for(let m = 0; m < moveLength; m++)
    {
      // for each move in the turn (2, white then black, unless black didn't go)
      //console.log(moveList[m]);
      for(let n = 0; n < moveList[m].length; n++)
      {
        if(moveList[m][n] == -1)
        {
          /*
          let thisMoveBoard = GetPieceArray(fakeGame);
          let move = [-1, -1];
          boardStateList.push([move, thisMoveBoard]);
          fakeGame.turn = !fakeGame.turn;
          EvaluateBoard(fakeGame);
          */
          continue;
        }
        // the information to identify the piece - piece type and board position
        let pieceToMove = moveList[m][n][0];
        if(debugB) console.log("BREAK");
        if(debugB) console.log("move is " + [m]);
        if(debugB) console.log("piece to move is " + moveList[m][n][0]);
        if(debugB) console.log("target square is " + moveList[m][n][1]);
        // where the piece is moving to converted into 0-63 index number
        let moveTo = ToIndex(moveList[m][n][0], moveList[m][n][1]);
        if(debugB) console.log("MOVETO IS " + moveTo);
        if(debugB) console.log(moveList[m][n][0]);
        if(debugB) console.log(moveList[m][n][1]);
        
        // shortcut promotion
        if(moveList[m][n][1][0] == "=")
        {
          if(debugB) console.log("PROMOTION HERE " + moveList[m][n][0].length);
          if(debugB) console.log("PROMOTE TO " + moveList[m][n][1]);
          let promoteToPiece = moveList[m][n][1][1];
          if(promoteToPiece == "N") promoteToPiece = "K";
          if(debugB) console.log("PROMOTE TO PIECE " + promoteToPiece);
          if(moveList[m][n][0].length == 2)
          {
            let indexPromote = ToIndex("P", moveList[m][n][0]);
            if(debugB) console.log(indexPromote);
            let possiblePieces1 = [];

            for(let p = 0; p < fakeGame.board.length; p++)
            {
              if(fakeGame.board[p].piece[1] != "P") continue;
              // avoid black pieces if white move
              if(n == 0) if(fakeGame.board[p].piece[0] == "B") continue;
              // avoid white pieces if black move
              if(n == 1) if(fakeGame.board[p].piece[0] == "W") continue;
              
              let movesToCheck4 = fakeGame.board[p].moves.flat();
              if(movesToCheck4.includes(indexPromote))
              {
                possiblePieces1.push(p);
              }
            }
            
            if(debugB) console.log(possiblePieces1);
            
            if(debugB) console.log("pLength is " + possiblePieces1.length);
            if(possiblePieces1.length > 0)
            {
              UpdateBoard(possiblePieces1[0], indexPromote, fakeGame.board, fakeGame, promoteToPiece);
              let thisMoveBoard3 = GetPieceArray(fakeGame);
              let move4 = [possiblePieces1[0], indexPromote];
              boardStateList.push([move4, thisMoveBoard3]);
    
              let debugArray = GetDebugArray(fakeGame);
              if(debugB) console.log(debugArray);
              fakeGame.turn = !fakeGame.turn;
              fakeGame.state = "";
              EvaluateBoard(fakeGame);
              continue;
            }
          }
          if(moveList[m][n][0].length == 4)
          {
            let promoteTo = moveList[m][n][0][2] + moveList[m][n][0][3];
            if(debugB) console.log(promoteTo);
            let indexPromote = ToIndex("P", promoteTo);
            if(debugB) console.log(indexPromote);
            let possiblePieces1 = [];

            for(let p = 0; p < fakeGame.board.length; p++)
            {
              if(fakeGame.board[p].piece[1] != "P") continue;
              // avoid black pieces if white move
              if(n == 0) if(fakeGame.board[p].piece[0] == "B") continue;
              // avoid white pieces if black move
              if(n == 1) if(fakeGame.board[p].piece[0] == "W") continue;
              
              let movesToCheck4 = fakeGame.board[p].moves.flat();
              if(movesToCheck4.includes(indexPromote))
              {
                possiblePieces1.push(p);
              }
            }
            
            if(debugB) console.log(possiblePieces1);
            
            if(debugB) console.log("pLength is " + possiblePieces1.length);
            if(possiblePieces1.length > 0)
            {
              UpdateBoard(possiblePieces1[0], indexPromote, fakeGame.board, fakeGame, promoteToPiece);
              let thisMoveBoard3 = GetPieceArray(fakeGame);
              let move4 = [possiblePieces1[0], indexPromote];
              boardStateList.push([move4, thisMoveBoard3]);
    
              let debugArray = GetDebugArray(fakeGame);
              if(debugB) console.log(debugArray);
              fakeGame.turn = !fakeGame.turn;
              fakeGame.state = "";
              EvaluateBoard(fakeGame);
              continue;
            }
          }
        }
        
        // shortcut castling as hardcoded
        // white
        if(n == 0)
        {
          // kingside
          if(moveTo == "O-O")
          {
            UpdateBoard(4, 6, fakeGame.board, fakeGame);
            let thisMoveBoard = GetPieceArray(fakeGame);
            let move = [4, 6];
            boardStateList.push([move, thisMoveBoard]);
  
            fakeGame.turn = !fakeGame.turn;
            fakeGame.state = "";
            EvaluateBoard(fakeGame);
            continue;
          }
          // queenside
          if(moveTo == "O-O-O")
          {
            UpdateBoard(4, 2, fakeGame.board, fakeGame);
            let thisMoveBoard = GetPieceArray(fakeGame);
            let move = [4, 2];
            boardStateList.push([move, thisMoveBoard]);
  
            fakeGame.turn = !fakeGame.turn;
            fakeGame.state = "";
            EvaluateBoard(fakeGame);
            continue;
          }
        }
        // black
        if(n == 1)
        {
          // kingside
          if(moveTo == "O-O")
          {
            UpdateBoard(60, 62, fakeGame.board, fakeGame);
            let thisMoveBoard = GetPieceArray(fakeGame);
            let move = [60, 62];
            boardStateList.push([move, thisMoveBoard]);
  
            fakeGame.turn = !fakeGame.turn;
            fakeGame.state = "";
            EvaluateBoard(fakeGame);
            continue;
          }
          // queenside
          if(moveTo == "O-O-O")
          {
            UpdateBoard(60, 58, fakeGame.board, fakeGame);
            let thisMoveBoard = GetPieceArray(fakeGame);
            let move = [60, 58];
            boardStateList.push([move, thisMoveBoard]);
  
            fakeGame.turn = !fakeGame.turn;
            fakeGame.state = "";
            EvaluateBoard(fakeGame);
            continue;
          }
        }
        
        
        // used to identify the piece to move
        let possiblePieces = [];

        for(let p = 0; p < fakeGame.board.length; p++)
        {
          if(fakeGame.board[p].piece == "-") continue;
          // avoid black pieces if white move
          if(n == 0) if(fakeGame.board[p].piece[0] == "B") continue;
          // avoid white pieces if black move
          if(n == 1) if(fakeGame.board[p].piece[0] == "W") continue;
          
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
          e.g ax = a column pawn capture - ignore the x just move the pawn
          Bx = bishop is capturing, can also ignore the x
          Ba = Bishop on a column a to move (assuming another bishop will also have moves to target square
          Bac = Bishop on column a and row c (assuming multiple bishops on column a)        
          */
          
          // if 1 piece length info then normal piece move
          if(pieceToMove.length == 1)
          {
            if(pieceToMove[0] === "P" && fakeGame.board[p].piece[1] != "P") continue;
            if(pieceToMove[0] === "R" && fakeGame.board[p].piece[1] != "R") continue;
            if(pieceToMove[0] === "N" && fakeGame.board[p].piece[1] != "K") continue;
            if(pieceToMove[0] === "B" && fakeGame.board[p].piece[1] != "B") continue;
            if(pieceToMove[0] === "Q" && fakeGame.board[p].piece[1] != "Q") continue;
            if(pieceToMove[0] === "K" && fakeGame.board[p].piece[1] != "X") continue;

            let movesToCheck = fakeGame.board[p].moves.flat();
            if(movesToCheck.includes(moveTo))
            {
              possiblePieces.push(p);
            }
          }
          else if(pieceToMove.length > 1)
          {
            if(debugB) console.log(pieceToMove);
            // either there is an x to show piece capture, or notation to distinguish same piece type that can move to square
            if(pieceToMove[1] == "x")
            {
              // if a pawn move capture then ensure the pawn is from the right column and is a pawn
              if(pieceToMove[0] === "a" || pieceToMove[0] === "b" || pieceToMove[0] === "c" || pieceToMove[0] === "d" || pieceToMove[0] === "e" || 
                 pieceToMove[0] === "f" || pieceToMove[0] === "g" || pieceToMove[0] === "h")
              {
                let column = GetColumn(pieceToMove[0]);
                if(debugB) console.log("COLUMN IS " + column);

                let movesToCheck = fakeGame.board[p].moves.flat();
                if(fakeGame.board[p].col == column && fakeGame.board[p].piece[1] == "P" && movesToCheck.includes(moveTo))
                {
                  if(debugB) console.log(fakeGame.board[p]);
                  possiblePieces.push(p);
                }
              }
              else
              {
                // otherwise just treat like a normal piece move
                if(pieceToMove[0] === "P" && fakeGame.board[p].piece[1] != "P") continue;
                if(pieceToMove[0] === "R" && fakeGame.board[p].piece[1] != "R") continue;
                if(pieceToMove[0] === "N" && fakeGame.board[p].piece[1] != "K") continue;
                if(pieceToMove[0] === "B" && fakeGame.board[p].piece[1] != "B") continue;
                if(pieceToMove[0] === "Q" && fakeGame.board[p].piece[1] != "Q") continue;
                if(pieceToMove[0] === "K" && fakeGame.board[p].piece[1] != "X") continue;
                
                let movesToCheck = fakeGame.board[p].moves.flat();
                if(movesToCheck.includes(moveTo))
                {
                  possiblePieces.push(p);
                }
              }
            }
            else
            {
              // if 2nd letter isn't x, then it must be piece specification information
              // for cases where the column is specified first
              if(pieceToMove[1] === "a" || pieceToMove[1] === "b" || pieceToMove[1] === "c" || pieceToMove[1] === "d" || pieceToMove[1] === "e" || 
                 pieceToMove[1] === "f" || pieceToMove[1] === "g" || pieceToMove[1] === "h")
              {
                  
                  if(pieceToMove[0] === "P" && fakeGame.board[p].piece[1] != "P") continue;
                  if(pieceToMove[0] === "R" && fakeGame.board[p].piece[1] != "R") continue;
                  if(pieceToMove[0] === "N" && fakeGame.board[p].piece[1] != "K") continue;
                  if(pieceToMove[0] === "B" && fakeGame.board[p].piece[1] != "B") continue;
                  if(pieceToMove[0] === "Q" && fakeGame.board[p].piece[1] != "Q") continue;
                  if(pieceToMove[0] === "K" && fakeGame.board[p].piece[1] != "X") continue;
                
                  let column = GetColumn(pieceToMove[1]);
                  if(debugB) console.log("FIND PIECE AT COL " + column);
                  // see if there is a 2nd specification, which would be the row
                  let row = -1;
                  if(pieceToMove[2] != null)
                  {
                    let row = GetRow(pieceToMove[2]);
                    if(debugB) console.log("FIND PIECE AT ROW " + row);
                  }
                  // if no row info
                  if(row == -1)
                  {
                    // use just col data
                    let movesToCheck = fakeGame.board[p].moves.flat();
                    if(fakeGame.board[p].col == column && movesToCheck.includes(moveTo))
                    {
                      if(debugB) console.log("ADDING PIECE: ");
                      if(debugB) console.log(fakeGame.board[p]);
                      possiblePieces.push(p);
                    }
                  }
                  else
                  {
                    // use both row and col data
                    let movesToCheck = fakeGame.board[p].moves.flat();
                    if(fakeGame.board[p].row == row && fakeGame.board[p].col == column && movesToCheck.moves.includes(moveTo))
                    {
                      possiblePieces.push(p);
                    }
                  }
              }
              if(pieceToMove[1] === "1" || pieceToMove[1] === "2" || pieceToMove[1] === "3" || pieceToMove[1] === "4" || pieceToMove[1] === "5" || 
                 pieceToMove[1] === "6" || pieceToMove[1] === "7" || pieceToMove[1] === "8")
                {
                  
                  if(pieceToMove[0] === "P" && fakeGame.board[p].piece[1] != "P") continue;
                  if(pieceToMove[0] === "R" && fakeGame.board[p].piece[1] != "R") continue;
                  if(pieceToMove[0] === "N" && fakeGame.board[p].piece[1] != "K") continue;
                  if(pieceToMove[0] === "B" && fakeGame.board[p].piece[1] != "B") continue;
                  if(pieceToMove[0] === "Q" && fakeGame.board[p].piece[1] != "Q") continue;
                  if(pieceToMove[0] === "K" && fakeGame.board[p].piece[1] != "X") continue;
                
                  let row = GetRow(pieceToMove[1]);
                  if(debugB) console.log("FIND PIECE AT ROW " + row);
                  // see if there is a 2nd specification, which would be the row
                  let column = -1;
                  if(pieceToMove[2] != null)
                  {
                    let column = GetColumn(pieceToMove[2]);
                    if(debugB) console.log("FIND PIECE AT COL " + column);
                  }
                  // if no row info
                  if(column == -1)
                  {
                    // use just col data
                    let movesToCheck = fakeGame.board[p].moves.flat();
                    if(fakeGame.board[p].row == row && movesToCheck.includes(moveTo))
                    {
                      if(debugB) console.log("ADDING PIECE: ");
                      if(debugB) console.log(fakeGame.board[p]);
                      possiblePieces.push(p);
                    }
                  }
                  else
                  {
                    // use both row and col data
                    let movesToCheck = fakeGame.board[p].moves.flat();
                    if(fakeGame.board[p].row == row && fakeGame.board[p].col == column && movesToCheck.moves.includes(moveTo))
                    {
                      possiblePieces.push(p);
                    }
                  }
                }
              }
            }
          }

          let pLength = possiblePieces.length;
          if(debugB) console.log("pLength is " + pLength);
          if(pLength > 0)
          {
            UpdateBoard(possiblePieces[0], moveTo, fakeGame.board, fakeGame);
            let thisMoveBoard = GetPieceArray(fakeGame);
            let move = [possiblePieces[0], moveTo];
            boardStateList.push([move, thisMoveBoard]);
  
            let debugArray = GetDebugArray(fakeGame);
            if(debugB) console.log(debugArray);
            fakeGame.turn = !fakeGame.turn;
            fakeGame.state = "";
            EvaluateBoard(fakeGame);
          }
          else
          {
            /*
            for(let p = 0; p < fakeGame.board.length; p++)
            {
              if(fakeGame.board[p].piece[1] == moveList[m][n][0])
              {
                //console.log("THIS PIECE EXISTS AT " + p);
              }
            }
            let debugArray = GetDebugArray(fakeGame);
            console.log(debugArray);
            */
          }
        }
      }
      // once completed every move in the game, add to result
      //let game = [boardStateList, winner, dateString, whiteString, blackString];
      let game = [boardStateList, winner, eventString, siteString, dateString, roundString, whiteString, blackString, resultString];
      result.push(game);
    }
    
  //console.log(result);
  return result;
}

function GetColumn(input)
{
  let col = 0;
  
  switch(input)
  {
    case "a":
      col = 0;
      break;
    case "b":
      col = 1;
      break;
    case "c":
      col = 2;
      break;
    case "d":
      col = 3;
      break;
    case "e":
      col = 4;
      break;
    case "f":
      col = 5;
      break;
    case "g":
      col = 6;
      break;
    case "h":
      col = 7;
      break;
    default: col = 0;
  }
  return col;
}


function GetRow(input)
{
  let col = 0;
  
  switch(input)
  {
    case "1":
      col = 0;
      break;
    case "2":
      col = 1;
      break;
    case "3":
      col = 2;
      break;
    case "4":
      col = 3;
      break;
    case "5":
      col = 4;
      break;
    case "6":
      col = 5;
      break;
    case "7":
      col = 6;
      break;
    case "8":
      col = 7;
      break;
    default: col = 0;
  }
  return col;
}

function GetFakeGame()
{  
  let newG = new Game();
  newG.turn = true;
  newG.whiteAI = false;
  newG.blackAI = false;
  newG.board = [];
  newG.saveList = [];
  
  let alternate = false;
  let counter = 0;
  
  for(let x = 0; x < 8; x++)
  {
    alternate = !alternate;
    for(let y = 0; y < 8; y++)
    {
      alternate = !alternate;
      let newSquare = new Square();
      FindIndex(counter, newSquare);
      newG.board.push(newSquare);
      newSquare.piece = "-";
      newSquare.firstMove = true;
      newSquare.moves = [];
      newSquare.white = alternate;
      newSquare.enPassant = 0;
      counter++;
    }
  }
  
  for(let i = 0; i < 64; i++)
  {
    newG.board[i].upLine = GetLine(i, "up", newG.board);
    newG.board[i].downLine = GetLine(i, "down", newG.board);
    
    newG.board[i].leftLine = GetLine(i, "left", newG.board);
    newG.board[i].rightLine = GetLine(i, "right", newG.board);
    
    newG.board[i].upRightLine = GetLine(i, "upRight", newG.board);
    newG.board[i].upLeftLine = GetLine(i, "upLeft", newG.board);
    
    newG.board[i].downRightLine = GetLine(i, "downRight", newG.board);
    newG.board[i].downLeftLine = GetLine(i, "downLeft", newG.board);
  }
  
  newG.board[0].piece = "WR";
  newG.board[1].piece = "WK";
  newG.board[2].piece = "WB";
  newG.board[3].piece = "WQ";
  newG.board[4].piece = "WX";
  newG.board[5].piece = "WB";
  newG.board[6].piece = "WK";
  newG.board[7].piece = "WR";

  let i = 8;
  
  for(i; i < 16; i++)
  {
    newG.board[i].firstMove = true;
    newG.board[i].piece = "WP";
  }
  
  let empty = (4 * 8) + 16;
  
  for(i; i < empty; i++)
  {
    newG.board[i].piece = "-";
  }
  
  let bPawn = i + 8;
  
  for(i; i < bPawn; i++)
  {
    newG.board[i].firstMove = true;
    newG.board[i].piece = "BP";
  }
  
  newG.board[56].piece = "BR";
  newG.board[57].piece = "BK";
  newG.board[58].piece = "BB";
  newG.board[59].piece = "BQ";
  newG.board[60].piece = "BX";
  newG.board[61].piece = "BB";
  newG.board[62].piece = "BK";
  newG.board[63].piece = "BR";
  
  let nLen = newG.board.length;
  
  for(i = 0; i < nLen; i++)
  {
    newG.board[i].moves = [];
    newG.board[i].targetedByWhite = [];
    newG.board[i].targetedByBlack = [];
    newG.board[i].xRayWhite = [];
    newG.board[i].xRayBlack = [];
  }
  
  for(i = 0; i < nLen; i++)
  {
    let piece = newG.board[i].piece; 
    if(piece == "WP" || piece == "BP") newG.board[i].moves = FindMovesPawn(i, newG.board);
    if(piece == "WR" || piece == "BR") newG.board[i].moves = FindMovesRook(i, newG.board);
    if(piece == "WK" || piece == "BK") newG.board[i].moves = FindMovesKnight(i, newG.board);
    if(piece == "WB" || piece == "BB") newG.board[i].moves = FindMovesBishops(i, newG.board);
    if(piece == "WQ" || piece == "BQ") newG.board[i].moves = FindMovesQueen(i, newG.board);
    if(piece == "WX" || piece == "BX") newG.board[i].moves = FindMovesKing(i, newG.board);
  }
  
  let newMove = [0];
  let sArray = GetSaveTurn(newG, newMove, newG.state);
  //console.log(newG);
  return newG;
}

function ToIndex(piece, index)
{
  if(index === "-1" || index == undefined) return;
  if(piece === "X" && index == "O-O") return "O-O";
  if(piece === "X" && index == "O-O-O") return "O-O-O";
  let row = 0;
  let col = 0;
  
  //console.log(piece + " / " + index);
  
  switch(index[0])
  {
    case "a":
      col = 0;
      break;
    case "b":
      col = 1;
      break;
    case "c":
      col = 2;
      break;
    case "d":
      col = 3;
      break;
    case "e":
      col = 4;
      break;
    case "f":
      col = 5;
      break;
    case "g":
      col = 6;
      break;
    case "h":
      col = 7;
      break;
    default: col = 0;
  }
  switch(index[1])
  {
    case "1":
      row = 0;
      break;
    case "2":
      row = 1;
      break;
    case "3":
      row = 2;
      break;
    case "4":
      row = 3;
      break;
    case "5":
      row = 4;
      break;
    case "6":
      row = 5;
      break;
    case "7":
      row = 6;
      break;
    case "8":
      row = 7;
      break;
    default: row = 0;
  }
  let result = (row * 8) + col;
  return result;
}


function GetBoardStart()
{
  let result = [];
  
  result.push("WR");
  result.push("WK");
  result.push("WB");
  result.push("WQ");
  result.push("WX");
  result.push("WB");
  result.push("WK");
  result.push("WR");
  
  let i = 8;
  
  for(i; i < 16; i++)
  {
    result.push("WP");
  }
  
  let empty = (4 * 8) + 16;
  
  for(i; i < empty; i++)
  {
    result.push("-");
  }
  
  let bPawn = i + 8;
  
  for(i; i < bPawn; i++)
  {
    result.push("BP");
  }
  
  result.push("BR");
  result.push("BK");
  result.push("BB");
  result.push("BQ");
  result.push("BX");
  result.push("BB");
  result.push("BK");
  result.push("BR");
  
  return result;
}

function GetDebugArray(game)
{
  let result = [];
  for(let i = 0; i < game.board.length; i++)
  {
    let entry = [];
    entry.push(game.board[i].piece, game.board[i].enPassant, game.board[i].firstMove,
    game.board[i].moves, game.board[i].targetedByWhite , game.board[i].targetedByBlack,
    game.board[i].xRayWhite,game.board[i].xRayBlack);
    result.push(entry);
  }
  return result;
}

function ConvertArrayPGN(array)
{
  let aLength = array.length;
  
  if(debugB) console.log(array);
  if(debugB) console.log(aLength);
  
  let result = [];
  
  for(let i = 0; i < aLength; i++)
  {
    if(debugB) console.log(array[i]);
    //array[i].replace(/\//g, "");
    let rawPGN = array[i];
    
    let eventPos = rawPGN.search("Event");
    let sitePos = rawPGN.search("Site");
    let datePos = rawPGN.search("Date");
    let roundPos = rawPGN.search("Round");
    let whitePos = rawPGN.search("White");
    let blackPos = rawPGN.search("Black");
    let resultPos = rawPGN.search("Result");
    let gamePos = rawPGN.lastIndexOf("]");
    
    let eventString = rawPGN.substring(eventPos, sitePos);
    let eventOne = eventString.indexOf(`"`);
    eventString = eventString.substring(eventOne + 1);
    let eventTwo = eventString.indexOf(`"`);
    eventString = eventString.substring(0, eventTwo);
    
    let siteString = rawPGN.substring(sitePos, datePos);
    let siteOne = siteString.indexOf(`"`);
    siteString = siteString.substring(siteOne + 1);
    let siteTwo = siteString.indexOf(`"`);
    siteString = siteString.substring(0, siteTwo);
    
    let dateString = rawPGN.substring(datePos, roundPos);
    let dateOne = dateString.indexOf(`"`);
    dateString = dateString.substring(dateOne + 1);
    let dateTwo = dateString.indexOf(`"`);
    dateString = dateString.substring(0, dateTwo);
    
    let roundString = rawPGN.substring(roundPos, whitePos);
    let roundOne = roundString.indexOf(`"`);
    roundString = roundString.substring(roundOne + 1);
    let roundTwo = roundString.indexOf(`"`);
    roundString = roundString.substring(0, roundTwo);
    
    let whiteString = rawPGN.substring(whitePos, blackPos);
    dateOne = whiteString.indexOf(`"`);
    whiteString = whiteString.substring(dateOne + 1);
    dateTwo = whiteString.indexOf(`"`);
    whiteString = whiteString.substring(0, dateTwo);
    
    let blackString = rawPGN.substring(blackPos, resultPos);
    dateOne = blackString.indexOf(`"`);
    blackString = blackString.substring(dateOne + 1);
    dateTwo = blackString.indexOf(`"`);
    blackString = blackString.substring(0, dateTwo);
    
    let resultString = rawPGN.substring(resultPos, gamePos);
    dateOne = resultString.indexOf(`"`);
    resultString = resultString.substring(dateOne + 1);
    dateTwo = resultString.indexOf(`"`);
    resultString = resultString.substring(0, dateTwo);
    
    let gameString = rawPGN.substring(gamePos + 1);
    
    if(debugB) console.log("GAME NUMBER " + i);
    if(debugB) console.log(eventString);
    if(debugB) console.log(siteString);
    if(debugB) console.log(dateString);
    if(debugB) console.log(roundString);
    if(debugB) console.log(whiteString);
    if(debugB) console.log(blackString);
    if(debugB) console.log(resultString);
    if(debugB) console.log(gameString);
    
    let turnList = gameString.split(".");
    let newTurnList = [];
    let tLength = turnList.length;
    
    for(let t = 1; t < tLength; t++)
    {
      let moveList = turnList[t].split(" ");
      let newMoveList = [];
      for(let m = 0; m < moveList.length; m++)
      {
        if(moveList[m] != "")
        {
          newMoveList.push(moveList[m]);
          if(newMoveList.length >= 2) break;
        }
      }
      turnList[t] = newMoveList;
      newTurnList.push(turnList[t]);
    }
    
    if(debugB) console.log(newTurnList);
    
    
    let game = [newTurnList, eventString, siteString, dateString, roundString, whiteString, blackString, resultString, rawPGN];
    result.push(game);
  }
  //console.log(result);
  return result;
}

function GameToPGN(data)
{
  //console.log(data);
  let moveList = data[0];
  //console.log(moveList);
  AddNewGame();
  currentG = gArray.length - 1;
  gArray[currentG].eventT = data[1];
  gArray[currentG].siteT = data[2];
  gArray[currentG].dateT = data[3];
  gArray[currentG].roundT = data[4];
  gArray[currentG].whiteT = data[5];
  gArray[currentG].blackT = data[6];
  gArray[currentG].resultT = data[7];
  gArray[currentG].gameT = data[0];
  //console.log(gArray[currentG]);
  // parse into piece and move
  for(let m = 0; m < moveList.length; m++)
  {
    //console.log(moveList[m]);
    let whiteData = moveList[m][0];
    let blackData = moveList[m][1];
    
    let whitePiece = "";
    let whiteMove = "";
    let blackPiece = "";
    let blackMove = "";
    
    if(whiteData != "1-0" && whiteData != "0-1" && whiteData != "*" && whiteData != "1/2-1/2")
    {
      if(whiteData == "O-O" || whiteData == "O-O-O")
      {
        whiteMove = whiteData;
        whitePiece = "X";
      }
      else
      {
        whitePiece = moveList[m][0].substr(0, moveList[m][0].length - 2);
        whiteMove = moveList[m][0].substr(moveList[m][0].length - 2);
        if(!whitePiece.includes("R") && !whitePiece.includes("N") && !whitePiece.includes("B") && !whitePiece.includes("Q") && !whitePiece.includes("K"))
        {
          whitePiece = "P" + whitePiece;
        }
        if(whitePiece == "") whitePiece = "P";
      }
    }
    
    if(blackData != "1-0" && blackData != "0-1" && blackData != "*" && blackData != "1/2-1/2")
    {
      if(blackData == "O-O" || blackData == "O-O-O")
      {
        blackMove = blackData;
        blackPiece = "X";
      }
      else
      {
        blackPiece = moveList[m][1].substr(0, moveList[m][1].length - 2);
        blackMove = moveList[m][1].substr(moveList[m][1].length - 2);
        if(!blackPiece.includes("R") && !blackPiece.includes("N") && !blackPiece.includes("B") && !blackPiece.includes("Q") && !blackPiece.includes("K"))
        {
          blackPiece = "P" + blackPiece;
        }
        if(blackPiece == "") blackPiece = "P";
      }
    }

    let newMoves = [ [whitePiece, whiteMove] , [blackPiece, blackMove] ];
    moveList[m] = newMoves;
  }
  
  // for each turn in the game
  for(let m = 0; m < moveList.length; m++)
  {
    // for each move in the turn (2, white then black, unless black didn't go)
    //console.log(moveList[m]);
    for(let n = 0; n < moveList[m].length; n++)
    {
      if(moveList[m][n] == "1-0" || moveList[m][n] == "0-1" || moveList[m][n] == "1/2-1/2" || moveList[m][n] == "*" )
      {
        continue;
      }
      
      // the information to identify the piece - piece type and board position
      let pieceToMove = moveList[m][n][0];
      if(debugB) console.log("BREAK");
      if(debugB) console.log("move is " + [m]);
      if(debugB) console.log("piece to move is " + moveList[m][n][0]);
      if(debugB) console.log("target square is " + moveList[m][n][1]);
      // where the piece is moving to converted into 0-63 index number
      let moveTo = ToIndex(moveList[m][n][0], moveList[m][n][1]);
      if(debugB) console.log("MOVETO IS " + moveTo);
      if(debugB) console.log(moveList[m][n][0]);
      if(debugB) console.log(moveList[m][n][1]);
      
      // shortcut promotion
      if(moveList[m][n][1][0] == "=")
      {
        if(debugB) console.log("PROMOTION HERE " + moveList[m][n][0].length);
        if(debugB) console.log("PROMOTE TO " + moveList[m][n][1]);
        let promoteToPiece = moveList[m][n][1][1];
        if(promoteToPiece == "N") promoteToPiece = "K";
        if(debugB) console.log("PROMOTE TO PIECE " + promoteToPiece);
        if(moveList[m][n][0].length == 2)
        {
          let indexPromote = ToIndex("P", moveList[m][n][0]);
          if(debugB) console.log(indexPromote);
          let possiblePieces1 = [];

          for(let p = 0; p < gArray[currentG].board.length; p++)
          {
            if(gArray[currentG].board[p].piece[1] != "P") continue;
            // avoid black pieces if white move
            if(n == 0) if(gArray[currentG].board[p].piece[0] == "B") continue;
            // avoid white pieces if black move
            if(n == 1) if(gArray[currentG].board[p].piece[0] == "W") continue;
            
            let movesToCheck4 = gArray[currentG].board[p].moves.flat();
            if(movesToCheck4.includes(indexPromote))
            {
              possiblePieces1.push(p);
            }
          }
          
          if(debugB) console.log(possiblePieces1);
          
          if(debugB) console.log("pLength is " + possiblePieces1.length);
          if(possiblePieces1.length > 0)
          {
            UpdateBoard(possiblePieces1[0], indexPromote, gArray[currentG].board, gArray[currentG], promoteToPiece);
            let thisMoveBoard3 = GetPieceArray(gArray[currentG]);
            let move4 = [possiblePieces1[0], indexPromote];
            
            //boardStateList.push([move4, thisMoveBoard3]);
            // save the move
            // UpdateBoard(from, to, board, game, promoteTo)
            let newMove = [[possiblePieces1[0], gArray[currentG].board[possiblePieces1[0]].piece], [indexPromote, gArray[currentG].board[indexPromote].piece]];
            let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
            gArray[currentG].saveList.push(sArray);
  
            let debugArray = GetDebugArray(gArray[currentG]);
            if(debugB) console.log(debugArray);
            gArray[currentG].turn = !gArray[currentG].turn;
            gArray[currentG].state = "";
            EvaluateBoard(gArray[currentG]);
            continue;
          }
        }
        if(moveList[m][n][0].length == 4)
        {
          let promoteTo = moveList[m][n][0][2] + moveList[m][n][0][3];
          if(debugB) console.log(promoteTo);
          let indexPromote = ToIndex("P", promoteTo);
          if(debugB) console.log(indexPromote);
          let possiblePieces1 = [];

          for(let p = 0; p < gArray[currentG].board.length; p++)
          {
            if(gArray[currentG].board[p].piece[1] != "P") continue;
            // avoid black pieces if white move
            if(n == 0) if(gArray[currentG].board[p].piece[0] == "B") continue;
            // avoid white pieces if black move
            if(n == 1) if(gArray[currentG].board[p].piece[0] == "W") continue;
            
            let movesToCheck4 = gArray[currentG].board[p].moves.flat();
            if(movesToCheck4.includes(indexPromote))
            {
              possiblePieces1.push(p);
            }
          }
          
          if(debugB) console.log(possiblePieces1);
          
          if(debugB) console.log("pLength is " + possiblePieces1.length);
          if(possiblePieces1.length > 0)
          {
            UpdateBoard(possiblePieces1[0], indexPromote, gArray[currentG].board, gArray[currentG], promoteToPiece);
            let thisMoveBoard3 = GetPieceArray(gArray[currentG]);
            let move4 = [possiblePieces1[0], indexPromote];
            
            //boardStateList.push([move4, thisMoveBoard3]);
            // save the move
            // UpdateBoard(from, to, board, game, promoteTo)
            let newMove = [[possiblePieces1[0], gArray[currentG].board[possiblePieces1[0]].piece], [indexPromote, gArray[currentG].board[indexPromote].piece]];
            let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
            gArray[currentG].saveList.push(sArray);
  
            let debugArray = GetDebugArray(gArray[currentG]);
            if(debugB) console.log(debugArray);
            gArray[currentG].turn = !gArray[currentG].turn;
            gArray[currentG].state = "";
            EvaluateBoard(gArray[currentG]);
            continue;
          }
        }
      }
      
      // shortcut castling as hardcoded
      // white
      if(n == 0)
      {
        // kingside
        if(moveTo == "O-O")
        {
          UpdateBoard(4, 6, gArray[currentG].board, gArray[currentG]);
          let thisMoveBoard = GetPieceArray(gArray[currentG]);
          let move = [4, 6];
          
          //boardStateList.push([move, thisMoveBoard]);
          // save the move
          // UpdateBoard(from, to, board, game, promoteTo)
          let newMove = [[4, gArray[currentG].board[4].piece], [6, gArray[currentG].board[6].piece]];
          let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
          gArray[currentG].saveList.push(sArray);

          gArray[currentG].turn = !gArray[currentG].turn;
          gArray[currentG].state = "";
          EvaluateBoard(gArray[currentG]);
          continue;
        }
        // queenside
        if(moveTo == "O-O-O")
        {
          UpdateBoard(4, 2, gArray[currentG].board, gArray[currentG]);
          let thisMoveBoard = GetPieceArray(gArray[currentG]);
          let move = [4, 2];
          
          //boardStateList.push([move, thisMoveBoard]);
          // save the move
          // UpdateBoard(from, to, board, game, promoteTo)
          let newMove = [[4, gArray[currentG].board[4].piece], [2, gArray[currentG].board[2].piece]];
          let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
          gArray[currentG].saveList.push(sArray);

          gArray[currentG].turn = !gArray[currentG].turn;
          gArray[currentG].state = "";
          EvaluateBoard(gArray[currentG]);
          continue;
        }
      }
      // black
      if(n == 1)
      {
        // kingside
        if(moveTo == "O-O")
        {
          UpdateBoard(60, 62, gArray[currentG].board, gArray[currentG]);
          let thisMoveBoard = GetPieceArray(gArray[currentG]);
          let move = [60, 62];
          
          //boardStateList.push([move, thisMoveBoard]);
          // save the move
          // UpdateBoard(from, to, board, game, promoteTo)
          let newMove = [[60, gArray[currentG].board[60].piece], [62, gArray[currentG].board[62].piece]];
          let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
          gArray[currentG].saveList.push(sArray);

          gArray[currentG].turn = !gArray[currentG].turn;
          gArray[currentG].state = "";
          EvaluateBoard(gArray[currentG]);
          continue;
        }
        // queenside
        if(moveTo == "O-O-O")
        {
          UpdateBoard(60, 58, gArray[currentG].board, gArray[currentG]);
          let thisMoveBoard = GetPieceArray(gArray[currentG]);
          let move = [60, 58];
          //boardStateList.push([move, thisMoveBoard]);
          // save the move
          // UpdateBoard(from, to, board, game, promoteTo)
          let newMove = [[60, gArray[currentG].board[60].piece], [58, gArray[currentG].board[58].piece]];
          let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
          gArray[currentG].saveList.push(sArray);

          gArray[currentG].turn = !gArray[currentG].turn;
          gArray[currentG].state = "";
          EvaluateBoard(gArray[currentG]);
          continue;
        }
      }
      
      
      // used to identify the piece to move
      let possiblePieces = [];

      for(let p = 0; p < gArray[currentG].board.length; p++)
      {
        if(gArray[currentG].board[p].piece == "-") continue;
        // avoid black pieces if white move
        if(n == 0) if(gArray[currentG].board[p].piece[0] == "B") continue;
        // avoid white pieces if black move
        if(n == 1) if(gArray[currentG].board[p].piece[0] == "W") continue;
        
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
        e.g ax = a column pawn capture - ignore the x just move the pawn
        Bx = bishop is capturing, can also ignore the x
        Ba = Bishop on a column a to move (assuming another bishop will also have moves to target square
        Bac = Bishop on column a and row c (assuming multiple bishops on column a)        
        */
        
        // if 1 piece length info then normal piece move
        if(pieceToMove.length == 1)
        {
          if(pieceToMove[0] === "P" && gArray[currentG].board[p].piece[1] != "P") continue;
          if(pieceToMove[0] === "R" && gArray[currentG].board[p].piece[1] != "R") continue;
          if(pieceToMove[0] === "N" && gArray[currentG].board[p].piece[1] != "K") continue;
          if(pieceToMove[0] === "B" && gArray[currentG].board[p].piece[1] != "B") continue;
          if(pieceToMove[0] === "Q" && gArray[currentG].board[p].piece[1] != "Q") continue;
          if(pieceToMove[0] === "K" && gArray[currentG].board[p].piece[1] != "X") continue;

          let movesToCheck = gArray[currentG].board[p].moves.flat();
          if(movesToCheck.includes(moveTo))
          {
            possiblePieces.push(p);
          }
        }
        else if(pieceToMove.length > 1)
        {
          if(debugB) console.log(pieceToMove);
          // either there is an x to show piece capture, or notation to distinguish same piece type that can move to square
          if(pieceToMove[1] == "x")
          {
            // if a pawn move capture then ensure the pawn is from the right column and is a pawn
            if(pieceToMove[0] === "a" || pieceToMove[0] === "b" || pieceToMove[0] === "c" || pieceToMove[0] === "d" || pieceToMove[0] === "e" || 
               pieceToMove[0] === "f" || pieceToMove[0] === "g" || pieceToMove[0] === "h")
            {
              let column = GetColumn(pieceToMove[0]);
              if(debugB) console.log("COLUMN IS " + column);

              let movesToCheck = gArray[currentG].board[p].moves.flat();
              if(gArray[currentG].board[p].col == column && gArray[currentG].board[p].piece[1] == "P" && movesToCheck.includes(moveTo))
              {
                if(debugB) console.log(gArray[currentG].board[p]);
                possiblePieces.push(p);
              }
            }
            else
            {
              // otherwise just treat like a normal piece move
              if(pieceToMove[0] === "P" && gArray[currentG].board[p].piece[1] != "P") continue;
              if(pieceToMove[0] === "R" && gArray[currentG].board[p].piece[1] != "R") continue;
              if(pieceToMove[0] === "N" && gArray[currentG].board[p].piece[1] != "K") continue;
              if(pieceToMove[0] === "B" && gArray[currentG].board[p].piece[1] != "B") continue;
              if(pieceToMove[0] === "Q" && gArray[currentG].board[p].piece[1] != "Q") continue;
              if(pieceToMove[0] === "K" && gArray[currentG].board[p].piece[1] != "X") continue;
              
              let movesToCheck = gArray[currentG].board[p].moves.flat();
              if(movesToCheck.includes(moveTo))
              {
                possiblePieces.push(p);
              }
            }
          }
          else
          {
            // if 2nd letter isn't x, then it must be piece specification information
            // for cases where the column is specified first
            if(pieceToMove[1] === "a" || pieceToMove[1] === "b" || pieceToMove[1] === "c" || pieceToMove[1] === "d" || pieceToMove[1] === "e" || 
               pieceToMove[1] === "f" || pieceToMove[1] === "g" || pieceToMove[1] === "h")
            {
                
                if(pieceToMove[0] === "P" && gArray[currentG].board[p].piece[1] != "P") continue;
                if(pieceToMove[0] === "R" && gArray[currentG].board[p].piece[1] != "R") continue;
                if(pieceToMove[0] === "N" && gArray[currentG].board[p].piece[1] != "K") continue;
                if(pieceToMove[0] === "B" && gArray[currentG].board[p].piece[1] != "B") continue;
                if(pieceToMove[0] === "Q" && gArray[currentG].board[p].piece[1] != "Q") continue;
                if(pieceToMove[0] === "K" && gArray[currentG].board[p].piece[1] != "X") continue;
              
                let column = GetColumn(pieceToMove[1]);
                if(debugB) console.log("FIND PIECE AT COL " + column);
                // see if there is a 2nd specification, which would be the row
                let row = -1;
                if(pieceToMove[2] != null)
                {
                  let row = GetRow(pieceToMove[2]);
                  if(debugB) console.log("FIND PIECE AT ROW " + row);
                }
                // if no row info
                if(row == -1)
                {
                  // use just col data
                  let movesToCheck = gArray[currentG].board[p].moves.flat();
                  if(gArray[currentG].board[p].col == column && movesToCheck.includes(moveTo))
                  {
                    if(debugB) console.log("ADDING PIECE: ");
                    if(debugB) console.log(gArray[currentG].board[p]);
                    possiblePieces.push(p);
                  }
                }
                else
                {
                  // use both row and col data
                  let movesToCheck = gArray[currentG].board[p].moves.flat();
                  if(gArray[currentG].board[p].row == row && gArray[currentG].board[p].col == column && movesToCheck.moves.includes(moveTo))
                  {
                    possiblePieces.push(p);
                  }
                }
            }
            if(pieceToMove[1] === "1" || pieceToMove[1] === "2" || pieceToMove[1] === "3" || pieceToMove[1] === "4" || pieceToMove[1] === "5" || 
               pieceToMove[1] === "6" || pieceToMove[1] === "7" || pieceToMove[1] === "8")
              {
                
                if(pieceToMove[0] === "P" && gArray[currentG].board[p].piece[1] != "P") continue;
                if(pieceToMove[0] === "R" && gArray[currentG].board[p].piece[1] != "R") continue;
                if(pieceToMove[0] === "N" && gArray[currentG].board[p].piece[1] != "K") continue;
                if(pieceToMove[0] === "B" && gArray[currentG].board[p].piece[1] != "B") continue;
                if(pieceToMove[0] === "Q" && gArray[currentG].board[p].piece[1] != "Q") continue;
                if(pieceToMove[0] === "K" && gArray[currentG].board[p].piece[1] != "X") continue;
              
                let row = GetRow(pieceToMove[1]);
                if(debugB) console.log("FIND PIECE AT ROW " + row);
                // see if there is a 2nd specification, which would be the row
                let column = -1;
                if(pieceToMove[2] != null)
                {
                  let column = GetColumn(pieceToMove[2]);
                  if(debugB) console.log("FIND PIECE AT COL " + column);
                }
                // if no row info
                if(column == -1)
                {
                  // use just col data
                  let movesToCheck = gArray[currentG].board[p].moves.flat();
                  if(gArray[currentG].board[p].row == row && movesToCheck.includes(moveTo))
                  {
                    if(debugB) console.log("ADDING PIECE: ");
                    if(debugB) console.log(gArray[currentG].board[p]);
                    possiblePieces.push(p);
                  }
                }
                else
                {
                  // use both row and col data
                  let movesToCheck = gArray[currentG].board[p].moves.flat();
                  if(gArray[currentG].board[p].row == row && gArray[currentG].board[p].col == column && movesToCheck.moves.includes(moveTo))
                  {
                    possiblePieces.push(p);
                  }
                }
              }
            }
          }
        }

        let pLength = possiblePieces.length;
        if(debugB) console.log("pLength is " + pLength);
        if(pLength > 0)
        {
          UpdateBoard(possiblePieces[0], moveTo, gArray[currentG].board, gArray[currentG]);
          let thisMoveBoard = GetPieceArray(gArray[currentG]);
          let move = [possiblePieces[0], moveTo];
          
          //boardStateList.push([move, thisMoveBoard]);
          // save the move
          // UpdateBoard(from, to, board, game, promoteTo)
          let newMove = [[possiblePieces[0], gArray[currentG].board[possiblePieces[0]].piece], [moveTo, gArray[currentG].board[moveTo].piece]];
          let sArray = GetSaveTurn(gArray[currentG], newMove, gArray[currentG].state);
          gArray[currentG].saveList.push(sArray);

          let debugArray = GetDebugArray(gArray[currentG]);
          if(debugB) console.log(debugArray);
          gArray[currentG].turn = !gArray[currentG].turn;
          gArray[currentG].state = "";
          EvaluateBoard(gArray[currentG]);
        }
      }
    }
}