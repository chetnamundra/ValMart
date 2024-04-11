<?php

$conn = mysqli_connect("localhost", "root", "", "store");


$pid = $_POST['pid'];

// Check if the item is already in the cart
$sql = "SELECT quan FROM store_inv WHERE pid=\"$pid\"";
$retval = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($retval);
    $quan = $row["quan"] + 1;
    $sql = "UPDATE store_inv SET quan=$quan WHERE pid='$pid'";
    mysqli_query($conn, $sql);
    $a="cart";
    $a .=$pid;
    // Show the +/- buttons and updated quantity
    ?>
    <div id="<?php echo $a; ?>">
      <button id="minus" class="btn btn-outline-dark btn-sm" onclick="updateInv('subraction.php', '<?php echo $pid; ?>','<?php echo $a; ?>')" data-pid="<?php echo $pid; ?>">-</button>
      <span id="quan"><?php echo $quan; ?></span>
      <button id="plus" class="btn btn-outline-dark btn-sm" onclick="updateInv('addition.php', '<?php echo $pid; ?>','<?php echo $a; ?>')" data-pid="<?php echo $pid; ?>">+</button>
    </div>
    <?php
?>