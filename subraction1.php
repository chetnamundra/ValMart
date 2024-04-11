<?php
// Initialize the database connection
$conn = mysqli_connect("localhost", "root", "", "store");

// Get the user ID and product ID from the POST data
$uid = $_POST['uid'];
$pid = $_POST['pid'];

// Check if the item is already in the cart
$sql = "SELECT quan FROM cart WHERE uid=$uid AND pid='$pid'";
$retval = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($retval);
$quan = $row["quan"] - 1;

$sql1 = "SELECT quan FROM store_inv WHERE pid='$pid'";
$retval1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($retval1);
$store_quan = $row1["quan"];

if(mysqli_num_rows($retval) > 0) {
    if($quan == 0) {
        // If the quantity is zero, delete the row from the cart table
        $sql = "DELETE FROM cart WHERE uid=$uid AND pid='$pid'";
        mysqli_query($conn, $sql);
        // Show the "Add" button
        
        if ($store_quan > 0){
            $a = "cart";
            $a .= $pid;
            ?>
            <div id="<?php echo $a; ?>">
                <button id="add" class="btn btn-sm btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">Add</button>
            </div>
        <?php
        } else { 
            $a = "cart";
            $a .= $pid;
            ?>
            <div id="<?php echo $a; ?>">
                <button id="add" disabled class="btn btn-sm btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">Add</button>
            </div>
        <?php 
        }
    }  else {
        // Update the quantity in the cart table
        $sql = "UPDATE cart SET quan=$quan WHERE uid=$uid AND pid='$pid'";
        mysqli_query($conn, $sql);
        if($store_quan > $quan){
            $a = "cart";
            $a .= $pid;
            ?>
            <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
                <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
                <span id="quan" class="btn btn-default"><?php echo $quan; ?></span>
                <button id="plus" class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
            </div>
        <?php
        } else { 
            $a = "cart";
            $a .= $pid;
            ?>
          <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
            <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
            <span id="quan" class="btn btn-default  "><?php echo $quan; ?></span>
            <button id="plus" disabled class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
        </div>
    
  <?php }}}
    ?>
