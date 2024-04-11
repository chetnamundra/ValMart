<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        echo $key . ' = ' . $value . '<br>';
    }
  $oid = $_POST['oid'];
  $did = $_POST['did'];
  // Connect to the database
  $conn = new mysqli("localhost", "root", "", "store");

    
  // Update the user in the database
  $query = "select stat from orders where oid=$oid";
  $retval = mysqli_query($conn,$query);
  $row = mysqli_fetch_assoc($retval);
  if ($row['stat']=="ordered"){
    $sql = "call assign_order($oid,$did)";
    mysqli_query($conn, $sql);
    
    header("Location: deliveries.php");
    exit;
}
  else if ($row['stat']=="delivery confirmed"){
    $sql = "UPDATE orders SET stat = 'dispatched' WHERE oid = $oid";
    mysqli_query($conn, $sql);
    
    header("Location: deliveries.php");
  exit;
  }
  else if ($row['stat']=="dispatched"){
    $sql = "call complete_order($oid,$did);";
    mysqli_query($conn, $sql);
    
    
    header("Location: deliveries.php");
  exit;
  }

  
}

?>