<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
error_reporting(0);
require('../config.php');
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> <?php $title = 'Contact';
          echo $title; ?> </title>
  <link rel="stylesheet" type="text/css" href="../styles/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    footer {
      margin-top: 73.5%;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>

<body>
  <div id="Main-container" class="container">
    <?php $Header = new Header($title);
    $Header->displayHeader();
    ?>
    <button id="Menu_Button">Hide Menu</button>
    <main>
      <?php
      $Contact_Page = 'Contact Page';
      $Contact_Messsage = new Content($Contact_Page, [], '');
      $Contact_Messsage->displayContent();
      ?>
    </main>
    <?php Footer::displayFooter(); ?>
  </div>
  <script src="../JS_scripts/app.js"></script>
  <noscript>Turn on javascript in your browser,for some features of the app to work!</noscript>
  <!--Notebook App by Istrate Mihai,enjoy!-->
</body>

</html>