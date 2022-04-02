<?php
function upload_photo($source, $destination)
{
  if (move_uploaded_file($source, $destination)) {
    return true;
  } else {
    return false;
  }
}
function determine_page_for_photo($given_page, $source_photo)
{
  if ($given_page === 'Sign Up' || $given_page === 'Profile') {
    $target_dir = '../users_photos/';
    $target_file = $target_dir . $source_photo['name'];
    $file_type = $source_photo['type'];
  }

  if (file_exists($target_file)) {
    echo '<p style="color: red; font-size: 20px;">A file named ' . $source_photo['name'] . ', already exists, please rename the file or submit an other file!</p>';
    return false;
  } else if ($source_photo['size'] === 0) {
    echo '<p style="color: red; font-size: 20px;">Please select a file!</p>';
    return false;
  } else if ($source_photo['size'] > 7000000) {
    echo '<p style="color: red; font-size: 20px;">Please select a file of size less than 7MB!</p>';
    return false;
  } else if ($file_type === 'image/jpeg') {
    upload_photo($source_photo['tmp_name'], $target_file);
  } else if ($file_type === 'image/bmp') {
    upload_photo($source_photo['tmp_name'], $target_file);
  } else {
    echo '<p style="color: red; font-size: 20px;">Only files of format:jpe, jpg, jpeg or bmp are allowed!</p>';
    return false;
  }
}
if ($chosen_page === 'Sign Up') {
  determine_page_for_photo($chosen_page, $_FILES['userPhoto']);
} else if ($chosen_page === 'Profile') {
  determine_page_for_photo($chosen_page, $_FILES['change_photo']);
}
