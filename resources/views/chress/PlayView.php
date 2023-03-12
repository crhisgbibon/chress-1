<?php

declare(strict_types=1);

/** View Class
 * 
 * 
 * 
*/

class PlayView
{

  public function __construct()
  {

  }

  private function PrintOptions() : string
  {
    return <<<VIEW

    <div class="pOptions" id="pOptionsTop">

      <button class="pOptionContent" id="pOptionsSwap" 
      onclick='Post(`SWAP`);'> Mode </button>

      <button class="pOptionContent" id="pOptionsGameLast" 
      onclick='Post(`LASTGAME`);'> < </button>

      <div class="pOptionContent" id="pOptionsGameCurrent"> 0 </div>
      
      <button class="pOptionContent" id="pOptionsGameNext" 
      onclick='Post(`NEXTGAME`);'> > </button>

      <button class="pOptionContent" id="pOptionsMoveInfo" 
      onclick='TogglePGN();'> Moves </button>

    </div>

    <div class="pOptions" id="pOptionsBot">

      <button class="pOptionContent" id="pOptionsGameFlip" 
      onclick='ToggleFlip();'> Flip </button>

      <button class="pOptionContent" id="pOptionsMoveLast" 
      onclick='Post(`LASTMOVE`);'> < </button>

      <div class="pOptionContent" id="pOptionsMoveCurrent"> 0 </div>
      
      <button class="pOptionContent" id="pOptionsMoveNext" 
      onclick='Post(`NEXTMOVE`);'> > </button>

      <button class="pOptionContent" id="pOptionsGameInfo" 
      onclick='ToggleInfo();'> Info </button>

    </div>

    VIEW;
  }

  private function PrintBoard() : string
  {
    $counter = 0;
    $rowCounter = 7;
    $colCounter = 0;
    $alternate = false;

    $output = "";
  
  for($x = 0; $x < 8; $x++)
  {
    $alternate = !$alternate;
    for($y = 0; $y < 8; $y++)
    {
      $alternate = !$alternate;

      $index = ($rowCounter * 8) + $colCounter;

      $newSquareId = "s" . $index;
      $newButtonId = "b" . $index;
      $newImgId = "i" . $index;

      $color = "white";
      if($alternate === false) $color = "black";

      $output .= "
        <div class='boardSquare' id='{$newSquareId}'>
          <button class='boardButtton' id='{$newButtonId}' 
          data-index='{$index}' data-color='{$color}'
          onclick='QuerySquare(`$index`)'>
            <img class='boardImg'  id='{$newImgId}'
            src='../../generic/assets/blank.svg'>
            </img>
          </button>
        </div>
      ";
      
      $colCounter++;
      $counter++;
    }
    $rowCounter--;
    $colCounter = 0;
  }

    return <<<VIEW

    <div id="pBoardContents">
      {$output}
    </div>

    VIEW;
  }

  public function PrintContents() : string
  {
    $options = $this->PrintOptions();
    $play = $this->PrintBoard();

    return <<<VIEW

    <div id="pView">

      <div id="pOptions">
        {$options}
      </div>

      <div id="pBar">
        <div id="pBarRange"></div>
      </div>

      <div id="pContent">
      
        <div id="pBoard">
          {$play}
        </div>

        <div id="pInfo">

          <div>Event:</div>
          <div id="pInfoEvent"></div>

          <div>Site:</div>
          <div id="pInfoSite"></div>

          <div>Date:</div>
          <div id="pInfoDate"></div>

          <div>Round:</div>
          <div id="pInfoRound"></div>

          <div>White:</div>
          <div id="pInfoWhite"></div>

          <div>Black:</div>
          <div id="pInfoBlack"></div>

          <div>Result:</div>
          <div id="pInfoResult"></div>

        </div>

        <div id="pMoves">

        </div>

      </div>

      <div id="pPromote">
        <button onclick="PromotePawn('Q');"><img id="pPromoteQ" src=""></img></button>
        <button onclick="PromotePawn('B');"><img id="pPromoteB" src=""></img></button>
        <button onclick="PromotePawn('K');"><img id="pPromoteK" src=""></img></button>
        <button onclick="PromotePawn('R');"><img id="pPromoteR" src=""></img></button>
      </div>

    </div>

    VIEW;
  }
}