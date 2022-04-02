<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
error_reporting(0);
require('../config.php');
require('Agenda_Options_Processing.php');
require('tokenSetting.php');
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> <?php $title = 'Agenda Options';
          echo $title; ?> </title>
  <link rel="stylesheet" type="text/css" href="../styles/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
      if (isset($activity_errors) && !empty($activity_errors)) {
        foreach ($activity_errors as $activity_error) {
          echo $activity_error . '<br>';
        }
      } else if (isset($activity_title) && isset($activity_description) && isset($activity_date)) {
        $result_for_Note_Registration = Database_Management::register_note($activity_title, $activity_description, $activity_date);
        if ($result_for_Note_Registration) {
          echo '<p style="color:blue; font-size: 20px;">The note was successfully registered in the database!</p>';
        } else {
          echo '<p style="color:red; font-size: 20px;">An error occurred while trying to register the note in the database!</p>';
        }
      } elseif (isset($result_for_Note_Deletion)) {
        if ($result_for_Note_Deletion) {
          echo '<p style="color:blue; font-size: 20px;">The note was successfully deleted from the database!</p>';
        } else {
          echo '<p style="color:blue; font-size: 20px;">An error occurred while trying to delete the note from the database!</p>';
        }
      } elseif (isset($result_for_Song_Deletion)) {
        if ($result_for_Song_Deletion) {
          echo '<p style="color:blue; font-size: 20px;">The song was successfully deleted from the database and the filesystem!</p>';
        } else {
          echo '<p style="color:red; font-size: 20px;">An error occurred while trying to delete the song, please try again!</p>';
        }
      }
      $Agenda_Options_Page = 'Agenda Options Page';
      $Activity_Form = new Content($Agenda_Options_Page, [], $_SESSION['token']);
      $Activity_Form->displayContent();
      if (isset($generated_Notes) && $generated_Notes === false) :
        echo '<p style="color:red; font-size:20px;">No results found</p>';
      elseif (isset($generated_Notes) && !empty($generated_Notes)) :
        $notenumber = 1;
      ?>
        <table>
          <tr>
            <th>Index</th>
            <th>Title</th>
            <th>Date</th>
            <th>Description</th>
            <th>Operations</th>
          </tr>
          <?php for ($i = 0; $i < count($generated_Notes); $i++) :  ?>
            <tr>
              <td><span style="padding:20px; font-weight: bold;"><?php echo $notenumber; ?></span></td>
              <?php foreach ($generated_Notes[$i] as $value) : ?>
                <td style="font-weight: bold;"><?php echo htmlspecialchars($value); ?></td>
              <?php endforeach; ?>
              <td>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="deleteNote">
                  <input type="submit" name="note_deletion" value="Delete Note">
                  <input type="hidden" name="note" value="<?php echo htmlspecialchars($value); ?>">
                  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                </form>
              </td>
            </tr>
        <?php $notenumber++;
          endfor;
        endif;
        ?>
        </table>
        <?php
        if (isset($myPlaylist)) {
          if ($myPlaylist === false) {
            echo '<p style="color:red; font-size:20px;">No results found</p>';
          } else {
            echo '<p style="color:blue; font-size:20px;">Here is your Playlist!</p>';
            $action_for_song_deletion = htmlspecialchars($_SERVER['PHP_SELF']);
            for ($i = 0; $i < sizeof($myPlaylist); $i++) {
              foreach ($myPlaylist[$i] as $key => $song) {
                echo '
                                     <h3>' . htmlspecialchars($song) . '</h3>
                                     <audio controls>
                                          <source src="' . $target_dir . '/' . $song . '" type="audio/mpeg">
                                       Your Browser is incompatible with the html audioplayer!
                                      </audio>
                                      <form class="songDeletion" action="' . $action_for_song_deletion . '" method="POST">
                                       <input type="hidden" name="current_song_for_deletion" value="' . htmlspecialchars($song) . '">
                                       <input type="hidden" name="token"  value="' . $_SESSION['token'] . '">
                                       <input type="submit" name="deleteSong" value="Delete Song">
                                      </form>
                                     ';
              }
            }
          }
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