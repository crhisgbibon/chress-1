<?php

declare(strict_types=1);

namespace App\Views\Chress;

class SearchView
{

  public function __construct()
  {

  }

  public function PrintContents() : string
  {

    return <<<VIEW

    <div id="sView">

      <div id="sQuery">

        <label for="sQueryEventText">Event:</label>
        <input hidden type="text" id="sQueryEventText" name="sQueryEventText">
        <button id="sQueryEventButton"></button>

        <label for="sQuerySiteText">Site:</label>
        <input hidden type="text" id="sQuerySiteText" name="sQuerySiteText">
        <button id="sQuerySiteButton"></button>

        <label for="sQueryDateText">Date:</label>
        <input hidden type="text" id="sQueryDateText" name="sQueryDateText">
        <button id="sQueryDateButton"></button>

        <label for="sQueryRoundText">Round:</label>
        <input hidden type="text" id="sQueryRoundText" name="sQueryRoundText">
        <button id="sQueryRoundButton"></button>

        <label for="sQueryWhiteText">White:</label>
        <input hidden type="text" id="sQueryWhiteText" name="sQueryWhiteText">
        <button id="sQueryWhiteButton"></button>

        <label for="sQueryBlackText">Black:</label>
        <input hidden type="text" id="sQueryBlackText" name="sQueryBlackText">
        <button id="sQueryBlackButton"></button>

        <label for="sQueryResultText">Result:</label>
        <input hidden type="text" id="sQueryResultText" name="sQueryResultText">
        <button id="sQueryResultButton"></button>

        <button id="sQueryButton">
          <img id="i_sQuery" src=""></img>
        </button>

        <div id="sQueryCountText"></div>

        <div id="sQueryOffset">

          <button id="sQueryLastTenButton">
            <img id="i_sQueryLastTen" src=""></img>
          </button>

          <select id="sQueryShow">

            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
            
          </select>
          
          <button id="sQueryNextTenButton">
            <img id="i_sQueryNextTen" src=""></img>
          </button>

        </div>

      </div>

      <div id="sField">

        <div id="sFieldControls">

          <button id="sFieldRefresh">
            <img id="i_sFieldRefresh" src=""></img>
          </button>

          <button id="sFieldClose">
            <img id="i_sFieldClose" src=""></img>
          </button>

          <input type="text" id="sFieldText">

          <button id="sFieldClear">
            <img id="i_sFieldErase" src=""></img>
          </button>

        </div>
        
        <div id="sFieldOutput"></div>
      
      </div>

      <div id="sOutput">
    
        <div id="sOutputFilters">

          <select id="sortQueryOutput">

            <option value="index" selected>Index</option>
            <option value="event">Event</option>
            <option value="site">Site</option>
            <option value="date">Date</option>
            <option value="round">Round</option>
            <option value="white">White</option>
            <option value="black">Black</option>
            <option value="result">Result</option>
            
          </select>

          <button id="sOutputReverseButton">
            <img id="i_sOutputReverse" src=""></img>
          </button>

          <button id="sOutputSearchButton">
            <img id="i_sOutputSearch" src=""></img>
          </button>

        </div>
    
        <div id="sOutputText">
        
        </div>

      </div>

    </div>

    VIEW;
  }
}