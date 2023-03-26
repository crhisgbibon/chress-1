<!DOCTYPE html>
  <html lang='en-UK' style='font-size: 16px; font-family: Georgia, Times New Roman, Times, serif'>
  <head>

    <title><?=$title?></title>

    <meta charset='UTF-8' />
    <meta name='description' content=<?=$title?> />
    <meta name='keywords' content=<?=$title?> />
    <meta name='author' content='admin@calypsogrammar.com' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no,maximum-scale=1' />
    
    <link href="https://cdn.jsdelivr.net/npm/modern-normalize@v1.1.0/modern-normalize.min.css" rel="stylesheet">
    <link id='pageStyle' rel='stylesheet' type='text/css' href='assets/css/style.css'/>
    <link id='pageStyle' rel='stylesheet' type='text/css' href='assets/css/root.css'/>
    <link rel='icon' type='image/x-icon' href='favicon.ico'>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/vh.js"></script>
    <script src="assets/js/ajax.js"></script>
    
  </head>
  <body class='antialiased'>
    <?=$navBar?>
    <?=$body?>
  </body>
</html>