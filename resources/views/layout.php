<?php 
  use App\Models\System\Component;
?>

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
    <link id='pageStyle' rel='stylesheet' type='text/css' href='assets/css/style.css'/>
    <link id='pageStyle' rel='stylesheet' type='text/css' href='assets/css/root.css'/>
    <link rel='icon' type='image/x-icon' href='favicon.ico'>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <script src="assets/js/vh.js"></script>
    
  </head>

  <body class='antialiased'>

    <?php if(isset($navBar)) echo $navBar; ?>

    <?php if(isset($body)) echo $body; ?>

    <?php echo Component::make ('test', [ 'test' => $test, ] ); ?>

  </body>

</html>