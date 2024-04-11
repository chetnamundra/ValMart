<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $uid = $_POST['uid'];
  // Connect to the database
  $conn = new mysqli("localhost", "root", "", "store");


  // Update the user in the database
  $query = "call order_user($uid)";
  $retval0 = mysqli_query($conn, $query);
  if(mysqli_num_rows($retval0)>0){
    $row = mysqli_fetch_assoc($retval0);
    if($row['ERROR'] == "ERROR"){
    echo'<script language = "javascript">alert("Order could not be placed. One or more items have run out of stock");
    location = "cart.php";
    </script>';
    }
    else{  
      // Return a success message
      echo "User updated successfully.";
      echo'<script language = "javascript">alert("order placed successfully");
      location = "order.php";
      </script>';
      
      exit;
    }
  }
}

?>
