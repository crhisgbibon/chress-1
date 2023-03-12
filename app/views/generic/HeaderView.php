<?php

declare(strict_types=1);

class HeaderView
{

  public function __construct()
  {
    
  }

  public function render($pageTitle, $cssRoute, $faviconRoute)
  {
    echo <<<VIEW

    <!DOCTYPE html>

    <html lang='en-UK' style='font-size: 16px; font-family: Georgia, 'Times New Roman', Times, serif'>

    <head>

      <title>{$pageTitle}</title>

      <link rel='icon' type='image/x-icon' href={$faviconRoute}>

      <meta charset='UTF-8' />

      <meta name='description' content='{$pageTitle}' />
      <meta name='keywords' content='Calypso, Grammar, {$pageTitle}' />
      <meta name='author' content='contact@calypsogrammar.com' />

      <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no' />
      
      <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Open+Sans:wght@700&family=Patua+One&display=swap');
      </style>
      
      <link href="https://cdn.jsdelivr.net/npm/modern-normalize@v1.1.0/modern-normalize.min.css" rel="stylesheet">
      <link id='pageStyle' rel='stylesheet' type='text/css' href='/css/style.css' />
      <link id='pageStyle' rel='stylesheet' type='text/css' href={$cssRoute} />
      
      <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>
      
    </head>

    <body>

    VIEW;
  }
}