"use strict";

function CalculateVh()
{
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', vh + 'px');
  Square();
}

function Square()
{
  let board = document.getElementById('board');
  if(board === null) return;
  let screenWidth = parseInt(board.scrollWidth);
  let screenHeight = parseInt(board.scrollHeight);
  let squareSize;
  
  if(screenWidth >= screenHeight) squareSize = screenHeight;
  else squareSize = screenWidth;

  squareSize *= 0.9;
  squareSize /= 8;
  squareSize = parseInt(squareSize);

  document.documentElement.style.setProperty('--square', squareSize + 'px');
}

window.addEventListener('DOMContentLoaded', CalculateVh);
window.addEventListener('resize', CalculateVh);
window.addEventListener('orientationchange', CalculateVh);