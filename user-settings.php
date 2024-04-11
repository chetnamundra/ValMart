<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo count($_POST);
  next($_POST);
  $field = key($_POST);
  $value = $_POST[$field];
  $id = $_POST['uid'];
  // Connect to the database
  $conn = new mysqli("localhost", "root", "", "store");

  echo $id," ", $value," ", $field;
  
  // Update the user in the database
  $query = "UPDATE users SET $field = '$value' WHERE uid = $id";
  $conn->query($query);
  
  // Return a success message
  echo "User updated successfully.";
  header("Location: usersettings.php");
  exit;
}

?>
