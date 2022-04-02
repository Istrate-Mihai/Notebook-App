<?php
if (session_status() == PHP_SESSION_NONE) {

  session_start();
}
error_reporting(0);
require('../config.php');
require('tokenSetting.php');

if (isset($_SESSION['userid'])) {

  header("Location: ../index.php");
}

if (isset($_POST['submit'])) {

  if ($_POST['token'] == $_SESSION['token']) {

    Database_Management::checkSign_In($_POST['username'], $_POST['password']);
  } else {

    die("Invalid token or token expired!");
  }
}

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> <?php $title = 'Sign In';
          echo $title; ?> </title>
  <link rel="stylesheet" type="text/css" href="../styles/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    footer {
      margin-top: 62%;
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
      $form_Type = 'Sign In';
      $file_name = htmlspecialchars($_SERVER['PHP_SELF']);
      $Form = new Form($form_Type, $file_name, $_SESSION['token']);
      $Form->displayForm();
      ?>
    </main>
    <?php Footer::displayFooter(); ?>
  </div>
  <script src="../JS_scripts/app.js"></script>
  <noscript>Turn on javascript in your browser,for some features of the app to work!</noscript>
  <!--Notebook App by Istrate Mihai,enjoy!-->
</body>

</html>