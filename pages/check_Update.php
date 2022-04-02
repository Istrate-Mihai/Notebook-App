<?php

function perform_Editting($expected_edit_choice = '', $expected_edit_value = '')
{
  global $editted_msj, $edited_field_info, $failed_validation;
  $expected_edit_value = trim($expected_edit_value);
  switch ($expected_edit_choice) {
    case 'name':
    case 'firstname':
    case 'username':
      $editted_validation = FormValidation::validate_strings($expected_edit_value);
      break;
    case 'password';
      $editted_validation = FormValidation::validate_password($expected_edit_value);
      break;
    case 'email':
      $editted_validation = FormValidation::validate_email($expected_edit_value);
      break;
    case 'gender':
      if ($expected_edit_value == 'Male') {
        $editted_validation = $expected_edit_value;
      } else if ($expected_edit_value == 'Female') {
        $editted_validation = $expected_edit_value;
      } else {
        $editted_validation = false;
      }
      break;
  }
  if (isset($editted_validation) && $editted_validation !== false) {
    $editted_msj = Database_Management::update_User_Info($editted_validation, $expected_edit_choice);
    $edited_field_info = $expected_edit_choice;
    if ($expected_edit_choice == 'password' && $editted_msj) {
      return $expected_edit_value;
    } else if ($expected_edit_choice == 'gender' && $editted_msj) {
      $user_password = $_SESSION['password'];
      $user_id = $_SESSION['userid'];
      $editted_gender = Database_Management::get_User_Data($user_id, $user_password);
      unset($_SESSION['gender']);
      $_SESSION['gender'] = $editted_gender['gender'];
    }
  } else {
    $failed_validation = true;
    $edited_field_info = $expected_edit_choice;
  }
}

if (isset($_POST['submit_edit_info'])) {
  if (isset($_POST['name'])) {
    if (!empty($_POST['name'])) {
      perform_Editting('name', $_POST['name']);
    } else {
      $alert = '<span style="color:red;font-size:24px;">Empty submitted name,no update performed!</span>';
    }
  } else if (isset($_POST['firstname'])) {
    if (!empty($_POST['firstname'])) {
      perform_Editting('firstname', $_POST['firstname']);
    } else {
      $alert = '<span style="color:red;font-size:24px;">Empty submitted firstname,no update performed!</span>';
    }
  } else if (isset($_POST['username'])) {
    if (!empty($_POST['username'])) {
      perform_Editting('username', $_POST['username']);
    } else {
      $alert = '<span style="color:red;font-size:24px;">Empty submitted username,no update performed!</span>';
    }
  } else if (isset($_POST['password'])) {
    if (!empty($_POST['password'])) {
      $result_for_password_update = perform_Editting('password', $_POST['password']);
      unset($_SESSION['password']);
      $_SESSION['password'] = $result_for_password_update;
    } else {
      $alert = '<span style="color:red;font-size:24px;">Empty submitted password,no update performed!</span>';
    }
  } else if (isset($_POST['gender'])) {
    if (!empty($_POST['gender'])) {
      perform_Editting('gender', $_POST['gender']);
    } else {
      $alert = '<span style="color:red;font-size:24px;">Empty submitted gender,no update performed!</span>';
    }
  } else if (isset($_POST['email'])) {
    if (!empty($_POST['email'])) {
      perform_Editting('email', $_POST['email']);
    } else {
      $alert = '<span style="color:red;font-size:24px;">Empty submitted email,no update performed!</span>';
    }
  }
}
