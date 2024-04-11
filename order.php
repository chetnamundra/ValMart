<!DOCTYPE html>
<title>valmart</title>

<head class="a1">
    <link rel="stylesheet" type="text/css" href="home1.css">
    <link rel="stylesheet" type="text/css" href="order.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src='home1.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "STORE";
    global $conn;
    $conn = mysqli_connect($host,$user,$pass,$database);

    session_start(); // start the session

// set $uid to 1 if the user is not logged in
if (!isset($_SESSION['UID'])) {
    $uid = 1;
} else {
    // set $uid to the same value if the user is logged in
    $uid = $_SESSION['UID'];
}

?>

<body>
    <div class="shift"></div>
    <nav id="TopRibbon">
        <a href="home1.php"><img id='logo' src="images/Llogo.jpg" alt=""></a>

        <div id="profile">
            <img src="images/user2.png" alt="user icon">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                <?php
                        
                        if(isset($_SESSION['UID'])){
                            $sql_fetch = "select * from users where uid = $uid";
                            $retval_fetch = mysqli_query($conn, $sql_fetch);
                            if (mysqli_num_rows($retval_fetch) > 0) {
                                $row_fetch = mysqli_fetch_assoc($retval_fetch);
                                echo $row_fetch['User_name'];
                            }
                        }
                    ?>
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a class='dropdown-item' href="profile_page.php">Account</a></li>
                    <li><a class='dropdown-item' href="order.php">Order History</a></li>
                    <li><a class='dropdown-item' href="cart.php">Cart</a></li>
                    <div class="dropdown-divider"></div>
                    <li><a class='dropdown-item' href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

<?php
$r=0;
$host = "localhost";
$user = "root";
$pass = "";
$database = "STORE";
$conn = mysqli_connect($host,$user,$pass,$database);
if(!$conn){
    die('Could not connect: '.mysqli_connect_error());
}
?>


    <div class='wrapper'>
        <h1 id='Heading'>
            Your Orders
        </h1>

        <div class="table-responsive">          
            <table class="table  ">
            <thead class="table-dark ">
                <tr><td></td><td>
                <div class="row"  style="text-align: center;">
                    <div class="col-xs-1">Order ID</div>
                    <div class="col-xs-2">Ordering Date</div>
                    <div class="col-xs-2">Date of Delivery</div>
                    <div class="col-xs-1">Status</div>
                    <div class="col-xs-1">Total</div>
                    <div class="col-xs-3">Delivery personnel</div>
                    <div class="col-xs-2">Delivery Contact</div>
                </div>
                </td><td></td></tr>
        </thead>
        <tbody>
        <?php
        $sql0 = "SELECT * from orders WHERE UID = $uid order by OID desc;";
        $retval0 = mysqli_query($conn,$sql0);
        if(mysqli_num_rows($retval0)>0){
            while($row = mysqli_fetch_assoc($retval0)){

                $oid = $row['OID'];
                $doo = $row['Date_of_order'];
                $dod = $row['Date_of_delivery'];
                if ($dod == NULL){
                    $dod  = "Your order will be delivered within 5 business days of order date";
                }
                $price = $row['total'];
                $stat = $row['stat'];
                $DID = $row['DID'];
                if($DID == NULL){
                    $name =  "your order has been placed. It will be confirmed by one of our delivery personnel shortly";
                    $phone = "You will be able to view a phone number after a driver has confirmed your order";
                }
                else{
                    $get_driver_detials = "SELECT * from Delivery_personnel WHERE DID = $DID";
                    $retval1 = mysqli_query($conn,$get_driver_detials);
                    if(mysqli_num_rows($retval1)>0){
                        while($row2 = mysqli_fetch_assoc($retval1)){                            
                            $name = $row2['Delivery_name'];
                            $phone = $row2['phone_number'];                            
                        }
                    }
                }

                echo '
                <tr><td><span class="material-symbols-outlined">
                expand_circle_down
                </span></td></td>
                        
                            <td> <details><summary><div class="row" style="text-align: center;">
                                    <div class="col-xs-1" >',$oid,'</div>
                                    <div class="col-xs-2" >',$doo,'</div>
                                    <div class="col-xs-2" >',$dod,'</div>
                                    <div class="col-xs-1" >',$stat,'</div>
                                    <div class="col-xs-1" ><span>&#8377;</span>',$price,'</div>                                    
                                    <div class="col-xs-3"  id = \'orderID\'>',$name,'</div>
                                    <div class="col-xs-2" >',$phone,'</div>
                                </div>
                            </summary>
                            <div class="table-responsive">          
                            <table class="table table-hover ">
                            <thead>
                                <tr>
                                    <th >Product</th>
                                    <th >Price</th>
                                    <th >Quantity</th>
                                    <th >Amount</th>
                                </tr>
                            </thead>
                            <tbody>';?>
                                <?php
                                $sql1 = "Select s.link,s.name,s.price,c.quan,c.price as amt from store_inv s, bills c where c.pid=s.pid and c.oid=$oid";
                                $retval1 = mysqli_query($conn, $sql1);
                  
                                if(mysqli_num_rows($retval1)>0) {
                                    while ($row1 = mysqli_fetch_assoc($retval1)){
                                        ?>
                                        <tr>
                                        <td><img src="<?php echo  $row1['link'] ?>"  width="30px" height="auto">
                                            <?php echo  $row1['name'] ?></td>
                                        <td><span>&#8377;</span><?php echo  $row1['price'] ?></td>
                                        <td><?php echo  $row1['quan'] ?></td>
                                        <td><span>&#8377;</span><?php echo $row1['amt'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                <tr>
                                  <td colspan="3">Delivery charges : </td>
                                  <td><span>&#8377;</span><s>40</s><span>&#8377;</span>0</td>
                                </tr>
                                
                                    
                            </tbody>
                            </table>
                        </div>
                        </details>
                        </td><td></td>
                        </tr>
                        
                   
                <?php }
            }
            
        ?>
        </tbody>
  </table>
    </div>


 