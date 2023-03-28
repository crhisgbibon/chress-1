"use strict";

let debug = true;

function Post(trigger, data)
{
  data.push(document.querySelector('input[name="promote"]:checked').id);
  let jsonData = JSON.stringify(data);
  if(debug) console.log(trigger);
  if(debug) console.log(data);
  $.ajax(
  {
    method: "POST",
    url: '/games/' + trigger,
    data:
    {
      data:jsonData
    },
    timeout: 10000,
    success:function(json)
    {
      if(debug) console.log(json);
      let result = JSON.parse(json);
      if(debug) console.log(result);
      Print(result);
    },
    error:function(json)
    {
      if(debug) console.log(json);
      let result = JSON.parse(json);
      if(debug) console.log(result);
      Print(result);
    }
  });
}

function Print(response)
{
  let moves = response.currentMoves;
  if(debug)  console.log(moves);
  for(let i = 0; i < 64; i++)
  {
    let bb = document.getElementById('b' + i);
    if(moves.includes(i)) bb.dataset.move = 'yes';
    else bb.dataset.move = 'no';
  }

  moves = response.lastmove;
  if(debug) console.log(moves);
  for(let i = 0; i < 64; i++)
  {
    let bb = document.getElementById('b' + i);
    if(moves.includes(i)) bb.dataset.last = 'yes';
    else bb.dataset.last = 'no';
  }

  let board = response.board;
  for(let i = 0; i < 64; i++)
  {
    let boardImg = document.getElementById('i' + i);
    if(board[i][1] === 'WP') boardImg.src = '../assets/png/whitePawn.png';
    else if(board[i][1] === 'WR') boardImg.src = '../assets/png/whiteRook.png';
    else if(board[i][1] === 'WK') boardImg.src = '../assets/png/whiteKnight.png';
    else if(board[i][1] === 'WB') boardImg.src = '../assets/png/whiteBishop.png';
    else if(board[i][1] === 'WQ') boardImg.src = '../assets/png/whiteQueen.png';
    else if(board[i][1] === 'WX') boardImg.src = '../assets/png/whiteKing.png';
    else if(board[i][1] === '-') boardImg.src = '';
    else if(board[i][1] === 'BP') boardImg.src = '../assets/png/blackPawn.png';
    else if(board[i][1] === 'BR') boardImg.src = '../assets/png/blackRook.png';
    else if(board[i][1] === 'BK') boardImg.src = '../assets/png/blackKnight.png';
    else if(board[i][1] === 'BB') boardImg.src = '../assets/png/blackBishop.png';
    else if(board[i][1] === 'BQ') boardImg.src = '../assets/png/blackQueen.png';
    else if(board[i][1] === 'BX') boardImg.src = '../assets/png/blackKing.png';
    else boardImg.src = '';
  }

  moves = document.getElementById('moves');
  moves.innerHTML = response.pgn;

  let info = document.getElementById('info');
  info.innerHTML = '';
  Object.entries(response.meta).forEach(
    ([key, value]) => {
      info.innerHTML += `<div class='rounded-lg bg-sky-50 m-2 p-2'>` + key + ` : ` + value + `</div>`;
      if(debug)  console.log(key, value);
    }
  );

  if(response.moveNum)
  {
    let counter = document.getElementById('counter');
    if(counter !== null) counter.innerHTML = response.moveNum[0] + ' / ' + (response.moveNum[1] - 1);
  }

  let screenHalf = document.getElementById('bar').scrollWidth / 2;
  let bar_range = document.getElementById('bar_range');
  let perCent = 0;

  perCent = ( 100 / screenHalf ) * Math.abs(response.score);

  if(response.score > 0) bar_range.style.width = ( screenHalf + perCent ) + "px";
  else bar_range.style.width = ( screenHalf - perCent ) + "px";

  console.log(perCent);
  console.log(bar_range.style.width);
}

function Post2()
{
  let data = {
    turn:document.querySelector('input[name="turn"]:checked').id,
    opponent:document.querySelector('input[name="opponent"]:checked').id,
    colour:document.querySelector('input[name="colour"]:checked').id,
  };
  let jsonData = JSON.stringify(data);
  if(debug) console.log(data);
  if(debug) console.log(jsonData);
  $.ajax(
  {
    method: "POST",
    url: '/games/create',
    data:
    {
      data:jsonData
    },
    timeout: 10000,
    success:function(result)
    {
      if(debug) console.log(result);
      document.getElementById('games').innerHTML = result;
    },
    error:function(result)
    {
      if(debug) console.log(result);
    }
  });
}