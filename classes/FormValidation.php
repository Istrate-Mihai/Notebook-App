<?php
class FormValidation
{

  public static function validate_strings($data)
  {

    $data = trim($data);

    if (preg_match("/^[a-zA-Z-' ]*$/", $data) && !empty($data)) {

      return $data;
    } else {

      return false;
    }
  }

  public static function validate_email($email)
  {

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

      return false;
    } else {

      return $email;
    }
  }

  public static function validate_password($password)
  {

    $password = trim($password);

    if (preg_match("/^[a-zA-Z0-9?.,!_-~$%+=]{8,100}$/", $password)) {

      return $password;
    } else {
      return false;
    }
  }

  public static function validate_song_name($song_name = '')
  {

    if (preg_match("/^[-a-zA-Z0-9 .]*$/", $song_name) && !empty($song_name)) {

      return $song_name;
    } else {

      return false;
    }
  }

  public static function validate_uploading_of_song($target_dir = '', $target_file = '', $fileType = '')
  {


    if (!is_dir($target_dir)) {

      if (mkdir($target_dir)) {

        $content = "<?php
            echo '<span style=\"color:red;font-size:36px;\">Sorry, the requested URL is not available!</span>';";

        file_put_contents($target_dir . '/' . 'index.php', $content);
        echo '<p style="color: blue; font-size: 20px;">The directory for your songs was created successfully!</p>';

        if (file_exists($target_file)) {

          echo '<p style="color: red; font-size: 20px;">A file named ' . $_FILES['songUploaded']['name'] . ' already exists, please rename the file you wish to upload!</p>';
          return false;
        } else if ($_FILES['songUploaded']['size'] === 0) {

          echo '<p style="color: red; font-size: 20px;">Please select a file!</p>';
          return false;
        } else if ($_FILES['songUploaded']['size'] > 7000000) {

          echo '<p style="color: red; font-size: 20px;">Please select a file of size less than 7MB!</p>';
          return false;
        } else if ($fileType !== 'mp3') {

          echo '<p style="color: red; font-size: 20px;">Only mp3 file format allowed!</p>';
          return false;
        } else {
          $ready_for_upload = true;

          if ($ready_for_upload && move_uploaded_file($_FILES['songUploaded']['tmp_name'], $target_file)) {

            echo '<p style="color: blue; font-size: 20px;">Your new file was uploaded successfully to your songs directory!</p>';
            return true;
          } else {

            echo '<p style="color: red; font-size: 20px;">An error occurred while uploading the new file to your songs directory, please try again!</p>';
            return false;
          }
        }
      }
    } else {

      if (file_exists($target_file)) {

        echo '<p style="color: red; font-size: 20px;">A file named ' . $_FILES['songUploaded']['name'] . ' already exists, please rename the file you wish to upload!</p>';
        return false;
      } else if ($_FILES['songUploaded']['size'] === 0) {

        echo '<p style="color: red; font-size: 20px;">Please select a file!</p>';
        return false;
      } else if ($_FILES['songUploaded']['size'] > 7000000) {

        echo '<p style="color: red; font-size: 20px;">Please select a file of size less than 7MB!</p>';
        return false;
      } else if ($fileType !== 'mp3') {

        echo '<p style="color: red; font-size: 20px;">Only mp3 file format allowed!</p>';
        return false;
      } else {
        $ready_for_upload = true;

        if ($ready_for_upload && move_uploaded_file($_FILES['songUploaded']['tmp_name'], $target_file)) {

          echo '<p style="color: blue; font-size: 20px;">Your new file was uploaded successfully to your songs directory!</p>';
          return true;
        } else {

          echo '<p style="color: red; font-size: 20px;">An error occurred while uploading the new file to your songs directory, please try again!</p>';
          return false;
        }
      }
    }
  }
}
