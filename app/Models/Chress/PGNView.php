<?php

declare(strict_types=1);

namespace App\Models\Chress;

class PGNView
{
  public function PrintContents(array $data, int $gameid) : string
  {
    $output = "";

    $count = count($data);

    for($i = 0; $i < $count; $i++)
    {
      $piece = $data[$i]["piece"];
      $to = $data[$i]["to"];
      $capture = $data[$i]["capture"];
      $state = $data[$i]["state"];

      $n = $piece . $capture . $to . $state;
      $output .= "
        <button style='background-color: var(--mid);' class='pgnButton rounded-lg m-2 p-2' onclick='Post(`skip`, [`{$i}`, `{$gameid}`])'>{$i}. {$n}</button>
      ";
    }

    return <<<VIEW

      {$output}

    VIEW;
  }
}