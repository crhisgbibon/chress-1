<!DOCTYPE html>
  <html lang='en-UK' style='font-size: 16px; font-family: Georgia, Times New Roman, Times, serif'>
  <head>

    <title><?=$title?></title>

    <meta charset='UTF-8' />
    <meta name='description' content='<?=$title?>' />
    <meta name='keywords' content='<?=$title?>' />
    <meta name='author' content='admin@calypsogrammar.com' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no,maximum-scale=1' />
    
    <link href="https://cdn.jsdelivr.net/npm/modern-normalize@v1.1.0/modern-normalize.min.css" rel="stylesheet">
    <link id='tailwindcss' rel='stylesheet' type='text/css' href='<?=$layer?>assets/css/style.css'/>
    <link id='maincss' rel='stylesheet' type='text/css' href='<?=$layer?>assets/css/main.css'/>
    <link id='rootcss' rel='stylesheet' type='text/css' href='<?=$layer?>assets/css/themes/<?=$root?>.css'/>
    <link rel='icon' type='image/x-icon' href='<?=$layer?>favicon.ico'>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>

    <style>
      :root {
        --vh: 0px;
      }
    </style>
    <script>
      "use strict";

      let debug = false;

      function calculateVh() {
        let vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', vh + 'px');
      }

      window.addEventListener('DOMContentLoaded', calculateVh);
      window.addEventListener('resize', calculateVh);
      window.addEventListener('orientationchange', calculateVh);
    </script>
    
  </head>
  <body
    class='antialiased'
    style='background-color: var(--back); color: var(--text);'>
    <?=$navBar?>
    <?=$body?>
  </body>
</html>