"use strict";

// Generic

const messageBox = document.getElementById("messageBox");
const ThemeButton = document.getElementById("ThemeButton");
const HomeButton = document.getElementById("HomeButton");
const i_controlTheme = document.getElementById("i_controlTheme");
const i_controlHome = document.getElementById("i_controlHome");

const LobbyButton = document.getElementById("LobbyButton");
const i_controlLobby = document.getElementById("i_controlLobby");

const PlayButton = document.getElementById("PlayButton");
const i_controlPlay = document.getElementById("i_controlPlay");

const SearchButton = document.getElementById("SearchButton");
const i_controlSearch = document.getElementById("i_controlSearch");

const lView = document.getElementById("lView");
const pView = document.getElementById("pView");
const sView = document.getElementById("sView");

// Lobby view

const lOptionsNewGame = document.getElementById("lOptionsNewGame");

const lGames = document.getElementById("lGames");
const lLobby = document.getElementById("lLobby");
const lHistory = document.getElementById("lHistory");

const lSwitchGames = document.getElementById("lSwitchGames");
const lSwitchLobby = document.getElementById("lSwitchLobby");
const lSwitchHistory = document.getElementById("lSwitchHistory");

const lNewWhite = document.getElementById("lNewWhite");
const lNewBlack = document.getElementById("lNewBlack");
const lNewRandom = document.getElementById("lNewRandom");

const lNewSelf = document.getElementById("lNewSelf");
const lNewComputer = document.getElementById("lNewComputer");
const lNewPlayer = document.getElementById("lNewPlayer");

const lNewOne = document.getElementById("lNewOne");
const lNewThree = document.getElementById("lNewThree");
const lNewSeven = document.getElementById("lNewSeven");

const lNewGame = document.getElementById("lNewGame");

// Play view

const pBoard = document.getElementById("pBoard");
const pInfo = document.getElementById("pInfo");
const pMoves = document.getElementById("pMoves");
const pPromote = document.getElementById("pPromote");

const pBar = document.getElementById("pBar");
const pBarRange = document.getElementById("pBarRange");

const pContent = document.getElementById("pContent");

const pOptionsSwap = document.getElementById("pOptionsSwap");
const pOptionsGameCurrent = document.getElementById("pOptionsGameCurrent");
const pOptionsGameNext = document.getElementById("pOptionsGameNext");
const pOptionsGameLast = document.getElementById("pOptionsGameLast");

const pOptionsMoveCurrent = document.getElementById("pOptionsMoveCurrent");
const pBoardContents = document.getElementById("pBoardContents");

const pInfoEvent = document.getElementById("pInfoEvent");
const pInfoSite = document.getElementById("pInfoSite");
const pInfoDate = document.getElementById("pInfoDate");

const pInfoRound = document.getElementById("pInfoRound");
const pInfoWhite = document.getElementById("pInfoWhite");
const pInfoBlack = document.getElementById("pInfoBlack");

const pInfoResult = document.getElementById("pInfoResult");

const pPromoteQ = document.getElementById("pPromoteQ");
const pPromoteB = document.getElementById("pPromoteB");
const pPromoteK = document.getElementById("pPromoteK");
const pPromoteR = document.getElementById("pPromoteR");

// Search view

const sQuery = document.getElementById("sQuery");
const sField = document.getElementById("sField");
const sOutput = document.getElementById("sOutput");

const i_sQuery = document.getElementById("i_sQuery");
const i_sQueryLastTen = document.getElementById("i_sQueryLastTen");
const i_sQueryNextTen = document.getElementById("i_sQueryNextTen");

const sQueryEventText = document.getElementById("sQueryEventText");
const sQuerySiteText = document.getElementById("sQuerySiteText");
const sQueryDateText = document.getElementById("sQueryDateText");

const sQueryRoundText = document.getElementById("sQueryRoundText");
const sQueryWhiteText = document.getElementById("sQueryWhiteText");
const sQueryBlackText = document.getElementById("sQueryBlackText");

const sQueryResultText = document.getElementById("sQueryResultText");

const sQueryEventButton = document.getElementById("sQueryEventButton");
const sQuerySiteButton = document.getElementById("sQuerySiteButton");
const sQueryDateButton = document.getElementById("sQueryDateButton");

const sQueryRoundButton = document.getElementById("sQueryRoundButton");
const sQueryWhiteButton = document.getElementById("sQueryWhiteButton");
const sQueryBlackButton = document.getElementById("sQueryBlackButton");

const sQueryResultButton = document.getElementById("sQueryResultButton");

const sQueryButton = document.getElementById("sQueryButton");
const sQueryShow = document.getElementById("sQueryShow");
const sQueryCountText = document.getElementById("sQueryCountText");
const sQueryLastTenButton = document.getElementById("sQueryLastTenButton");
const sQueryNextTenButton = document.getElementById("sQueryNextTenButton");

const sFieldRefresh = document.getElementById("sFieldRefresh");
const sFieldClose = document.getElementById("sFieldClose");
const sFieldText = document.getElementById("sFieldText");
const sFieldClear = document.getElementById("sFieldClear");
const sFieldOutput = document.getElementById("sFieldOutput");

const i_sFieldRefresh = document.getElementById("i_sFieldRefresh");
const i_sFieldClose = document.getElementById("i_sFieldClose");
const i_sFieldEnter = document.getElementById("i_sFieldEnter");
const i_sFieldErase = document.getElementById("i_sFieldErase");

const sOutputText = document.getElementById("sOutputText");
const sOutputSearchButton = document.getElementById("sOutputSearchButton");

const i_sOutputReverse = document.getElementById("i_sOutputReverse");
const i_sOutputSearch = document.getElementById("i_sOutputSearch");

// Assignments

// Generic

ThemeButton.onclick = function() { ToggleTheme(); };
HomeButton.onclick = function() { Home(); };
messageBox.onclick = function() { TogglePanel(messageBox); };

LobbyButton.onclick = function(){ SwitchView(views, 0, viewsB, 0); };
PlayButton.onclick = function(){ SwitchView(views, 1, viewsB, 1); };
SearchButton.onclick = function(){ SwitchView(views, 2, viewsB, 2); };

// Lobby

lSwitchGames.onclick = function(){ SwitchView(viewsLobby, 0, viewsBLobby, 0); };
lSwitchLobby.onclick = function(){ SwitchView(viewsLobby, 1, viewsBLobby, 1); };
lSwitchHistory.onclick = function(){ SwitchView(viewsLobby, 2, viewsBLobby, 2); };

lOptionsNewGame.onclick = function() { TogglePanel(lNewGame); };

// Play

pOptionsGameLast.onclick = function() { Post("LASTGAME"); };
pOptionsGameNext.onclick = function() { Post("NEXTGAME"); };

// Search

sQueryEventButton.onclick = function() { ToggleField('event'); };
sQuerySiteButton.onclick = function() { ToggleField('site'); };
sQueryDateButton.onclick = function() { ToggleField('date'); };

sQueryRoundButton.onclick = function() { ToggleField('round'); };
sQueryWhiteButton.onclick = function() { ToggleField('white'); };
sQueryBlackButton.onclick = function() { ToggleField('black'); };

sQueryResultButton.onclick = function() { ToggleField('result'); };

sQueryButton.onclick = function() { Post('QUERYLIBRARY'); };

sFieldRefresh.onclick = function() { Post("GETLISTS"); };
sFieldClose.onclick = function() { CloseField(); };
sFieldText.onkeyup = function() { FilterField(sFieldText.value) };
sFieldClear.onclick = function() { ClearField(); };

sOutputSearchButton.onclick = function() { ToggleSearch(); };

// Globals

let toggleTheme = true;
if(typeof(Storage) !== "undefined")
{
  let storedValue = localStorage.getItem("siteTheme");
  if(storedValue === "false") toggleTheme = false;
}

const views = [lView, pView, sView];
const viewsB = [LobbyButton, PlayButton, SearchButton];

const boardB = Array.from(document.getElementsByClassName("boardButtton"));
const boardI = Array.from(document.getElementsByClassName("boardImg"));

const viewsLobby = [lGames, lLobby, lHistory];
const viewsBLobby = [lSwitchGames, lSwitchLobby, lSwitchHistory];

let flip = false;
let lastClicked = -1;
let lastMove = [];
let canMoveTo = [];
let timeOut = undefined;
let fieldState = "";
let showGame = -1;
let toggleInfo = false;
let toggleMoves = false;
let skipTo = -1;
let swap = false;

let acceptChallenge = -1;
let viewGame = -1;
let resignGame = -1;
let promotion = "";

let resultList, eventList, siteList,
dateList, roundList, whiteList,
blackList, gameResultList;

// Startup

UpdateTheme(toggleTheme);
TogglePanel(messageBox);
SwitchView(viewsLobby, 0, viewsBLobby, 0);
SwitchView(views, 1, viewsB, 1);

TogglePanel(lNewGame);

TogglePanel(pInfo);
TogglePanel(pMoves);
TogglePanel(pPromote);

TogglePanel(sField);
TogglePanel(sOutput);

document.onkeydown = function(event){
  if(event.key === "`")
  {
    Post("DEBUG");
  }
}

function ToggleTheme()
{
  toggleTheme = !toggleTheme;
  UpdateTheme(toggleTheme);
}

function UpdateTheme(state)
{
  let r = document.querySelector(':root');
  if(typeof(Storage) !== "undefined") localStorage.setItem("siteTheme", state);
  if(state)
  {
    r.style.setProperty('--background', 'var(--backgroundLight)');
    r.style.setProperty('--foreground', 'var(--foregroundLight)');
    r.style.setProperty('--buttonBackground', 'var(--buttonBackgroundLight)');
    r.style.setProperty('--buttonBorder', 'var(--buttonBorderLight)');
    r.style.setProperty('--hyperlink', 'var(--hyperlinkLight)');
    "../../assets/sortAZLight.svg";
    i_controlTheme.src = "../../generic/assets/themeLight.svg";
    i_controlHome.src = "../../generic/assets/homeLight.svg";

    i_controlLobby.src = "../../generic/assets/plusLight.svg";
    i_controlPlay.src = "../../generic/assets/playLight.svg";
    i_controlSearch.src = "../../generic/assets/searchLight.svg";

    i_sQuery.src = "../../generic/assets/searchLight.svg";
    i_sQueryLastTen.src = "../../generic/assets/chevronLeftLight.svg";
    i_sQueryNextTen.src = "../../generic/assets/chevronRightLight.svg";

    i_sFieldRefresh.src = "../../generic/assets/undoLight.svg";
    i_sFieldClose.src = "../../generic/assets/closeLight.svg";
    i_sFieldErase.src = "../../generic/assets/eraseLight.svg";

    i_sOutputReverse.src = "../../generic/assets/sortAZLight.svg";
    i_sOutputSearch.src = "../../generic/assets/searchLight.svg";
  }
  else
  {
    r.style.setProperty('--background', 'var(--backgroundDark)');
    r.style.setProperty('--foreground', 'var(--foregroundDark)');
    r.style.setProperty('--buttonBackground', 'var(--buttonBackgroundDark)');
    r.style.setProperty('--buttonBorder', 'var(--buttonBorderDark)');
    r.style.setProperty('--hyperlink', 'var(--hyperlinkDark)');

    i_controlTheme.src = "../../generic/assets/themeDark.svg";
    i_controlHome.src = "../../generic/assets/homeDark.svg";

    i_controlLobby.src = "../../generic/assets/plusDark.svg";
    i_controlPlay.src = "../../generic/assets/playDark.svg";
    i_controlSearch.src = "../../generic/assets/searchDark.svg";

    i_sQuery.src = "../../generic/assets/searchDark.svg";
    i_sQueryLastTen.src = "../../generic/assets/chevronLeftDark.svg";
    i_sQueryNextTen.src = "../../generic/assets/chevronRightDark.svg";

    i_sFieldRefresh.src = "../../generic/assets/undoDark.svg";
    i_sFieldClose.src = "../../generic/assets/closeDark.svg";
    i_sFieldErase.src = "../../generic/assets/eraseDark.svg";

    i_sOutputReverse.src = "../../generic/assets/sortAZDark.svg";
    i_sOutputSearch.src = "../../generic/assets/searchDark.svg";
  }
}

function ReSize()
{
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', vh + 'px');

  Square();
}

function Square()
{
  let screenWidth = pBoard.scrollWidth;
  let screenHeight = pBoard.scrollHeight;
  let squareSize, difference;
  
  if(screenWidth >= screenHeight)
  {
    squareSize = screenHeight;
    difference = pContent.scrollWidth - pBoardContents.scrollWidth;

    if(difference > 200)
    {
      pContent.style.flexDirection = "row";
      pMoves.style.width = "25%";
      pMoves.style.height = "calc(var(--vh) * 77.5)";
      pMoves.style.borderLeft = "1px solid var(--buttonBorder)";
      pMoves.style.borderTop = "";
      pInfo.style.width = "25%";
      pInfo.style.height = "calc(var(--vh) * 77.5)";
      pInfo.style.borderLeft = "1px solid var(--buttonBorder)";
      pInfo.style.borderTop = "";
    }
  }
  else
  {
    squareSize = screenWidth;
    difference = pContent.scrollHeight - pBoardContents.scrollHeight;

    if(difference > 200)
    {
      pContent.style.flexDirection = "column";
      pMoves.style.width = "100%";
      pMoves.style.height = "";
      pMoves.style.borderLeft = "none";
      pMoves.style.borderTop = "1px solid var(--buttonBorder)";
      pInfo.style.width = "100%";
      pInfo.style.height = "";
      pInfo.style.borderLeft = "none";
      pInfo.style.borderTop = "1px solid var(--buttonBorder)";
    }
  }

  pBoardContents.style.width = squareSize + "px";
  pBoardContents.style.height = squareSize + "px";
}

function TogglePanel(panel)
{
  if(panel.style.display == "none") panel.style.display = "";
  else panel.style.display = "none";
}

function SwitchView(array, aIndex, buttons, bIndex)
{
  let aLen = array.length;
  let bLen = buttons.length;
  if(aIndex > aLen) return;
  if(bIndex > bLen) return;
  if(aLen > 0)
  {
    for(let i = 0; i < aLen; i++)
    {
      if(i === aIndex) array[i].style.display = "";
      else array[i].style.display = "none";
    }
  }
  if(bLen > 0)
  {
    for(let i = 0; i < bLen; i++)
    {
      if(i === bIndex) buttons[i].dataset.state = "selected";
      else buttons[i].dataset.state = "";
    }
  }
}

function MessageBox(message)
{
  messageBox.innerHTML = message;
  if(messageBox.style.display === "none") TogglePanel(messageBox);
  AnimatePop(messageBox);
  if(timeOut != null) clearTimeout(timeOut);
  timeOut = setTimeout(AutoOff, 2500);
}

function AnimatePop(panel)
{
  panel.animate([
    { transform: 'scale(110%, 110%)'},
    { transform: 'scale(109%, 109%)'},
    { transform: 'scale(108%, 108%)'},
    { transform: 'scale(107%, 107%)'},
    { transform: 'scale(106%, 106%)'},
    { transform: 'scale(105%, 105%)'},
    { transform: 'scale(104%, 104%)'},
    { transform: 'scale(103%, 103%)'},
    { transform: 'scale(102%, 102%)'},
    { transform: 'scale(101%, 101%)'},
    { transform: 'scale(100%, 100%)'}],
    {
      duration: 100,
    }
  );
}

function AutoOff()
{
  messageBox.style.display = "none";
}

function Filter(dataset, inputFilter)
{
  let filter, li, len, a, i;
  filter = inputFilter.value.toUpperCase();
  if(filter === "378462SDJKFHDSDBS8743247832") filter = "";
  li = document.getElementsByClassName(dataset);
  len = li.length;
  for (i = 0; i < len; i++)
  {
    if(filter === "")
    {
      li[i].style.display = "";
      continue;
    }
    a = li[i].dataset.search.toString();
    if (a.toUpperCase().indexOf(filter) > -1)
    {
      li[i].style.display = "";
    }
    else
    {
      li[i].style.display = "none";
    }
  }
}

function GetChecked(array)
{
  for(let i = 0; i < array.length; i++)
  {
    if(array[i].checked === true)
    {
      return array[i].value;
    }
  }
  return false;
}

function Post(trigger)
{
  if(pPromote.style.display === "") TogglePanel(pPromote);

  let data = [];

  if(trigger === "NEWGAME")
  {
    data = [
      GetChecked([lNewWhite, lNewBlack, lNewRandom]),
      GetChecked([lNewSelf, lNewComputer, lNewPlayer]),
      GetChecked([lNewOne, lNewThree, lNewSeven])
    ];
  }

  if(trigger === "QUERYSQUARE")
  {
    data = [
      lastClicked
    ];
  }

  if(trigger === "MOVEPIECE")
  {
    data = [
      lastClicked,
      promotion
    ];
    console.log(data);
  }

  if(trigger === "QUERYLIBRARY")
  {
    if(sQueryEventText.value == "" &&
      sQuerySiteText.value == "" &&
      sQueryDateText.value == "" &&
      sQueryRoundText.value == "" &&
      sQueryWhiteText.value == "" &&
      sQueryBlackText.value == "" &&
      sQueryResultText.value == "")
    {
      sOutputText.innerHTML = "Need search criteria.";
      return;
    }

    data = [
      sQueryEventText.value,
      sQuerySiteText.value,
      sQueryDateText.value,

      sQueryRoundText.value,
      sQueryWhiteText.value,
      sQueryBlackText.value,

      sQueryResultText.value,
      sQueryShow.value,
    ];
  }

  if(trigger === "SHOWGAME")
  {
    data = [
      showGame
    ];
  }

  if(trigger === "VIEWGAME")
  {
    data = [
      viewGame
    ];
  }
  
  if(trigger === "SKIPTO")
  {
    data = [
      skipTo
    ];
  }

  if(trigger === "ACCEPTCHALLENGE")
  {
    data = [
      acceptChallenge
    ];
  }

  if(trigger === "RESIGNGAME")
  {
    data = [
      resignGame
    ];
  }

  $.ajax(
  {
    method: "POST",
    url: 'php/controller/Controller.php',
    data:
    {
      action:trigger,
      data:data
    },
    timeout: 10000,
    success:function(result)
    {
      console.log(result);
      if(result === "" || result === null || result === undefined) return;
      let tempArray = JSON.parse(result);

      if(trigger === "DEBUG")
      {
        window.open(tempArray);
      }

      if(trigger === "GETACTIVEGAMES"
      || trigger === "NEXTGAME"
      || trigger === "LASTGAME"
      || trigger === "LASTMOVE"
      || trigger === "NEXTMOVE"
      || trigger === "MOVEPIECE"
      || trigger === "SHOWGAME"
      || trigger === "SKIPTO"
      || trigger === "SWAP"
      || trigger === "VIEWGAME")
      {
        ProcessGameInfo(tempArray, true);

        if(trigger === "SHOWGAME" || trigger === "VIEWGAME")
        {
          SwitchView(views, 1, viewsB, 1);
        }
      }

      if(trigger === "NEWGAME")
      {
        ProcessGameInfo(tempArray[0], true);
        lGames.innerHTML = tempArray[1][0];
        lLobby.innerHTML = tempArray[1][1];
        lHistory.innerHTML = tempArray[1][2];
      }

      if(trigger === "QUERYSQUARE")
      {
        ShowMoves(tempArray);
      }

      if(trigger === "GETLISTS")
      {
        eventList = tempArray[0];
        siteList = tempArray[1];
        dateList = tempArray[2];
        roundList = tempArray[3];
        whiteList = tempArray[4];
        blackList = tempArray[5];
        gameResultList = tempArray[6];

        AnimatePop(sFieldRefresh);
      }

      if(trigger === "QUERYLIBRARY")
      {
        sQuery.style.display = "none";
        sOutput.style.display = "";

        sOutputText.innerHTML = tempArray;
        //if(tempArray[1] !== null) FillSearchCount(tempArray[1]);
      }

      if(trigger === "ACCEPTCHALLENGE" || trigger === "RESIGNGAME")
      {
        lGames.innerHTML = tempArray[0];
        lLobby.innerHTML = tempArray[1];
        lHistory.innerHTML = tempArray[2];
      }
    }
  });
}

function FillBoard(bitBoard, clear, state)
{
  let aLen = bitBoard.length;

  if(aLen === 0) return;
  
  for(let i = 0; i < aLen; i++)
  {
    let src = "";
    "../../assets/sortAZLight.svg";
    if(bitBoard[i][1] === "-") src = "../../generic/assets/blank.svg";
    if(bitBoard[i][1] === "WP") src = "../../generic/assets/whitePawn.png";
    if(bitBoard[i][1] === "BP") src = "../../generic/assets/blackPawn.png";
    if(bitBoard[i][1] === "WR") src = "../../generic/assets/whiteRook.png";
    if(bitBoard[i][1] === "BR") src = "../../generic/assets/blackRook.png";
    if(bitBoard[i][1] === "WK") src = "../../generic/assets/whiteKnight.png";
    if(bitBoard[i][1] === "BK") src = "../../generic/assets/blackKnight.png";
    if(bitBoard[i][1] === "WB") src = "../../generic/assets/whiteBishop.png";
    if(bitBoard[i][1] === "BB") src = "../../generic/assets/blackBishop.png";
    if(bitBoard[i][1] === "WQ") src = "../../generic/assets/whiteQueen.png";
    if(bitBoard[i][1] === "BQ") src = "../../generic/assets/blackQueen.png";
    if(bitBoard[i][1] === "WX") src = "../../generic/assets/whiteKing.png";
    if(bitBoard[i][1] === "BX") src = "../../generic/assets/blackKing.png";

    if(clear)
    {
      document.getElementById("b" + bitBoard[i][0]).dataset.state = "";
    }
    document.getElementById("i" + bitBoard[i][0]).src = src;

    if(state === "") continue; 
    else
    {
      if(state === "CHECKMATEWHITE")
      {
        document.getElementById("b" + bitBoard[i][0]).dataset.state = "over";
        if(bitBoard[i][1] === "WX")
        {
          document.getElementById("b" + bitBoard[i][0]).dataset.state = "mate";
        }
      }

      if(state === "CHECKMATEBLACK")
      {
        document.getElementById("b" + bitBoard[i][0]).dataset.state = "over";
        if(bitBoard[i][1] === "BX")
        {
          document.getElementById("b" + bitBoard[i][0]).dataset.state = "mate";
        }
      }

      if(state === "CHECKWHITE" && bitBoard[i][1] === "WX")
      {
        document.getElementById("b" + bitBoard[i][0]).dataset.state = "check";
      }

      if(state === "CHECKBLACK" && bitBoard[i][1] === "BX")
      {
        document.getElementById("b" + bitBoard[i][0]).dataset.state = "check";
      }

      if(state === "DRAW50" || state === "DRAWMATERIAL" || state === "DRAWSTALEMATE" || state === "DRAWTHREE")
      {
        document.getElementById("b" + bitBoard[i][0]).dataset.state = "over";
      }
    }
  }

  UpdateLastMove();
}

function UpdateLastMove()
{
  for(let i = 0; i < lastMove.length; i++)
  {
    if(document.getElementById("b" + lastMove[i]).dataset.state != "canMoveTo")
    {
      document.getElementById("b" + lastMove[i]).dataset.state = "moved";
    }
  }
}

function ToggleFlip()
{
  if(pPromote.style.display === "none") TogglePanel(pPromote);
  flip = !flip;
  FlipBoard();
}

function FlipBoard()
{
  if(flip)
  {
    pBoardContents.style.transform = "rotate(180deg)";
    for(let i = 0; i < boardI.length; i++)
    {
      boardI[i].style.transform = "rotate(180deg)";
    }
  }
  else
  {
    pBoardContents.style.transform = "";
    for(let i = 0; i < boardI.length; i++)
    {
      boardI[i].style.transform = "";
    }
  }
}

function QuerySquare(index)
{
  index = parseInt(index);

  if(lastClicked !== index && !canMoveTo.includes(index))
  {
    ClearCanMoveTo();
    UpdateLastMove();
    lastClicked = index;
    Post("QUERYSQUARE");
  }
  else
  {
    if(lastClicked === index)
    {
      boardB[index].blur();
      ClearCanMoveTo();
      lastClicked = -1;
      UpdateLastMove();
    }
    else if(canMoveTo.length > 0)
    {
      if(canMoveTo.includes(index))
      {
        let bFrom = document.getElementById("b" + lastClicked).dataset.index;
        let iFrom = document.getElementById("i" + lastClicked).src.slice(-13);
        if(bFrom >= 48 && bFrom <= 55 && iFrom === "whitePawn.png")
        {
          lastClicked = index;
          promotion = "";
          pPromoteQ.src = "../../generic/assets/whiteQueen.png";
          pPromoteB.src = "../../generic/assets/whiteBishop.png";
          pPromoteK.src = "../../generic/assets/whiteKnight.png";
          pPromoteR.src = "../../generic/assets/whiteRook.png";
          if(pPromote.style.display === "none") TogglePanel(pPromote);
        }
        else if(bFrom >= 8 && bFrom <= 15 && iFrom === "blackPawn.png")
        {
          lastClicked = index;
          promotion = "";
          pPromoteQ.src = "../../generic/assets/blackQueen.png";
          pPromoteB.src = "../../generic/assets/blackBishop.png";
          pPromoteK.src = "../../generic/assets/blackKnight.png";
          pPromoteR.src = "../../generic/assets/blackRook.png";
          if(pPromote.style.display === "none") TogglePanel(pPromote);
        }
        else
        {
          lastClicked = index;
          promotion = "";
          Post("MOVEPIECE");
        }
      }
      else
      {
        ClearCanMoveTo();
        UpdateLastMove();
      }
    }
    else
    {
      Post("QUERYSQUARE");
    }
  }
}

function PromotePawn(piece)
{
  promotion = piece;
  Post("MOVEPIECE");
  if(pPromote.style.display === "") TogglePanel(pPromote);
}

function ClearCanMoveTo()
{
  canMoveTo.length = 0;
  for(let i = 0; i < boardB.length; i++) if(boardB[i].dataset.state == "canMoveTo") boardB[i].dataset.state = "";
}

function ShowMoves(array)
{
  if(array.length == 1 && array[0] === -1) return;
  array = array.flat();
  canMoveTo = array;
  
  for(let i = 0; i < array.length; i++)
  {
    document.getElementById("b" + array[i]).dataset.state = "canMoveTo";
  }
}

function ClearMovedState()
{
  for(let i = 0; i < boardB.length; i++) if(boardB[i].dataset.state == "moved") boardB[i].dataset.state = "";
}

function FillGameNumber(current, total)
{
  pOptionsGameCurrent.innerHTML = current + " / " + total;
}

function FillMoveNumber(current, total)
{
  pOptionsMoveCurrent.innerHTML = current + " / " + total;
}

function ToggleField(field)
{
  sField.style.display = "";
  sFieldText.dataset.state = field;
  sQuery.style.display = "none";
  sFieldText.focus();
}

function CloseField()
{
  sField.style.display = "none";
  sQuery.style.display = "";
}

function ClearField()
{
  if(sFieldText.dataset.state == "event")
  {
    sQueryEventButton.innerHTML = "";
    sQueryEventText.value = "";
  }
  if(sFieldText.dataset.state == "site")
  {
    sQuerySiteButton.innerHTML = "";
    sQuerySiteText.value = "";
  }
  if(sFieldText.dataset.state == "date")
  {
    sQueryDateButton.innerHTML = "";
    sQueryDateText.value = "";
  }
  if(sFieldText.dataset.state == "round")
  {
    sQueryRoundButton.innerHTML = "";
    sQueryRoundText.value = "";
  }
  if(sFieldText.dataset.state == "white")
  {
    sQueryWhiteButton.innerHTML = "";
    sQueryWhiteText.value = "";
  }
  if(sFieldText.dataset.state == "black")
  {
    sQueryBlackButton.innerHTML = "";
    sQueryBlackText.value = "";
  }
  if(sFieldText.dataset.state == "result")
  {
    sQueryResultButton.innerHTML = "";
    sQueryResultText.value = "";
  }
  sField.style.display = "none";
  sQuery.style.display = "";
}

async function FilterField(value)
{
  value = value.toUpperCase();
  
  sFieldOutput.innerHTML = "";
  
  let resultList = [];
  
  if(sFieldText.dataset.state === "event")
  {
    if(value.length < 2) { sFieldOutput.innerHTML = ""; return; }
    resultList = await FilterList(eventList, value);
  }
  
  if(sFieldText.dataset.state === "site")
  {
    if(value.length < 2) { sFieldOutput.innerHTML = ""; return; }
    resultList = await FilterList(siteList, value);
  }
  
  if(sFieldText.dataset.state === "date")
  {
    if(value.length < 2) { sFieldOutput.innerHTML = ""; return; }
    resultList = await FilterList(dateList, value);
  }
  
  if(sFieldText.dataset.state === "round")
  {
    if(value.length < 0) { sFieldOutput.innerHTML = ""; return; }
    resultList = await FilterList(roundList, value);
  }
  
  if(sFieldText.dataset.state === "white")
  {
    if(value.length < 3) { sFieldOutput.innerHTML = ""; return; }
    resultList = await FilterList(whiteList, value);
  }
  
  if(sFieldText.dataset.state === "black")
  {
    if(value.length < 3) { sFieldOutput.innerHTML = ""; return; }
    resultList = await FilterList(blackList, value);
  }
  
  if(sFieldText.dataset.state === "result")
  {
    if(value.length < 0) { sFieldOutput.innerHTML = ""; return; }
    resultList = await FilterList(gameResultList, value);
  }
  
  if(resultList.length > 0)
  {
    await AddButtons(resultList);
  }
}

async function FilterList(listToSearch, value)
{
  let result = [];
  for(let i = 0; i < listToSearch.length; i++)
  {
    if(listToSearch[i].toUpperCase().indexOf(value) > -1)
    {
      result.push(listToSearch[i]);
    }
  }
  return result;
}

async function AddButtons(array)
{
  for(let i = 0; i < array.length; i++)
  {
    let newButton = document.createElement("BUTTON");
    newButton.className = "sFieldButton";
    newButton.innerHTML = array[i];
    newButton.setAttribute("onclick", `FillFieldValue("` + sFieldText.dataset.state.toString() + `", "` + array[i] + `")`);
    sFieldOutput.appendChild(newButton);
  }
}

function FillFieldValue(field, value)
{
  if(field == "event")
  {
    sQueryEventButton.innerHTML = value;
    sQueryEventText.value = value;
  }
  if(field == "site")
  {
    sQuerySiteButton.innerHTML = value;
    sQuerySiteText.value = value;
  }
  if(field == "date")
  {
    sQueryDateButton.innerHTML = value;
    sQueryDateText.value = value;
  }
  if(field == "round")
  {
    sQueryRoundButton.innerHTML = value;
    sQueryRoundText.value = value;
  }
  if(field == "white")
  {
    sQueryWhiteButton.innerHTML = value;
    sQueryWhiteText.value = value;
  }
  if(field == "black")
  {
    sQueryBlackButton.innerHTML = value;
    sQueryBlackText.value = value;
  }
  if(field == "result")
  {
    sQueryResultButton.innerHTML = value;
    sQueryResultText.value = value;
  }
  sField.style.display = "none";
  sQuery.style.display = "";
}

function ToggleSearch()
{
  sField.style.display = "none";
  sOutput.style.display = "none";
  sQuery.style.display = "";
}

function FillSearchCount(response)
{
  if(response.length == 0) { sQueryCountText.innerHTML = ""; return; }

  sQueryCountText.innerHTML = response;
}

function ShowGame(index)
{
  showGame = index;
  Post("SHOWGAME");
}

function ToggleInfo()
{
  if(pPromote.style.display === "none") TogglePanel(pPromote);
  toggleInfo = !toggleInfo;
  ShowInfo(toggleInfo);
}

function ShowInfo(state)
{
  if(state)
  {
    pInfo.style.display = "";
    pMoves.style.display = "none";
    pBoard.style.width = "75%";
  }
  else
  {
    pInfo.style.display = "none";
    pMoves.style.display = "none";
    pBoard.style.width = "100%";
  }
  if(toggleMoves) toggleMoves = false;
  Square();
}

function TogglePGN()
{
  if(pPromote.style.display === "none") TogglePanel(pPromote);
  toggleMoves = !toggleMoves;
  ShowPGN(toggleMoves);
}

function ShowPGN(state)
{
  if(state)
  {
    pInfo.style.display = "none";
    pMoves.style.display = "";
    pBoard.style.width = "75%";
  }
  else
  {
    pInfo.style.display = "none";
    pMoves.style.display = "none";
    pBoard.style.width = "100%";
  }
  if(toggleInfo) toggleInfo = false;
  Square();
}

function FillMetaInfo(data)
{
  if(data.length != 7) return;

  pInfoEvent.innerHTML = data[0].replace(/\\/g, '');
  pInfoSite.innerHTML = data[1].replace(/\\/g, '');
  pInfoDate.innerHTML = data[2].replace(/\\/g, '');

  pInfoRound.innerHTML = data[3].replace(/\\/g, '');
  pInfoWhite.innerHTML = data[4].replace(/\\/g, '');
  pInfoBlack.innerHTML = data[5].replace(/\\/g, '');
  
  pInfoResult.innerHTML = data[6].replace(/\\/g, '');
}

function FillScore(data)
{
  let screenHalf = pBar.scrollWidth / 2;
  let perCent = 0;

  perCent = ( 100 / screenHalf ) * Math.abs(data);

  if(data[0] > 0) pBarRange.style.width = ( screenHalf + perCent ) + "px";
  else pBarRange.style.width = ( screenHalf - perCent ) + "px";
}

function FillPGNMoves(data)
{
  pMoves.innerHTML = data;
}

function SkipToMove(index)
{
  skipTo = index;
  Post("SKIPTO");
}

function Main()
{
  Post("GETACTIVEGAMES");
  Post("GETLISTS");
}

function AcceptChallenge(index)
{
  acceptChallenge = index;
  Post("ACCEPTCHALLENGE");
}

function ViewGame(index)
{
  viewGame = index;
  Post("VIEWGAME");
}

function ResignGame(index)
{
  resignGame = index;
  Post("RESIGNGAME");
}

function ProcessGameInfo(tempArray, clear)
{
  if(tempArray[0] !== undefined && tempArray[1] !== undefined) FillGameNumber(tempArray[0], tempArray[1]);
  if(tempArray[2] !== undefined)
  {
    if(tempArray[2][1] !== undefined)
    {
      if(tempArray[2][1][0] !== undefined && tempArray[2][1][1] !== undefined)
      {
        FillMoveNumber(tempArray[2][1][0], tempArray[2][1][1]);
      }
    }
    if(tempArray[2][3] !== undefined)
    {
      FillScore(tempArray[2][3]);
    }
    if(tempArray[2][4] !== undefined)
    {
      FillMetaInfo(tempArray[2][4]);
    }
    if(tempArray[2][5] !== undefined)
    {
      FillPGNMoves(tempArray[2][5]);
    }
    if(tempArray[2][6] !== undefined)
    {
      lastMove = [];
      if(tempArray[2][6][0] !== undefined)
      {
        lastMove.push(tempArray[2][6][0]);
      }
      if(tempArray[2][6][1] !== undefined)
      {
        lastMove.push(tempArray[2][6][1]);
      }
    }
    if(tempArray[2][7] !== undefined)
    {
      flip = !tempArray[2][7];
      FlipBoard();
    }
    if(tempArray[2][0] !== undefined)
    {
      if(tempArray[2][2] !== undefined)
      {
        FillBoard(tempArray[2][0], clear, tempArray[2][2]);
      }
      else
      {
        FillBoard(tempArray[2][0], clear, "");
      }
    }
  }
  if(tempArray[3] !== undefined)
  {
    if(tempArray[3] === true)
    {
      pOptionsSwap.innerHTML = "PGN";
    }
    else
    {
      pOptionsSwap.innerHTML = "Games";
    }
  }
}

// const evtSource = new EventSource("php/controller/SSE.php", { withCredentials: true });

// evtSource.addEventListener("sse_ping", function(event)
// {
//   let output = JSON.parse(event.data).output;
//   if(output.length === 0) return;
//   // console.log(output);
//   if(output[2][2][6] != lastMove)
//   {
//     ClearMovedState();
//   }
//   ProcessGameInfo(output[2], false);
// });

window.addEventListener('resize', ReSize);

document.addEventListener("DOMContentLoaded", ReSize);
document.addEventListener("DOMContentLoaded", Main);