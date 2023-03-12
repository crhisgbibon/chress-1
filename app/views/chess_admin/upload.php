<?php
    $currentDirectory = getcwd();
    $uploadDirectory = "/memory1/";

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['pgn']; // These will be the only file extensions allowed
    
    
    $fLen = count($_FILES['the_file']['name']);
    
    for($i = 0; $i < $fLen; $i++)
    {

      $fileName = $_FILES['the_file']['name'][$i];
      $fileSize = $_FILES['the_file']['size'][$i];
      $fileTmpName  = $_FILES['the_file']['tmp_name'][$i];
      $fileType = $_FILES['the_file']['type'][$i];

      $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

      if(isset($_POST['submit'])){

        if ($fileSize > 100000000) {
          $errors[] = "File exceeds maximum size (100MB)";
        }

        if (empty($errors)) {
          $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

          if ($didUpload) {
            echo "The file " . basename($fileName) . " has been uploaded";
          } else {
            echo "An error occurred. Please contact the administrator.";
          }
        } else {
          foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";
          }
        }

      }
    
    }
?>