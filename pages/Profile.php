<?php
if (session_status() == PHP_SESSION_NONE) {

  session_start();
}
error_reporting(0);
require('../config.php');
require('check_Update.php');
require('tokenSetting.php');

if (!isset($_SESSION['userid'])) {

  header("Location: Sign_In.php");
}

if (isset($_POST['submit_change_photo'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    if (empty($_FILES['change_photo']['error'])) {
      $chosen_page = 'Profile';
      $status_for_photo_upload = require('Profile_Photo.php');
      if ($status_for_photo_upload) {
        if (file_exists('../users_photos/' . $_SESSION['user_photo'])) {
          $target_file = '../users_photos/' . $_SESSION['user_photo'];
          @unlink($target_file);
        }
        unset($_SESSION['user_photo']);
        $_SESSION['user_photo'] = $_FILES['change_photo']['name'];
        $result_for_updated_photo = Database_Management::change_photo($_FILES['change_photo']['name']);
        if ($result_for_updated_photo) {
          echo '<p style="color: blue; font-size: 20px;">Your new profile photo was updated successfully!</p>';
        } else {
          echo '<p style="color: blue; font-size: 20px;">Your new profile photo failed to update,lease try again!</p>';
        }
      } else {
        echo '<p style="color: red; font-size: 20px;">Your photo failed to upload, please try again!</p>';
      }
    } else {
      echo '<p style="color: red; font-size: 20px;">No photo detected!</p>';
    }
  } else {
    die("Invalid token or token expired!");
  }
}

if (isset($_POST['delete_account'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    if (!isset($_POST['account_deletion_checked'])) {
      echo '<p style="color: red; font-size: 20px;">Account couldn\'t be deleted,please select the checkbox!</p>';
    } else {
      $result_for_account_deletion = Database_Management::deleteAccount();
      if ($result_for_account_deletion) {
        session_destroy();
        header('Location: ../index.php');
      } else {
        echo '<p style="color: red; font-size: 20px;">An error occurred while deleting your account,please try again!</p>';
      }
    }
  } else {
    die("Invalid token or token expired!");
  }
}
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: Sign_In.php");
}

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> <?php $title = 'Your Profile';
          echo $title; ?> </title>
  <link rel="stylesheet" type="text/css" href="../styles/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    footer {
      margin-top: 32%;
    }
  </style>
  <?php
  if (isset($_SESSION['user_photo']) && $_SESSION !== NULL) {
    $target_file = '../users_photos/' . $_SESSION['user_photo'];
    echo '<style>
             
         .avatarType {
            
          background-image: url("' . $target_file . '");
          background-position: center;
          background-repeat: no-repeat;
          background-size: 250px 250px;
        
         }
          </style>';
  } else if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male') {
    echo '<link rel="stylesheet" type="text/css" href="../styles/maleAvatar.css">';
  } else if (isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female') {
    echo '<link rel="stylesheet" type="text/css" href="../styles/femaleAvatar.css">';
  }
  ?>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>

<body>
  <div id="Main-container" class="container">
    <?php $Header = new Header($title);
    $Header->displayHeader();
    ?>
    <button id="Menu_Button">Hide Menu</button>
    <div class="avatarBase"></div>
    <main>
      <div class="avatarType"></div>
      <?php
      $user_password = $_SESSION['password'];
      $userData = Database_Management::get_User_Data($_SESSION['userid'], $user_password);
      $Profile_Page = 'Profile Page';
      $Profile_Content = new Content($Profile_Page, $userData, $_SESSION['token']);
      $Profile_Content->displayContent();
      ?>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" name="LogOutForm" id="LogOutForm">
        <input type="submit" name="logout" id="logout" value="Log Out">
      </form>
      <?php
      if (isset($failed_validation) && $failed_validation) {
        echo '<span style="color:red;font-size:24px;">The ' . $edited_field_info . ' couldn\'t be updated,invalid ' . $edited_field_info . ',please try again!</span>';
      } else if (isset($editted_msj) && $editted_msj) {
        echo '<span style="color:blue;font-size:24px;">The ' . $edited_field_info . ' was successfully updated!</span>';
      } else if (isset($editted_msj) && !$editted_msj) {
        echo '<span style="color:red;font-size:24px;">The ' . $edited_field_info . ' couldn\'t be updated,please try again!</span>';
      } else if (isset($alert)) {
        echo $alert;
      }
      ?>
    </main>
    <?php Footer::displayFooter(); ?>
  </div>
  <script src="../JS_scripts/app.js"></script>
  <noscript>Turn on javascript in your browser,for some features of the app to work!</noscript>
  <!--Notebook App by Istrate Mihai,enjoy!-->
</body>

</html>