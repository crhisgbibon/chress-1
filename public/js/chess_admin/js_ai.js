"use strict";

onmessage = function(event) {
  
  let query = JSON.parse(event.data);
  
  if(query[0] == "HALMOVE")
  {
    GetMove();
    return;
  }
}

function GetMove()
{
  let header = "HALMOVE";
  let moves = gArray[currentG].board[index].moves;
  
  let r = [header, moves];
  let rString = JSON.stringify(r);
  postMessage(rString);
}