<?php

if ($name === false) {
  $errors['Name'] = '<p style="color:blue; font-size:20px;">The <span style="color:red;text-decoration:underline;font-weight:bold;">Name</span> is not valid,only letters and white spaces allowed!</p>';
} else {
  $acceptedData['Name'] = $name;
}

if ($firstname === false) {
  $errors['Firstname'] = '<p style="color:blue; font-size:20px;">The <span style="color:red;text-decoration:underline;font-weight:bold;">First Name</span> is not valid,only letters and white spaces allowed!</p>';
} else {
  $acceptedData['Firstname'] = $firstname;
}

if ($email === false) {
  $errors['Email'] = '<p style="color:blue; font-size:20px;">Invalid <span style="color:red;text-decoration:underline;font-weight:bold;">Email</span> format,it must contain @ and .!</p>';
} else {
  $acceptedData['Email'] = $email;
}

if ($username === false) {
  $errors['Username'] = '<p style="color:blue; font-size:20px;">The <span style="color:red;text-decoration:underline;font-weight:bold;">User Name</span> is not valid,only letters and white spaces allowed!</p>';
} else {
  $acceptedData['Username'] = $username;
}


if ($password === false) {
  $errors['Password'] = '<p style="color:blue; font-size:20px;">The <span style="color:red;text-decoration:underline;font-weight:bold;">Password</span> is not valid,you must use at least eight of these characters: <br>digits (0-9),uppercase letters (A-Z),lowercase  letters (a-z)<br>characters like ? . , ! _ - ~ $ % + = </p>';
} else {
  $acceptedData['Password'] = $password;
}

if (isset($_POST['genderSelection']) && !($_POST['genderSelection'] === "Male" || $_POST['genderSelection'] === "Female")) {
  $errors['Gender'] = '<p style="color:blue; font-size:20px;">You must select <span style="color:red;text-decoration:underline;font-weight:bold;">Male or Female</span> as a gender!</p>';
} else {
  $acceptedData['Gender'] = $gender;
}
if (!isset($_POST['check_Conditions'])) {
  $errors['Policy'] = '<p style="color:blue; font-size:20px;">You must accept the <span style="color:red;text-decoration:underline;font-weight:bold;">Privacy Policy</span>!</p>';
} else {
  $policy = $_POST['check_Conditions'];
  $acceptedData['Policy'] = $policy;
}
