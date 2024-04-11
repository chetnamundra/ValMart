<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $did = $_POST['did'];
  $phone = $_POST['phone'];
  // Connect to the database
  $conn = new mysqli("localhost", "root", "", "store");

  
  // Update the user in the database
  $query = "UPDATE delivery_personnel SET phone_number = $phone WHERE did = $did";
  mysqli_query($conn, $query);
  
  // Return a success message
  echo "User updated successfully.";
  header("Location: deliveries.php");
  exit;
}

?>
