<?php

declare(strict_types=1);

namespace App\Models\Chess;

class PGNView
{
  public function PrintContents(array $data) : string
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
        <button class='pgnButton' onclick='SkipToMove({$i})'>{$i}. {$n}</button>
      ";
    }

    return <<<VIEW

      {$output}

    VIEW;
  }
}