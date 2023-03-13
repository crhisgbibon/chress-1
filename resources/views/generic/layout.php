<!DOCTYPE html>

  <html lang='en-UK' style='font-size: 16px; font-family: Georgia, Times New Roman, Times, serif'>

  <head>

    <title><?php if(isset($title)) echo $title; ?></title>

    <meta charset='UTF-8' />
    <meta name='description' content=<?php if(isset($title)) echo $title; ?> />
    <meta name='keywords' content=<?php if(isset($title)) echo $title; ?> />
    <meta name='author' content='admin@calypsogrammar.com' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no' />
    
    <link href="https://cdn.jsdelivr.net/npm/modern-normalize@v1.1.0/modern-normalize.min.css" rel="stylesheet">
    <link id='pageStyle' rel='stylesheet' type='text/css' href='css/style.css'/>
    <link id='pageStyle' rel='stylesheet' type='text/css' href='<?php if(isset($css)) echo $css; ?>' />
    <link rel='icon' type='image/x-icon' href=<?php if(isset($favicon)) echo $favicon; ?>>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Open+Sans:wght@700&family=Patua+One&display=swap');
    </style>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>
    
  </head>

  <body>

    <?php if(isset($body)) echo $body; ?>

    <div id='messageBox'></div>

  </body>

  <script src=<?php if(isset($js)) echo $js; ?>></script>

</html>