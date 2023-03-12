"use strict";

const newGameButton = document.getElementById("newGameButton");
newGameButton.setAttribute("onclick", "NewGame()");

const lastMoveButton = document.getElementById("lastMoveButton");
lastMoveButton.setAttribute("onclick", "LastMove()");
const currentMoveDiv = document.getElementById("currentMoveDiv");
const nextMoveButton = document.getElementById("nextMoveButton");
nextMoveButton.setAttribute("onclick", "NextMove()");

const aiButton = document.getElementById("aiButton");
aiButton.setAttribute("onclick", "ToggleAI()");

const lastGameButton = document.getElementById("lastGameButton");
lastGameButton.setAttribute("onclick", "LastGame()");
const currentGameDiv = document.getElementById("currentGameDiv");
const nextGameButton = document.getElementById("nextGameButton");
nextGameButton.setAttribute("onclick", "NextGame()");

const flipButton = document.getElementById("flipButton");
flipButton.setAttribute("onclick", "ToggleFlip()");

const saveToPGNLibraryButton = document.getElementById("saveToPGNLibraryButton");
saveToPGNLibraryButton.setAttribute("onclick", "SaveToSQL2()");

//const getFromPGNLibraryButton = document.getElementById("getFromPGNLibraryButton");
//getFromPGNLibraryButton.setAttribute("onclick", "GetFromSQL()");

const iPlay = document.getElementById("iPlay");
const iInfo = document.getElementById("iInfo");
const iTheme = document.getElementById("iTheme");

const bodyDiv = document.getElementById("bodyDiv");
const boardDiv = document.getElementById("boardDiv");
const interfaceDiv = document.getElementById("interfaceDiv");

const uploadedFileSelect = document.getElementById("uploadedFileSelect");

const startNumber = document.getElementById("startNumber");
const endNumber = document.getElementById("endNumber");

let boardB = [];
let boardI = [];

let lastClicked = 0;
let canMoveTo = [];

let storePGN = [];
let pgnCounter = 0;
let pgnMove = 0;

let w = new Worker("js_worker.js");
w.onmessage = Response;

let toggleTheme = true;

let flip = false;

if(localStorage.chessTheme)
{
  toggleTheme = localStorage.chessTheme;
  UpdateTheme(toggleTheme);
}

function ToggleTheme()
{
  toggleTheme = !toggleTheme;
  UpdateTheme(toggleTheme);
}

function UpdateTheme(state)
{
  let r = document.querySelector(':root');
  let rs = getComputedStyle(r);
  
  if (typeof(Storage) !== "undefined")
  {
    localStorage.setItem("chessTheme", state);
  }
  
  if(state)
  {
    r.style.setProperty('--backEnd', 'rgba(250, 250, 240, 1)');
    r.style.setProperty('--frontEnd', 'rgba(50, 50, 60, 1)');
    
    r.style.setProperty('--disabled', 'rgba(225, 225, 215, 1)');
    r.style.setProperty('--active', 'rgba(200, 200, 190, 1)');
    r.style.setProperty('--selected', 'rgba(150, 150, 140, 1)');
    
    iPlay.src = "play-button-oLight.svg";
    iInfo.src = "infoLight.svg";
    iTheme.src = "dark-modeLight.svg";
  }
  else
  {
    r.style.setProperty('--backEnd', 'rgba(50, 50, 60, 1)');
    r.style.setProperty('--frontEnd', 'rgba(250, 250, 240, 1)');
    
    r.style.setProperty('--disabled', 'rgba(75, 75, 85, 1)');
    r.style.setProperty('--active', 'rgba(100, 100, 110, 1)');
    r.style.setProperty('--selected', 'rgba(150, 150, 160, 1)');
    
    iPlay.src = "play-button-o.svg";
    iInfo.src = "info.svg";
    iTheme.src = "dark-mode.svg";
  }
}

function CalculateVh()
{
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', vh + 'px');
  
  if((window.innerHeight * 0.925) >= window.innerWidth)
  {
    if(bodyDiv.style.flexDirection != "column") bodyDiv.style.flexDirection = "column";
    boardDiv.style.width = "100vw";
    boardDiv.style.height = "100vw";
    
    interfaceDiv.style.width = "100vw";
    interfaceDiv.style.height = "calc( (var(--vh) * 92.5) - 100vw";
    
    interfaceDiv.style.maxHeight = "400px";
    interfaceDiv.style.maxWidth = "";
  }
  else
  {
    if(bodyDiv.style.flexDirection != "row") bodyDiv.style.flexDirection = "row";
    boardDiv.style.width = "calc(var(--vh) * 92.5)";
    boardDiv.style.height = "calc(var(--vh) * 92.5)";
    
    interfaceDiv.style.width = "calc(100vw - calc(var(--vh) * 92.5))";
    interfaceDiv.style.height = "calc(var(--vh) * 92.5)";
    
    interfaceDiv.style.maxHeight = "";
    interfaceDiv.style.maxWidth = "400px";
  }
}

function SetBoard()
{
  boardDiv.innerHTML = "";
  
  let counter = 0;
  let rowCounter = 7;
  let colCounter = 0;
  let alternate = false;
  
  for(let x = 0; x < 8; x++)
  {
    alternate = !alternate;
    for(let y = 0; y < 8; y++)
    {
      alternate = !alternate;
      
      let newSquare = document.createElement("DIV");
      let newButton = document.createElement("BUTTON");
      let newImg = document.createElement("IMG");
      newImg.src = "blank.png";
      newButton.appendChild(newImg);
      newSquare.appendChild(newButton);
      boardDiv.appendChild(newSquare);
      
      newSquare.className = "boardSquare";
      newButton.className = "boardButton";
      newImg.className = "boardImg";
      
      newSquare.id = "s" + ((rowCounter * 8) + colCounter);
      newButton.id = "b" + ((rowCounter * 8) + colCounter);
      newImg.id = "i" + ((rowCounter * 8) + colCounter);
      newButton.dataset.index = ((rowCounter * 8) + colCounter);
      
      newButton.setAttribute("onclick", "QuerySquare(" + newButton.dataset.index + ")");
      
      if(alternate)
      {
        newButton.dataset.color = "white";
      }
      else
      {
        newButton.dataset.color = "black";
      }
      
      colCounter++;
      counter++;
    }
    rowCounter--;
    colCounter = 0;
  }
  
  boardB.length = 0;
  boardI.length = 0;
  
  for(let i = 0; i < 64; i++)
  {
    let b = document.getElementById("b" + i);
    boardB.push(b);
    let im = document.getElementById("i" + i);
    boardI.push(im);
  }

  NewGame();
}

function FillBoard(bitBoard)
{
  let aLen = bitBoard.length;
  
  for(let i = 0; i < aLen; i++)
  {
    boardB[i].dataset.state = "";
    
    if(bitBoard[i] == "-") boardI[i].src = "blank.png";
    if(bitBoard[i] == "WP") boardI[i].src = "whitePawn.png";
    if(bitBoard[i] == "BP") boardI[i].src = "blackPawn.png";
    if(bitBoard[i] == "WR") boardI[i].src = "whiteRook.png";
    if(bitBoard[i] == "BR") boardI[i].src = "blackRook.png";
    if(bitBoard[i] == "WK") boardI[i].src = "whiteKnight.png";
    if(bitBoard[i] == "BK") boardI[i].src = "blackKnight.png";
    if(bitBoard[i] == "WB") boardI[i].src = "whiteBishop.png";
    if(bitBoard[i] == "BB") boardI[i].src = "blackBishop.png";
    if(bitBoard[i] == "WQ") boardI[i].src = "whiteQueen.png";
    if(bitBoard[i] == "BQ") boardI[i].src = "blackQueen.png";
    if(bitBoard[i] == "WX") boardI[i].src = "whiteKing.png";
    if(bitBoard[i] == "BX") boardI[i].src = "blackKing.png";
  }
}

function Query(data)
{
  let query = JSON.stringify(data);
  w.postMessage(query);
}

function Response(event)
{
  let response = JSON.parse(event.data);
  //console.log(response);
  
  if(response[0] === "NEWGAME" || response[0] === "NEXTGAME" || response[0] === "LASTGAME")
  {
    //console.log(response);
    if(response[1] != null) FillBoard(response[1]);
    if(response[2] != null && response[3] != null) currentGameDiv.innerHTML = (response[2] + 1) + "/" + response[3];
    if(response[4] != null && response[5] != null) currentMoveDiv.innerHTML = (response[4]) + "/" + (response[5] - 1);
    
    if(response[6] != null) FillInterface(response[6]);
    if(response[7] != null) FillMoveList(response[7]);
  }
  if(response[0] === "SHOWMOVES")
  {
    if(response[1] != null) ShowMoves(response[1]);
    //if(response[2] != null) console.log(response[2]);
  }
  if(response[0] === "MOVEPIECE")
  {
    //console.log(response);
    if(response[1] != null)
    {
      FillBoard(response[1]);
      ClearCanMoveTo();
    }
    if(response[2] != null)
    {
      boardB[response[2]].blur();
    }
    //if(response[3] != null) console.log(response[3]);
    if(response[4] != null && response[5] != null) currentMoveDiv.innerHTML = (response[4]) + "/" + (response[5] - 1);
    if(response[6] != null) console.log(response[6]);
  }
  if(response[0] === "AI")
  {
    if(response[1] != null)
    {
      if(response[1] == true) aiButton.style.backgroundColor = "var(--selected)";
      else aiButton.style.backgroundColor = "var(--active)";
    }
    if(response[2] != null)
    {
      let tempArray = JSON.parse(response[2]);
      FillBoard(tempArray);
    }
  }
  if(response[0] === "NEXTMOVE" || response[0] === "LASTMOVE")
  {
    //console.log(response);
    if(response[1] != null)
    {
      FillBoard(response[1]);
      ClearCanMoveTo();
    }
    if(response[2] != null)
    {
      boardB[response[2]].blur();
    }
    //if(response[3] != null) console.log(response[3]);
    let currentMove = ((response[4] / 2) + 0.5);
    if(currentMove == 0.5) currentMove = 0;
    let halfMoves = (response[5] / 2).toFixed(1);
    let remainder = (response[5] % 2).toFixed(1);
    let totalMoves = parseFloat(halfMoves) + parseFloat(remainder);
    totalMoves--;
    if(response[4] != null && response[5] != null) currentMoveDiv.innerHTML = currentMove + "/" + totalMoves;
    //if(response[6] != null) console.log(response[6]);
  }
  if(response[0] === "PGNTOMOVELOG")
  {
    //console.log(response);
    interfaceDiv.innerHTML += "parsed records " + (response[2]) + " to " + (parseInt(response[2]) + parseInt(response[3]))  + "<BR>";
    interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
    for(let i = 0; i < response[1].length; i++)
    {
      storePGN.push(response[1][i]);
    }
    //console.log(storePGN);
    interfaceDiv.innerHTML += "storePGN size is " + storePGN.length + "<BR>";
    interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
    return;
    for(let i = 0; i < response[1].length; i++)
    {
      let q = ["FILLPGN"];
      let g = JSON.stringify(response[1][i]);
      let r = [q, g];
      Query(r);
    }
  }
  
  if(response[0] === "PARSEDALL")
  {
    interfaceDiv.innerHTML += "parsed all records" + "<BR>";
    interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
  }
}
function FillInterface(array)
{
  interfaceDiv.innerHTML = `
  Event: ` + array[1] + `<br>
  Site: ` + array[2] + `<br>
  Date: ` + array[3] + `<br>
  Round: ` + array[4] + `<br>
  White: ` + array[5] + `<br>
  Black: ` + array[6] + `<br>
  Result: ` + array[7];
}

function FillMoveList(array)
{
  if(array.length == 0) return;
  interfaceDiv.innerHTML += "<br>";
  let counter = 1;
  for(let i = 0; i < array.length; i++)
  {
    let turnString = ( i + 1 ).toString() + " ";
    for(let t = 0; t < array[i].length; t++)
    {
      let turn = array[i][t].toString();
      turn = turn.replaceAll(',', '');
      turn = turn.replaceAll('P', '');
      turn = turn.replaceAll('X', '');
      if(turn != "")
      {
        turnString += "<button onclick='SkipToMove(this.id)' id=" + counter + ">" + turn + "</button> ";
      }
      counter++;
    }
    turnString += "<br>";
    interfaceDiv.innerHTML += turnString;
  }
}

function SkipToMove(index)
{
  let q = ["SKIPTOMOVE"];
  let i = index;
  let r = [q, i];
  Query(r);
}

function NewGame()
{
  let q = ["NEWGAME"];
  Query(q);
}

function NextGame()
{
  let q = ["NEXTGAME"];
  Query(q);
}

function LastGame()
{
  let q = ["LASTGAME"];
  Query(q);
}

function ToggleAI()
{
  let q = ["AI"];
  Query(q);
}

function NextMove()
{
  let q = ["NEXTMOVE"];
  Query(q);
}

function LastMove()
{
  let q = ["LASTMOVE"];
  Query(q);
}

function QuerySquare(index)
{
  if(lastClicked != index && !canMoveTo.includes(index))
  {
    ClearCanMoveTo();
    lastClicked = index;
    let q = ["QUERYSQUARE"];
    let i = [index];
    let r = [q, i];
    Query(r);
  }
  else
  {
    if(lastClicked === index)
    {
      boardB[index].blur();
      ClearCanMoveTo();
      lastClicked = -1;
      return;
    }
    if(canMoveTo.length > 0)
    {
      if(canMoveTo.includes(index))
      {
        let q = ["MOVEPIECE"];
        let i = [index];
        let r = [q, i];
        Query(r);
      }
      else
      {
        ClearCanMoveTo();
      }
    }
    else
    {
      let q = ["QUERYSQUARE"];
      let i = [index];
      let r = [q, i];
      Query(r);
    }
  }
}

function ShowMoves(array)
{
  if(array.length == 0) return;
  array = array.flat();
  canMoveTo = array;
  
  for(let i = 0; i < array.length; i++)
  {
    boardB[array[i]].dataset.state = "canMoveTo";
  }
}

function ClearCanMoveTo()
{
  canMoveTo.length = 0;
  for(let i = 0; i < boardB.length; i++)
  {
    if(boardB[i].dataset.state == "canMoveTo") boardB[i].dataset.state = "";
  }
}

function ToggleFlip()
{
  flip = !flip;
  FlipBoard();
}

function FlipBoard()
{
  if(flip)
  {
    boardDiv.style.transform = "rotate(180deg)";
    for(let i = 0; i < boardI.length; i++)
    {
      boardI[i].style.transform = "rotate(180deg)";
    }
  }
  else
  {
    boardDiv.style.transform = "";
    for(let i = 0; i < boardI.length; i++)
    {
      boardI[i].style.transform = "";
    }
  }
}

function RequestPurePGNJSON()
{
  storePGN = [];
  
  console.log("retrieving requested PGN file");
  $.ajax({
    method: "POST",
    url: 'php_process.php',
    data:{
      action:'REQUESTDATABASEPURE',
      PGNFILE:uploadedFileSelect.value
    },
    success:function(result) {
      console.log(result);
      console.log("parsing...");
      let tempArray = JSON.parse(result);
      console.log(tempArray);
      let q = ["PGNTOMOVELOG"];
      let i = [tempArray];
      let r = [q, i];
      Query(r);
    },
    error: function() {
      console.log("FAILED");
    }
  });
  
  /*
  let fileName = document.getElementById("fname").value;
  let last = fileName.lastIndexOf("\\");
  last++;
  fileName = "memory1/" + fileName.substring(last);
  interfaceDiv.innerHTML = "retrieving " + fileName;
  console.log("retrieving " + fileName);
  $.ajax({
    method: "POST",
    url: 'php_process.php',
    data:{
      action:'REQUESTDATABASEPURE',
      PGNFILE:fileName
    },
    success:function(result) {
      //console.log(result);
      console.log("parsing...");
      let tempArray = JSON.parse(result);
      //console.log(tempArray);
      let q = ["PGNTOMOVELOG"];
      let i = [tempArray];
      let r = [q, i];
      Query(r);
    },
    error: function() {
      console.log("FAILED");
    }
  });
  */
}

function RequestPurePGNJSON2()
{
  storePGN = [];
  interfaceDiv.innerHTML = "";
  interfaceDiv.innerHTML += uploadedFileSelect.length + "<BR>";
  interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
  
  let start = startNumber.value;
  let end = endNumber.value;
  
  if(start < 0) start = 0;
  if(end > uploadedFileSelect.length) end = uploadedFileSelect.length;
  
  interfaceDiv.innerHTML += start + " to " + end + "<BR>";
  interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
  
  //console.log("retrieving all requested PGN file");
  
  for(let i = start; i < end; i++)
  {
    interfaceDiv.innerHTML += uploadedFileSelect[i].value + "<BR>";
    interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
    $.ajax({
      method: "POST",
      url: 'php_process.php',
      data:{
        action:'REQUESTDATABASEPURE',
        PGNFILE:uploadedFileSelect[i].value
      },
      success:function(result) {
        //console.log(result);
        //console.log("parsing...");
        let tempArray = JSON.parse(result);
        //console.log(tempArray);
        let q = ["PGNTOMOVELOG"];
        let i = [tempArray];
        let r = [q, i];
        Query(r);
      },
      error: function() {
        //console.log("FAILED");
      }
    });
  }
  
  //console.log("GOT ALL FILES");
  
  /*
  let fileName = document.getElementById("fname").value;
  let last = fileName.lastIndexOf("\\");
  last++;
  fileName = "memory1/" + fileName.substring(last);
  interfaceDiv.innerHTML = "retrieving " + fileName;
  console.log("retrieving " + fileName);
  $.ajax({
    method: "POST",
    url: 'php_process.php',
    data:{
      action:'REQUESTDATABASEPURE',
      PGNFILE:fileName
    },
    success:function(result) {
      //console.log(result);
      console.log("parsing...");
      let tempArray = JSON.parse(result);
      //console.log(tempArray);
      let q = ["PGNTOMOVELOG"];
      let i = [tempArray];
      let r = [q, i];
      Query(r);
    },
    error: function() {
      console.log("FAILED");
    }
  });
  */
}

async function SaveToSQL2()
{
  if(storePGN.length == 0) return;
  //console.log("saving " + storePGN.length + " records...");
  interfaceDiv.innerHTML += "saving " + storePGN.length + " records..." + "<BR>";
  interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
  
  for(let i = 0; i < storePGN.length; i+= 500)
  {
    let sqlSubmit = [];
    
    for(let r = 0; r < 500; r++)
    {
      let index = (i + r);
      //console.log(index);
      if(index < storePGN.length)
      {
        sqlSubmit.push(storePGN[index]);
      }
      else break;
    }
    let jsonStore = JSON.stringify(sqlSubmit);
    if(sqlSubmit.length > 0) await SendToSQL2(jsonStore);
    //console.log("saved records " + (i) + " to " + (i + sqlSubmit.length));
    interfaceDiv.innerHTML += "saved records " + (i) + " to " + (i + sqlSubmit.length) + "<BR>";
    interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
    //if(sqlSubmit.length > 0) console.log(sqlSubmit);
  }
  
  //console.log("saved all records");
  interfaceDiv.innerHTML += "saved all records";
  interfaceDiv.scrollTop = interfaceDiv.scrollHeight;
}

async function SendToSQL2(array)
{
  await $.ajax({
    method: "POST",
    url: 'php_process.php',
    data:{
      action:'SAVETOPGNLIBRARYPURE',
      SAVEFILE:array
    },
    success:function(result) {
      return "done";
    },
    error: function() {
      return "error";
    }
  });
}

function GetFromSQL2()
{
  $.ajax({
    method: "POST",
    url: 'php_process.php',
    data:{
      action:'GETFROMPGNLIBRARYPURE',
    },
    success:function(response) {      
      //console.log(response);
      let tempArray = JSON.parse(response);
      //console.log(tempArray);
      let q = ["PGNTOMOVELOG"];
      let i = [tempArray];
      let r = [q, i];
      Query(r);
    },
    error: function() {
      //console.log("FAILED " + files[i]);
    }
  });
}

function GetUploadedFileNames()
{
  $.ajax({
    method: "POST",
    url: 'php_process.php',
    data:{
      action:'GETUPLOADEDFILELIST',
    },
    success:function(response) {      
      //console.log(response);
      let tempArray = JSON.parse(response);
      //console.log(tempArray.length);
      
      for(let i = 0; i < tempArray.length; i++)
      {
        //console.log(tempArray[i]);
        let opt = document.createElement('option');
        opt.value = tempArray[i];
        opt.innerHTML = tempArray[i];
        uploadedFileSelect.appendChild(opt);
      }
    },
    error: function() {
      //console.log("FAILED " + files[i]);
    }
  });
}

window.addEventListener('resize', CalculateVh);
window.addEventListener('orientationchange', CalculateVh);
document.addEventListener("DOMContentLoaded", CalculateVh);
document.addEventListener("DOMContentLoaded", SetBoard);
document.addEventListener("DOMContentLoaded", GetUploadedFileNames);