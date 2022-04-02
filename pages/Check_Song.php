<?php
if (empty($_POST['song'])) {
  $userid = $_SESSION['userid'];
  $username = $_SESSION['username'];
  $target_dir = '../users_songs/songs_for_user_' . $username . '_ID_' . $userid;
  $target_file = $target_dir . '/' . basename($_FILES['songUploaded']['name']);
  $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $ready_for_upload = false;
  $songname = basename($_FILES['songUploaded']['name']);
  if (empty($_FILES['songUploaded']['size'])) {
    echo '<p style="color:red;font-size: 20px;">Please select a file to upload for further processing!</p>';
  } else {
    $ready_for_song_upload = FormValidation::validate_song_name($songname);;
    if ($ready_for_song_upload === false) {
      echo '<p style="color:red;font-size: 20px;">Uploading of the song failed, the name of the song is not valid, only capital letters(A-Z), lowercase letters(a-z), <br>digits(0-9), hyphens (-) or dots(.) are allowed!</p>';
    } else {
      $ready_for_song_registration_inDatabase = FormValidation::validate_uploading_of_song($target_dir, $target_file, $fileType);
      if ($ready_for_song_registration_inDatabase === false) {
        echo '<p style="color:red;font-size: 20px;">Registration of the song in the database failed,because the file could not be uploaded to the file system!</p>';
      } else {
        $result_of_song_registration_inDatabase = Database_Management::register_song_name($ready_for_song_upload);
        if ($result_of_song_registration_inDatabase) {
          echo '<p style="color:blue; font-size: 20px;">The song was successfully registered in the database!</p>';
        } else {
          echo '<p style="color:red;font-size: 20px;">Registration of the song the database failed!</p>';
        }
      }
    }
  }
} else if (!empty($_POST['song'])) {
  if (empty($_FILES['songUploaded']['size'])) {
    echo '<p style="color:red;font-size: 20px;">Please select a file to upload for further processing!</p>';
  } else {
    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];
    $target_dir = '../users_songs/songs_for_user_' . $username . '_ID_' . $userid;
    $target_file = $target_dir . '/' . basename($_FILES['songUploaded']['name']);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $ready_for_upload = false;
    $songname = trim($_POST['song']);
    $ready_for_song_upload = FormValidation::validate_song_name($songname);
    if ($ready_for_song_upload === false) {
      echo '<p style="color:red;font-size: 20px;">Uploading of the song failed, the name you wish to rename the song to is not valid, only capital letters(A-Z), lowercase letters(a-z), <br>digits(0-9), hyphens (-) or dots(.) are allowed!</p>';
    } else {
      if (strlen($ready_for_song_upload) >= 4) {
        $ext = substr($ready_for_song_upload, strlen($ready_for_song_upload) - 4, 4);
        if ($ext === '.mp3') {
          $target_file = $target_dir . '/' . basename($ready_for_song_upload);
          $extcase = 1;
        } else {
          $target_file = $target_dir . '/' . basename($ready_for_song_upload) . '.' . $fileType;
          $extcase = 2;
        }
      } else {
        $target_file = $target_dir . '/' . basename($ready_for_song_upload) . '.' . $fileType;
        $extcase = 3;
      }
      $ready_for_song_registration_inDatabase = FormValidation::validate_uploading_of_song($target_dir, $target_file, $fileType);
      if ($ready_for_song_registration_inDatabase === false) {
        echo '<p style="color:red;font-size: 20px;">Registration of the song in the database failed,because the file could not be uploaded to the file system!</p>';
      } else {
        if ($extcase === 2 || $extcase === 3) {
          $ready_for_song_upload = $ready_for_song_upload . '.' . $fileType;
        }
        $result_of_song_registration_inDatabase = Database_Management::register_song_name($ready_for_song_upload);
        if ($result_of_song_registration_inDatabase) {
          echo '<p style="color:blue; font-size: 20px;">The song was successfully registered in the database!</p>';
        } else {
          echo '<p style="color:red;font-size: 20px;">Registration of the song the database failed!</p>';
        }
      }
    }
  }
}
