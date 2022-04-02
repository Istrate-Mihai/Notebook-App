<?php
$activity_errors = array();
$date = getdate();
if ($date['mon'] < 10) {
  $current_Date = $date['mday'] . '/0' . $date['mon'] . '/' . $date['year'];
} else {
  $current_Date = $date['mday'] . '/' . $date['mon'] . '/' . $date['year'];
}
$date = $_POST['activity_date'];
$time = strtotime($date);
$new_activity_date = date('d/m/Y', $time);

if (empty($_POST['activity_title'])) {
  $activity_errors['activity_title'] = '<p style="color:white; font-weight:bold; font-size:22px;"><span style="color:red; font-weight:bold; font-size:22px;">!!!Warning: <br></span>You must enter a title for this activity!</p>';
} else if (!preg_match("/^[a-zA-Z0-9 ,.?!:]{1,250}$/", $_POST['activity_title'])) {
  $activity_errors['activity_title'] = '<p style="color:white; font-weight:bold; font-size:22px;"><span style="color:red; font-weight:bold; font-size:22px;">!!!Warning: <br></span>You must enter a title for this activiy that only contains capital letters(A-Z),<br>lowercase letters(a-z),digits(0-9), whitespaces or any of these characters<br>are allowed : , . ? - and !<br>Note:For the activiy title you can use from 1 to 250 of these legal characters.</p>';
} else {
  $activity_title = trim($_POST['activity_title']);
}
if (empty($_POST['activity_description'])) {
  $activity_errors['activity_description'] = '<p style="color:white; font-weight:bold; font-size:22px;"><span style="color:red; font-weight:bold; font-size:22px;">!!!Warning: <br></span>You must enter a description for this activity!</p>';
} else if (!preg_match("/^[a-zA-Z0-9 ,.?!:]{1,10000}$/", $_POST['activity_description'])) {
  $activity_errors['activity_description'] = '<p style="color:white; font-weight:bold; font-size:22px;"><span style="color:red; font-weight:bold; font-size:22px;">!!!Warning: <br></span>You must enter a description for this activiy that only contains capital letters(A-Z),<br>lowercase letters(a-z),digits(0-9), whitespaces or any of these characters<br>are allowed : , . ? - and !<br>Note:For the activiy description you can use from 1 to 10000 of these legal characters.</p>';
} else {
  $activity_description = trim($_POST['activity_description']);
}
if (empty($_POST['activity_date'])) {
  $activity_errors['activity_date'] = '<p style="color:white; font-weight:bold; font-size:22px;"><span style="color:red; font-weight:bold; font-size:22px;">!!!Warning: <br></span>You must enter a date for the activity!</p>';
} else {
  $new_activity_date = explode('/', $new_activity_date);
  $current_Date = explode('/', $current_Date);
  if (strcmp($new_activity_date[2], $current_Date[2]) < 0) {
    $activity_errors['activity_date'] = '<p style="color:white; font-weight:bold; font-size:22px;"><span style="color:red; font-weight:bold; font-size:22px;">!!!Warning: <br></span>You\'ve entered a date that has passed!</p>';
  } else if (strcmp($new_activity_date[2], $current_Date[2]) == 0) {
    if (strcmp($new_activity_date[1], $current_Date[1]) < 0) {
      $activity_errors['activity_date'] = '<p style="color:white; font-weight:bold; font-size:22px;"><span style="color:red; font-weight:bold; font-size:22px;">!!!Warning: <br></span>You\'ve entered a date that has passed!</p>';
    } else if (strcmp($new_activity_date[1], $current_Date[1]) == 0) {
      if (strcmp($new_activity_date[0], $current_Date[0]) < 0) {
        $activity_errors['activity_date'] = '<p style="color:white; font-weight:bold; font-size:22px;"><span style="color:red; font-weight:bold; font-size:22px;">!!!Warning: <br></span>You\'ve entered a date that has passed!</p>';
      } else {
        $activity_date = $_POST['activity_date'];
      }
    } else {
      $activity_date = $_POST['activity_date'];
    }
  } else {
    $activity_date = $_POST['activity_date'];
  }
}
