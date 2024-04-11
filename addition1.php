<?php
// Initialize the database connection
$conn = mysqli_connect("localhost", "root", "", "store");

// Get the user ID and product ID from the POST data
$uid = $_POST['uid'];
$pid = $_POST['pid'];
//echo "ok";
// Check if the item is already in the cart
$sql8 = "SELECT quan FROM cart WHERE uid=$uid AND pid = '$pid' ";
$retval = mysqli_query($conn, $sql8);


$sql1 = "SELECT quan FROM store_inv WHERE pid= '$pid' ";
$retval1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($retval1);
$store_quan = $row1["quan"];

// If the item is not in the cart, insert it with a quantity of 1
if(mysqli_num_rows($retval) == 0) {
    $sql = "INSERT INTO cart (uid, pid, quan) VALUES ($uid, '$pid', 1)";
    mysqli_query($conn, $sql);
  
    $quan=0;
    if($store_quan>$quan){
      $a="cart";
      $a .=$pid;
      ?>
      <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
      <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
      <span id="quan" class="btn btn-default  "><?php echo 1 ?></span>
      <button id="plus" class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
      </div>
  <?php
  }else{ 

      $a="cart";
      $a .=$pid; 
      ?>
      <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
      <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
      <span id="quan" class="btn btn-default  "><?php echo 1 ?></span>
      <button id="plus" disabled class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
      </div>
  <?php
  }
  
  
  } else {
    
    $row = mysqli_fetch_assoc($retval);
    $quan = $row['quan']+ 1;

    $sql = "UPDATE cart SET quan=$quan WHERE uid=$uid AND pid= '$pid'";
    mysqli_query($conn, $sql);

    if($store_quan>$quan){
      $a="cart";
      $a .=$pid;
      ?>
      <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
      <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
      <span id="quan" class="btn btn-default  "><?php echo $quan; ?></span>
      <button id="plus" class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
      </div>

    <?php
    }else{ 
      
      $a="cart";
      $a .=$pid; 
      ?>
    
      <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
      <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
      <span id="quan" class="btn btn-default  "><?php echo $quan; ?></span>
      <button id="plus" disabled class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
      </div>
    
  
    <?php
    }}?>
