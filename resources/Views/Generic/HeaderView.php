<?php
  declare(strict_types=1);

  namespace App\Views\Generic;

  class HeaderView{

    private string $pageTitle;
    private string $cssRoute;
    private string $faviconRoute;

    public function __construct($pageTitle, $cssRoute, $faviconRoute)
    {
      $this->pageTitle = $pageTitle;
      $this->cssRoute = $cssRoute;
      $this->faviconRoute = $faviconRoute;
    }
  }
?>

<!DOCTYPE html>

  <html lang='en-UK' style='font-size: 16px; font-family: Georgia, Times New Roman, Times, serif'>

  <head>

    <title>$pageTitle</title>

    <meta charset='UTF-8' />
    <meta name='description' content=<?php echo $pageTitle?> />
    <meta name='keywords' content='<?php echo $pageTitle?>' />
    <meta name='author' content='admin@calypsogrammar.com' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no' />
    
    <link href="https://cdn.jsdelivr.net/npm/modern-normalize@v1.1.0/modern-normalize.min.css" rel="stylesheet">
    <link id='pageStyle' rel='stylesheet' type='text/css' href='/css/style.css' />
    <link id='pageStyle' rel='stylesheet' type='text/css' href=<?php echo $cssRoute?> />
    <link rel='icon' type='image/x-icon' href=<?php echo $faviconRoute?>>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Open+Sans:wght@700&family=Patua+One&display=swap');
    </style>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" crossorigin="anonymous"></script>
    
  </head>

  <body>