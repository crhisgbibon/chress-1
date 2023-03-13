<?php

declare(strict_types=1);

namespace App\Views\Chress;

class LibraryView
{

  public function __construct()
  {

  }

  public function PrintContents(array $data) : string
  {
    $len = count($data);

    $output = "";

    for($i = 0; $i < $len; $i++)
    {
      $rank = $data[$i]["rank"];
      $event = $data[$i]["event"];
      $site = $data[$i]["site"];
      $date = $data[$i]["date"];
      $round = $data[$i]["round"];
      $white = $data[$i]["white"];
      $black = $data[$i]["black"];
      $result = $data[$i]["result"];

      $output .= "
      
        <div class='lPanel'>

          <div>
            Event: {$event}
          </div>
          <div>
            Site: {$site}
          </div>
          <div>
            Date: {$date}
          </div>

          <div>
            Round: {$round}
          </div>
          <div>
            White: {$white}
          </div>
          <div>
            Black: {$black}
          </div>

          <div>
            Result: {$result}
          </div>

          <div>
            <button onclick='ShowGame(`{$rank}`)'>View</button>
          </div>

        </div>
      
      ";
    }

    return $output;
  }
}