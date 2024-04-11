<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ' = ' . $value . '<br>';
    }
  $did = $_POST['did'];
  // Connect to the database
  $conn = new mysqli("localhost", "root", "", "store");

    
  // Update the user in the database
  $query = "select stat from delivery_personnel where did=$did";
  $retval = mysqli_query($conn,$query);
  $row = mysqli_fetch_assoc($retval);
  if ($row['stat']=="active"){
    $sql = "UPDATE delivery_personnel SET stat = 'inactive' WHERE did = $did";
    mysqli_query($conn, $sql);
    header("Location: deliveries.php");
    exit;
}
  else if ($row['stat']=="inactive"){
    $sql = "UPDATE delivery_personnel SET stat = 'active' WHERE did = $did";
    mysqli_query($conn, $sql);
    
    header("Location: deliveries.php");
  exit;
  }
  
}

?>