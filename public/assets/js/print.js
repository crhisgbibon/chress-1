"use strict";

export function Print(response)
{
  if(response.currentMoves && response.currentMoves.length !== 0)
  {
    let moves = response.currentMoves;
    console.log(moves);
    for(let i = 0; i < 64; i++)
    {
      let bb = document.getElementById('b' + i);
      if(moves.includes(i)) bb.dataset.move = 'yes';
      else bb.dataset.move = 'no';
    }
  }
  else
  {
    for(let i = 0; i < 64; i++)
    {
      let bb = document.getElementById('b' + i);
      bb.dataset.move = 'no';
    }
  }

  if(response.board && response.board.length === 64)
  {
    let board = response.board;
    for(let i = 0; i < 64; i++)
    {
      let boardImg = document.getElementById('i' + i);
      if(board[i][1] === 'WP') boardImg.src = 'assets/png/whitePawn.png';
      else if(board[i][1] === 'WR') boardImg.src = 'assets/png/whiteRook.png';
      else if(board[i][1] === 'WK') boardImg.src = 'assets/png/whiteKnight.png';
      else if(board[i][1] === 'WB') boardImg.src = 'assets/png/whiteBishop.png';
      else if(board[i][1] === 'WQ') boardImg.src = 'assets/png/whiteQueen.png';
      else if(board[i][1] === 'WX') boardImg.src = 'assets/png/whiteKing.png';
      else if(board[i][1] === '-') boardImg.src = '';
      else if(board[i][1] === 'BP') boardImg.src = 'assets/png/blackPawn.png';
      else if(board[i][1] === 'BR') boardImg.src = 'assets/png/blackRook.png';
      else if(board[i][1] === 'BK') boardImg.src = 'assets/png/blackKnight.png';
      else if(board[i][1] === 'BB') boardImg.src = 'assets/png/blackBishop.png';
      else if(board[i][1] === 'BQ') boardImg.src = 'assets/png/blackQueen.png';
      else if(board[i][1] === 'BX') boardImg.src = 'assets/png/blackKing.png';
      else boardImg.src = '';
    }
  }
}

export default Print