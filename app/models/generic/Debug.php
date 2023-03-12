<?php

declare(strict_types=1);

class Debug
{
  private bool $debugMode;

  public function __construct()
  {
    $this->debugMode = true;
  }

  public function Debug(string $name, string $type, $data)
  {
    if($this->debugMode === false) return;

    $output = "";

    if($type === "string" || $type === "int")
    {
      $output = $data;
    }

    if($type === "bool")
    {
      if($data === true) $output = "true";
      else $output = "false";
    }

    if($type === "array")
    {
      $len = count($data);

      for($i = 0; $i < $len; $i++)
      {
        $d = json_encode($data[$i]);
        $output .= "
          <div></div>
            <div>{$i}: </div>
            <div>{$d}</div>
          </div>
        ";
      }
    }

    if($type === "dump")
    {
      $output = var_export($data, true);
    }

    if($type === "GameModel")
    {
      $len = count($data->moveList);

      for($i = 0; $i < $len; $i++)
      {
        $d = json_encode($data->moveList[$i]);
        $output .= "
          <div></div>
            <div>{$i}: </div>
            <div>{$d}</div>
          </div>
        ";
      }

      $len = count($data->saveList);

      for($i = 0; $i < $len; $i++)
      {
        $d = json_encode($data->saveList[$i]->move);
        $output .= "
          <div></div>
            <div>{$i}: </div>
            <div>{$d}</div>
          </div>
        ";
      }
    }

    if($type === "profile")
    {
      $username = $data->GetAccountName();
      $output .= "
        <div></div>
          <div>Account Name: </div>
          <div>{$username}</div>
        </div>
      ";
    }

    $save = <<<VIEW

    <!DOCTYPE html>

      <html lang="en-UK" style="font-size: 16px; font-family: Georgia, 'Times New Roman', Times, serif">

      <head>

        <title>{$name}</title>

        <link rel="icon" type="image/x-icon" href=''>

        <meta charset="UTF-8" />

        <meta name="description" content="{$name}" />
        <meta name="keywords" content="Calypso, Grammar, {$name}" />
        <meta name="author" content="contact@calypsogrammar.com" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        
        <style>
          @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Open+Sans:wght@700&family=Patua+One&display=swap');
        </style>
        
        <link id="pageStyle" rel="stylesheet" type="text/css" href='' />
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

        <style>
          body{
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            align-content: flex-start;
          }
        </style>
        
      </head>

      <body>

        {$output}

      </body>

    </html>

    VIEW;

    $fileName = $_SERVER['DOCUMENT_ROOT'] . "/logs/debug/" . $name . ".php";
    file_put_contents($fileName, $save);
  }

  public function ShowDebug() : string
  {
    $dir = $_SERVER['DOCUMENT_ROOT'] . "/logs/debug/";
    $locations = [];
    if(is_dir($dir))
    {
      if($dh = opendir($dir))
      {
        while(($file = readdir($dh)) !== false)
        {
          $ext = pathinfo($file, PATHINFO_EXTENSION);
          if($ext === "php")
          {
            $newLocation = "/logs/debug/" . $file;
            array_push($locations, $newLocation);
          }
        }
        closedir($dh);
      }
    }

    $output = "";

    $count = count($locations);

    for($i = 0; $i < $count; $i++)
    {
      $l = $locations[$i];
      $output .= "
        <div>
          <a href='{$l}' target='_blank'>
            {$l}
          </a>
        </div>
      ";
    }

    $save = <<<VIEW

    <!DOCTYPE html>

      <html lang="en-UK" style="font-size: 16px; font-family: Georgia, 'Times New Roman', Times, serif">

      <head>

        <title>Debug</title>

        <link rel="icon" type="image/x-icon" href=''>

        <meta charset="UTF-8" />

        <meta name="description" content="Debug" />
        <meta name="keywords" content="Calypso, Grammar, Debug" />
        <meta name="author" content="contact@calypsogrammar.com" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        
        <style>
          @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Open+Sans:wght@700&family=Patua+One&display=swap');
        </style>
        
        <link id="pageStyle" rel="stylesheet" type="text/css" href='' />
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

        <style>
          body{
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            align-content: flex-start;
          }
        </style>
        
      </head>

      <body>

        {$output}

      </body>

    </html>

    VIEW;

    $fileName = $_SERVER['DOCUMENT_ROOT'] . "/logs/debug/" . "d" . ".php";
    file_put_contents($fileName, $save);

    $newLocation = "/logs/debug/" . "d.php";

    return $newLocation;
  }
}