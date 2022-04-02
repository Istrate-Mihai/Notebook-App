<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
error_reporting(0);
require('../config.php');
require('../classes/FormValidation.php');
require('tokenSetting.php');
if (isset($_SESSION['userid'])) {

  header("Location: ../index.php");
}

if (isset($_POST['submit'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    $errors = array();
    $acceptedData = array();
    $name = FormValidation::validate_strings($_POST['name']);
    $firstname = FormValidation::validate_strings($_POST['firstname']);
    $email = FormValidation::validate_email($_POST['email']);
    $username = FormValidation::validate_strings($_POST['username']);
    $password = FormValidation::validate_password($_POST['password']);
    $gender = $_POST['genderSelection'];
    $checkedPrior = false;
    require('Check.php');
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
  <title> <?php $title = 'Sign Up';
          echo $title; ?> </title>
  <link rel="stylesheet" type="text/css" href="../styles/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    footer {
      margin-top: 28.5%;
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
      if (!empty($errors)) {
        foreach ($errors as $error) {
          echo $error . '<br>';
        }
      } else {
        if (isset($checkedPrior) && $checkedPrior === false) {
          $allow_Insert = Database_Management::checkPriorEntry($username, $check = "don't display connect message");
        }

        if (isset($acceptedData) && !empty($acceptedData) && $allow_Insert) {
          if (empty($_FILES['userPhoto']['error'])) {
            $chosen_page = 'Sign Up';
            $status_for_photo_upload = require('Profile_Photo.php');
            if ($status_for_photo_upload) {
              echo '<p style="color: blue; font-size: 20px;">Your new profile photo was uploaded successfully!</p>';
              $user_profile_photo = $_FILES['userPhoto']['name'];
            } else {

              echo '<p style="color: red; font-size: 20px;">Your photo failed to upload, please try again!</p>';
            }
          }

          if (isset($user_profile_photo)) {
            $status = Database_Management::insert($acceptedData['Name'], $acceptedData['Firstname'], $acceptedData['Email'], $acceptedData['Username'], $acceptedData['Password'], $acceptedData['Gender'], $acceptedData['Policy'], $user_profile_photo);
          } else {
            $status = Database_Management::insert($acceptedData['Name'], $acceptedData['Firstname'], $acceptedData['Email'], $acceptedData['Username'], $acceptedData['Password'], $acceptedData['Gender'], $acceptedData['Policy']);
          }

          if ($status === true) :
            if (isset($user_profile_photo)) :
              $acceptedData['Profile Photo'] = $user_profile_photo;
            endif;
            echo '<span style="color:blue;font-size: 24px;">This is your data:</span><br>';
            echo '<ul class="showedData">';
            foreach ($acceptedData as $key => $accepted) :
      ?>
              <li><?php echo "$key: $accepted"; ?></li>
      <?php
            endforeach;
            echo '</ul>';

          endif;
        }
      }
      $form_Type = 'Sign Up';
      $file_name = htmlspecialchars($_SERVER['PHP_SELF']);
      $Form = new Form($form_Type, $file_name, $_SESSION['token']);
      if (isset($acceptedData)) {
        $Form->displayForm($acceptedData);
      } else {
        $Form->displayForm();
      }
      ?>
      <a href="PrivacyPolicy.php" id="PrivacyPolicy" target="_blank">Click Here to see Privacy Policy</a>
    </main>
    <?php Footer::displayFooter(); ?>
  </div>
  <script src="../JS_scripts/app.js"></script>
  <noscript>Turn on javascript in your browser,for some features of the app to work!</noscript>
  <!--Notebook App by Istrate Mihai,enjoy!-->
</body>

</html>