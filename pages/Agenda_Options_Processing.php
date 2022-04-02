<?php
if (!isset($_SESSION['userid'])) {
  header("Location: Sign_In.php");
}
if (isset($_POST['register_agenda_activity'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    require("Check_Note.php");
  } else {
    die("Invalid token or token expired!");
  }
}
if (isset($_POST['show_agenda_activities'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    $generated_Notes = Database_Management::generate('notes');
  } else {
    die("Invalid token or token expired!");
  }
}
if (isset($_POST['register_song'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    require("Check_Song.php");
  } else {
    die("Invalid token or token expired!");
  }
}
if (isset($_POST['Generate_Playlist'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    $username = $_SESSION['username'];
    $userid = $_SESSION['userid'];
    $target_dir = '../users_songs/songs_for_user_' . $username . '_ID_' . $userid;
    $myPlaylist = Database_Management::generate('playlist');
  } else {
    die("Invalid token or token expired!");
  }
}
if (isset($_POST['note_deletion'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    $specific_note = $_POST['note'];
    $result_for_Note_Deletion = Database_Management::delete('note', $specific_note);
  } else {
    die("Invalid token or token expired!");
  }
}
if (isset($_POST['deleteSong'])) {
  if ($_POST['token'] == $_SESSION['token']) {
    $specific_song = $_POST['current_song_for_deletion'];
    $result_for_Song_Deletion = Database_Management::delete('song', $specific_song);
  } else {
    die("Invalid token or token expired!");
  }
}
