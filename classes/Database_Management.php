<?php
class Database_Management
{
  protected  static function insertuserID($length = 20)
  {
    $len = rand(5, $length);
    $userid = '';
    for ($i = 0; $i < $len; $i++) {
      $userid .= rand(0, 9);
    }
    return $userid;
  }
  protected  static function db_connect($check = '')
  {

    $host = 'localhost';
    $username = 'id17502183_mihai';
    $password = 'D{d/4d91vGo(0yYA';
    $dbName = 'id17502183_maindb';
    $dsn = 'mysql:host=' . $host . ';databaseName=' . $dbName;

    try {

      $conn = new PDO($dsn, $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      if ($check !== "don't display connect message") {
        echo '<span style="color:blue;font-size:24px;">Connected successfully!</span><br>';
      }

      return $conn;
    } catch (PDOException $e) {
      echo '<span style="color:red;font-size:24px;">Connection failed: </span>' . $e->getMessage() . '<br>';
      return false;
    }
  }



  public static function insert($name, $firstname, $email, $username, $password, $gender, $policy, $user_photo = NULL)
  {

    $conn = self::db_connect();

    if ($conn !== false) {

      $sql_Query = 'INSERT INTO id17502183_maindb.users(`name`,`firstname`,`email`,`username`,`password`,`gender`,`policy`,`userid`,`user_photo`) VALUES(:name,:firstname,:email,:username,:password,:gender,:policy,:userid,:user_photo)';

      $userid = self::insertUserID();
      $password = md5($password);
      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':firstname', $firstname);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':password', $password);
      $stmt->bindParam(':gender', $gender);
      $stmt->bindParam(':policy', $policy);
      $stmt->bindParam(':userid', $userid);
      $stmt->bindParam(':user_photo', $user_photo);

      $result = $stmt->execute();

      if ($result) {

        echo '<span style="color:blue;font-size:24px;">New records created successfully!</span><br>';
        $conn = null;
        return true;
      } else {

        $conn = null;
        echo '<span style="color:red;font-size:24px;">New records could not be inserted in the database!</span><br>';
        return false;
      }
    }
  }

  public static function checkPriorEntry($username = '', $check = '')
  {

    $conn = self::db_connect($check);

    if ($conn !== false) {

      $sql_Query = 'SELECT username FROM id17502183_maindb.users';

      $stmt = $conn->prepare($sql_Query);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $result_Length = count($result);

      if ($result) {


        for ($i = 0; $i < $result_Length; $i++) {

          foreach ($result[$i] as $username_In_Database) {

            if ($username === $username_In_Database) {

              echo '<span style="color:red;font-size:24px;">This user name has been taken please try another one!</span><br>';
              $conn = null;
              return false;
            }
          }
        }
        $conn = null;
        return true;
      } else {

        echo '<span style="color:red;font-size:20px;">No prior usernames could be found in the database!Congratulations you are the first one to sign up!</span><br>';
        $conn = null;
        return true;
      }
    }
  }


  public static function checkSign_In($username = '', $password = '')
  {

    $username = trim($username);
    $password = trim($password);
    $decrypted_password = $password;
    $password = md5($password);

    if (empty($username) || empty($password)) {

      echo '<span style="color:red;font-size:24px;">Username or password field is empty,please fill each of them!</span>';
    } else {

      $check = "don't display connect message";
      $conn = self::db_connect($check);

      $sql_Query = 'SELECT `username`,`password`,`userid`,`gender`,`user_photo` FROM id17502183_maindb.users WHERE username=:username LIMIT 1';

      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':username', $username);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {

        foreach ($result as $key => $passwordDB) {

          if ($key === 'password' && $password === $passwordDB) {

            $_SESSION['userid'] = $result['userid'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['gender'] = $result['gender'];
            $_SESSION['password'] = $decrypted_password;
            $_SESSION['user_photo'] = $result['user_photo'];
            $conn = null;
            header("Location: Profile.php");
          } else if ($key === 'password' && $password !== $passwordDB) {

            echo '<span style="color:red;font-size:24px;">Incorect password,make sure to type the correct password!</span>';
            $conn = null;
          }
        }
      } else {
        echo '<span style="color:red;font-size:24px;">No result for such an username</span>';
        $conn = null;
      }
    }
  }

  public static function get_User_Data($userid = '', $user_pass = '')
  {


    $check = "don't display connect message";
    $userid = trim($userid);

    $conn = self::db_connect($check);

    if ($conn !== false) {

      $sql_Query = 'SELECT `name`,`firstname`,`username`,`gender`,`email` FROM id17502183_maindb.users WHERE userid=:userid LIMIT 1';
      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':userid', $userid);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $result['password'] = $user_pass;

      if ($result) {

        return $result;
        $conn = null;
      } else {

        echo '<span style="color:red;font-size:24px;">Data for your profile page is empty!</span>';
        $conn = null;
      }
    }
  }

  public static function update_User_Info($editted_info = '', $edited_field = '')
  {
    $userid = $_SESSION['userid'];
    $check = "don't display connect message";
    $conn = self::db_connect($check);

    if ($edited_field == 'password') {

      $editted_info = md5($editted_info);
    }


    if ($conn !== false) {

      $sql_Query = 'UPDATE id17502183_maindb.users SET ' . $edited_field . '=:editted_info WHERE userid =' . $userid;
      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':editted_info', $editted_info);


      if ($stmt->execute()) {

        $conn = null;
        return true;
      } else {

        $conn = null;
        return false;
      }
    }
  }

  public static function register_song_name($song_name = '')
  {

    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];

    $check = "don't display connect message";
    $conn = self::db_connect($check);

    if ($conn !== false) {

      $sql_Query = 'INSERT INTO id17502183_maindb.users_songs(`user_id`,`user_name`,`songname`) VALUES(:userid,:username,:songname)';
      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':userid', $userid);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':songname', $song_name);

      if ($stmt->execute()) {

        $conn = null;
        return true;
      } else {

        $conn = null;
        return false;
      }
    }
  }




  public static function register_note($activity_title = '', $activity_description = '', $activity_date = '')
  {

    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];

    $check = "don't display connect message";
    $conn = self::db_connect($check);

    if ($conn !== false) {

      $sql_Query = 'INSERT INTO id17502183_maindb.users_notes(`activity_title`,`activity_description`,`activity_date`,`user_name`,`user_id`) VALUES(:activity_title,:activity_description,:activity_date,:user_name,:user_id)';
      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':activity_title', $activity_title);
      $stmt->bindParam(':activity_description', $activity_description);
      $stmt->bindParam(':activity_date', $activity_date);
      $stmt->bindParam(':user_name', $username);
      $stmt->bindParam(':user_id', $userid);


      if ($stmt->execute()) {

        $conn = null;
        return true;
      } else {

        $conn = null;
        return false;
      }
    }
  }




  public static function generate($generate_option = '')
  {


    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];

    $check = "don't display connect message";
    $conn = self::db_connect($check);

    if ($conn !== false) {

      if ($generate_option === 'playlist') {

        $sql_Query = 'SELECT `songname` FROM id17502183_maindb.users_songs WHERE user_id =:userid AND user_name =:username';
      } elseif ($generate_option === 'notes') {

        $sql_Query = 'SELECT `activity_title`,`activity_date`,`activity_description` FROM id17502183_maindb.users_notes WHERE user_name =:username AND user_id =:userid';
      }


      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':userid', $userid);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


      if ($result) {

        $conn = null;
        return $result;
      } else {

        $conn = null;
        return false;
      }
    }
  }


  private static function processDelete($expected_conn, $expected_value = '', $userid = '', $username = '', $delete_option)
  {

    global $expected_conn;

    if ($delete_option === 'note') {

      $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_notes WHERE activity_description=:expected_value && user_id=:userid && user_name=:username LIMIT 1';
    } else if ($delete_option === 'song') {

      $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_songs WHERE user_id=:userid &&  user_name =:username && songname=:expected_value LIMIT 1';
    }


    $stmt = $expected_conn->prepare($sql_Query);
    $stmt->bindParam(':expected_value', $expected_value);
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {

      if ($delete_option === 'note') {

        $deleted_note_index = $result['id'];

        $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_notes WHERE id > ' . $deleted_note_index;
      } else if ($delete_option === 'song') {

        $deleted_song_index = $result['id'];

        $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_songs WHERE id > ' . $deleted_song_index;
      }



      $stmt = $expected_conn->prepare($sql_Query);
      $stmt->execute();
      $indexes_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($delete_option === 'note') {

        $sql_Query = 'DELETE FROM id17502183_maindb.users_notes WHERE activity_description=:expected_value && user_id=:userid && user_name=:username';
      } else if ($delete_option === 'song') {

        $sql_Query = 'DELETE FROM id17502183_maindb.users_songs WHERE user_id=:userid && user_name=:username && songname=:expected_value';
      }



      $stmt = $expected_conn->prepare($sql_Query);
      $stmt->bindParam(':expected_value', $expected_value);
      $stmt->bindParam(':userid', $userid);
      $stmt->bindParam(':username', $username);

      if ($stmt->execute() && empty($indexes_result)) {

        if ($delete_option === 'note') {

          $sql_Query = 'ALTER TABLE id17502183_maindb.users_notes AUTO_INCREMENT = ' . $deleted_note_index;
          $stmt = $expected_conn->prepare($sql_Query);
          $stmt->execute();
          $expected_conn = null;
          return true;
        } else if ($delete_option === 'song') {

          $sql_Query = 'ALTER TABLE id17502183_maindb.users_songs AUTO_INCREMENT = ' . $deleted_song_index;
          $stmt = $expected_conn->prepare($sql_Query);
          $stmt->execute();
          $expected_conn = null;
          return true;
        }
      } else if ($stmt->execute() && !empty($indexes_result)) {

        $altered_results = array();
        $n = count($indexes_result);
        for ($i = 0; $i < $n; $i++) {

          foreach ($indexes_result[$i] as $index) {

            $altered_results[] = $index - 1;
          }
        }


        $m = count($altered_results);

        if ($delete_option === 'note') {

          for ($i = 0; $i < $m; $i++) {

            $updated_index = $altered_results[$i];
            $sql_Query = 'UPDATE id17502183_maindb.users_notes SET id = ' . $updated_index . ' WHERE id = ' . $updated_index + 1;
            $stmt = $expected_conn->prepare($sql_Query);
            $stmt->execute();
          }
        } else if ($delete_option === 'song') {

          for ($i = 0; $i < $m; $i++) {

            $updated_index = $altered_results[$i];
            $sql_Query = 'UPDATE id17502183_maindb.users_songs SET id = ' . $updated_index . 'WHERE id = ' . $updated_index + 1;
            $stmt = $expected_conn->prepare($sql_Query);
            $stmt->execute();
          }
        }




        $auto_incrementation_value = $altered_results[$n - 1] + 1;


        if ($delete_option === 'note') {

          $sql_Query = 'ALTER TABLE id17502183_maindb.users_notes AUTO_INCREMENT = ' . $auto_incrementation_value;
          $stmt = $expected_conn->prepare($sql_Query);
          $stmt->execute();
        } else if ($delete_option === 'song') {

          $sql_Query = 'ALTER TABLE id17502183_maindb.users_songs AUTO_INCREMENT = ' . $auto_incrementation_value;
          $stmt = $expected_conn->prepare($sql_Query);
          $stmt->execute();
        }



        $expected_conn = null;
        return true;
      }
    }
  }

  public static function delete($delete_option = '', $expected_value = '')
  {

    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];
    $check = "don't display connect message";
    global  $expected_conn;
    $expected_conn = self::db_connect($check);

    if ($expected_conn !== false) {

      if ($delete_option === 'note') {

        return  self::processDelete($expected_conn, $expected_value, $userid, $username, $delete_option);
      } else if ($delete_option === 'song') {


        $target_dir = '../users_songs/songs_for_user_' . $username . '_ID_' . $userid . '/' . $expected_value;


        if (unlink($target_dir)) {
          $song_ready_for_database_deletion = true;
        } else {
          $song_ready_for_database_deletion = false;
        }


        if (isset($song_ready_for_database_deletion) && $song_ready_for_database_deletion === true) {

          return  self::processDelete($expected_conn, $expected_value, $userid, $username, $delete_option);
        }
      }
    }
  }

  public static function change_photo($given_photo)
  {

    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];

    $check = "don't display connect message";
    $conn = self::db_connect($check);

    if ($conn !== false) {

      $sql_Query = 'UPDATE id17502183_maindb.users SET user_photo =:given_photo WHERE userid =:userid AND username =:username';

      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':userid', $userid);
      $stmt->bindParam(':given_photo', $given_photo);

      if ($stmt->execute()) {

        $conn = null;
        return true;
      } else {

        $conn = null;
        return false;
      }
    }
  }



  private static function auto_incrementation($conn = null, $userid = '', $username = '', $witch_table = '')
  {

    if ($witch_table === 'songs') {

      $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_songs';
    } else if ($witch_table === 'notes') {

      $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_notes';
    } else if ($witch_table === 'users') {

      $sql_Query = 'SELECT `id` FROM id17502183_maindb.users';
    }

    $result = self::prepared_Statements($conn, $sql_Query, $userid, $username);

    $left_indexes = array();
    $n = count($result);

    for ($j = 0; $j < $n; $j++) {

      foreach ($result[$j] as $value) {

        $left_indexes[] = $value;
      }
    }

    $m = count($left_indexes);

    @$auto_incrementation_value = $left_indexes[$m - 1] + 1;

    if ($witch_table === 'songs') {

      $sql_Query = 'ALTER TABLE id17502183_maindb.users_songs AUTO_INCREMENT=' . $auto_incrementation_value;
    } else if ($witch_table === 'notes') {

      $sql_Query = 'ALTER TABLE id17502183_maindb.users_notes AUTO_INCREMENT=' . $auto_incrementation_value;
    } else if ($witch_table === 'users') {

      $sql_Query = 'ALTER TABLE id17502183_maindb.users AUTO_INCREMENT=' . $auto_incrementation_value;
    }




    $stmt = $conn->prepare($sql_Query);
    $stmt->execute();
  }



  private static function prepared_Statements($conn = null, $sql_Query = '', $userid = '', $username = '', $delete_option = '', $update_option = '', $limit = '')
  {

    if ($delete_option === 'on') {

      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':userid', $userid);
      $stmt->bindParam(':username', $username);
      $stmt->execute();
    } else if ($update_option === 'on') {

      $new_id = $userid;
      $old_id = $username;

      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':new_id', $new_id);
      $stmt->bindParam(':old_id', $old_id);
      $stmt->execute();
    } else {

      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':userid', $userid);
      $stmt->bindParam(':username', $username);
      $stmt->execute();

      if ($limit === 'limit') {

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
      } else {

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }


      return $result;
    }
  }


  public static function deleteAccount()
  {

    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];

    $check = "don't display connect message";
    $conn = self::db_connect($check);

    if ($conn !== false) {

      //User Songs Deletion Process starts here
      $target_dir = '../users_songs/songs_for_user_' . $username . '_ID_' . $userid;

      $sql_Query = 'SELECT `songname` FROM id17502183_maindb.users_songs WHERE user_id=:userid && user_name=:username';

      $result = self::prepared_Statements($conn, $sql_Query, $userid, $username);




      if ($result) {

        $n = count($result);
        $songs_for_user = [];

        for ($i = 0; $i < $n; $i++) {

          foreach ($result[$i] as $song) {

            $songs_for_user[] = $song;
          }
        }


        $n = count($songs_for_user);

        $indexes_of_user_songs = [];
        $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_songs WHERE user_id=:userid && user_name=:username';

        $result_for_id = self::prepared_Statements($conn, $sql_Query, $userid, $username);
        $p = count($result_for_id);

        for ($i = 0; $i < $p; $i++) {

          foreach ($result_for_id[$i] as $index) {

            $indexes_of_user_songs[] = $index;
          }
        }
        $p = count($indexes_of_user_songs);


        for ($i = 0; $i < $n; $i++) {

          unlink($target_dir . '/' . $songs_for_user[$i]);
        }
        unlink($target_dir . '/index.php');
        rmdir($target_dir);
        $sql_Query = 'DELETE FROM id17502183_maindb.users_songs WHERE user_id=:userid && user_name=:username';

        self::prepared_Statements($conn, $sql_Query, $userid, $username, 'on');

        for ($i = 0; $i < $p; $i++) {



          if ($i === $n - 1) {

            $last_user_song = $indexes_of_user_songs[$i];
            $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_songs WHERE id > ' . $last_user_song;
          } else {

            $lower_boundary = $indexes_of_user_songs[$i];
            $upper_boundary = $indexes_of_user_songs[$i + 1];
            $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_songs WHERE id > ' . $lower_boundary . '  AND id < ' . $upper_boundary;
          }

          $result = self::prepared_Statements($conn, $sql_Query, $userid, $username);


          $m = count($result);
          $new_between_indexes = [];

          for ($j = 0; $j < $m; $j++) {

            foreach ($result[$j] as $value) {

              $new_between_indexes[] = $value;
            }
          }



          $current_interval_index = $i;
          $m = count($new_between_indexes);
          $changing_value = $current_interval_index + 1;

          for ($j = 0; $j < $m; $j++) {


            $new_id = $new_between_indexes[$j] - $changing_value;
            $old_id = $new_between_indexes[$j];
            $sql_Query = 'UPDATE id17502183_maindb.users_songs SET id =:new_id  WHERE id=:old_id';


            self::prepared_Statements($conn, $sql_Query, $new_id, $old_id, 'off', 'on');
          }
        }

        self::auto_incrementation($conn, $userid, $username, 'songs');
      }


      //User Songs Deletion Process ends here       


      //User Notes Deletion Process starts here
      $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_notes WHERE user_id=:userid AND user_name=:username';

      $result = self::prepared_Statements($conn, $sql_Query, $userid, $username);


      $indexes_for_user_notes = [];

      $n = count($result);

      for ($i = 0; $i < $n; $i++) {

        foreach ($result[$i] as $note_id) {

          $indexes_for_user_notes[] = $note_id;
        }
      }




      $sql_Query = 'DELETE FROM id17502183_maindb.users_notes WHERE user_id=:userid && user_name=:username';

      self::prepared_Statements($conn, $sql_Query, $userid, $username, 'on');


      $n = count($indexes_for_user_notes);

      for ($i = 0; $i < $n; $i++) {



        if ($i === $n - 1) {

          $last_user_note = $indexes_for_user_notes[$i];
          $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_notes WHERE id > ' . $last_user_note;
        } else {

          $lower_boundary = $indexes_for_user_notes[$i];
          $upper_boundary = $indexes_for_user_notes[$i + 1];
          $sql_Query = 'SELECT `id` FROM id17502183_maindb.users_notes WHERE id > ' . $lower_boundary . '  AND id < ' . $upper_boundary;
        }

        $result = self::prepared_Statements($conn, $sql_Query, $userid, $username);

        $m = count($result);
        $new_between_indexes = [];

        for ($j = 0; $j < $m; $j++) {

          foreach ($result[$j] as $value) {

            $new_between_indexes[] = $value;
          }
        }
        $current_interval_index = $i;
        $m = count($new_between_indexes);
        $changing_value = $current_interval_index + 1;

        for ($j = 0; $j < $m; $j++) {


          $new_id = $new_between_indexes[$j] - $changing_value;
          $old_id = $new_between_indexes[$j];
          $sql_Query = 'UPDATE id17502183_maindb.users_notes SET id =:new_id  WHERE id=:old_id';

          self::prepared_Statements($conn, $sql_Query, $new_id, $old_id, 'off', 'on');
        }
      }

      self::auto_incrementation($conn, $userid, $username, 'notes');

      //User Notes Deletion Process ends here

      //User Photo from filesystem Deletion Process Starts Here 
      $sql_Query = 'SELECT `user_photo` FROM id17502183_maindb.users WHERE userid=:userid && username=:username LIMIT 1';

      $result =  self::prepared_Statements($conn, $sql_Query, $userid, $username, 'off', 'off', 'limit');

      if (!empty($result['user_photo'])) {

        $target_photo = '../users_photos/' . $result['user_photo'];

        @unlink($target_photo);
      }
      //User Photo from filesystem Deletion Process Ends Here



      $sql_Query = 'SELECT `id` FROM id17502183_maindb.users WHERE userid=:userid && username=:username LIMIT 1';

      $result_for_user_id = self::prepared_Statements($conn, $sql_Query, $userid, $username, 'off', 'off', 'limit');;

      $index_of_user = $result_for_user_id['id'];


      $sql_Query = 'SELECT id FROM id17502183_maindb.users WHERE id > ' . $index_of_user;

      $stmt = $conn->prepare($sql_Query);
      $stmt->execute();
      $results_for_users_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $l = count($results_for_users_id);
      $users_ids = [];


      for ($i = 0; $i < $l; $i++) {

        foreach ($results_for_users_id[$i] as $id) {

          $users_ids[] = $id;
        }
      }


      $sql_Query = 'DELETE FROM id17502183_maindb.users WHERE userid=:userid && username=:username';

      self::prepared_Statements($conn, $sql_Query, $userid, $username, 'on');

      $k = count($users_ids);


      for ($i = 0; $i < $k; $i++) {

        $current_index = $users_ids[$i];
        $new_index = $current_index - 1;


        $sql_Query = 'UPDATE id17502183_maindb.users SET id=:new_id WHERE id=:old_id';

        self::prepared_Statements($conn, $sql_Query, $new_index, $current_index, 'off', 'on');
      }
      self::auto_incrementation($conn, $userid, $username, 'users');

      if ($stmt->execute()) {

        $conn = null;
        return true;
      } else {

        $conn = null;
        return false;
      }
    }
  }


  public static function get_notes()
  {

    // $userid = $_SESSION['userid'];
    // $username = $_SESSION['username'];
    $check = "don't display connect message";
    $conn = self::db_connect($check);

    if ($conn !== false) {

      $sql_Query = 'SELECT `activity_date`,`user_name`,`user_id` FROM id17502183_maindb.users_notes';
      $stmt = $conn->prepare($sql_Query);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if ($results) {


        return $results;
        $conn = null;
      } else {

        $conn = null;
      }
    }
  }



  public static function get_user_email($expected_username, $expected_userid)
  {


    $check = "don't display connect message";
    $conn = self::db_connect($check);

    if ($conn !== false) {

      $sql_Query = 'SELECT `email` FROM id17502183_maindb.users WHERE username=:username && userid=:userid LIMIT 1';
      $stmt = $conn->prepare($sql_Query);
      $stmt->bindParam(':username', $expected_username);
      $stmt->bindParam(':userid', $expected_userid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {

        return $result;
        $conn = null;
      } else {

        $conn = null;
      }
    }
  }
}
