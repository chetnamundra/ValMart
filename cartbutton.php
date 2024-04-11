<?php
$uid = $_POST['uid']; ?>
<div id="cartnewbutton">
    <div id="cart" onclick = "Sidebar()" >
        <img src="images/cart.jpg" alt="">
        <?php $conn = mysqli_connect("localhost", "root", "", "store");

        $sql = "SELECT COALESCE(SUM(quan), 0) AS total FROM cart WHERE uid = $uid";
        $retval = mysqli_query($conn, $sql);
        if (mysqli_num_rows($retval) > 0) {
            $row = mysqli_fetch_assoc($retval);
            $total = $row['total'];
            if ($total > 0) {
                echo '<p class = "cart-num" onchange = "cartItems()">' . $total . '</p>';
            } else {
                echo '<p class = "cart-num " onchange = "cartItems()">0</p>';
            }
        }else {
            echo '<p class = "cart-num" onchange = "cartItems()">0</p>';
        }
        ?>
    </div>
</div>