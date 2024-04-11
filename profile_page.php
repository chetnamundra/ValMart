<?php
 $conn = new mysqli("localhost", "root", "", "store");
 session_start(); // start the session
 
// set $uid to 1 if the user is not logged in
if (!isset($_SESSION['UID'])) {
  $uid = 1;
} else {
  // set $uid to the same value if the user is logged in
  $uid = $_SESSION['UID'];
}

 ?>
<!DOCTYPE html>
<title>Profile Page</title>
<head class = "a1">
    <link rel="stylesheet" type="text/css" href = "home1.css">
    <link rel="stylesheet" type="text/css" href = "profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src = 'home1.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="shift"></div>
    <nav id = "TopRibbon">
        <a href ="home1.php"><img id = 'logo' src="images/Llogo.jpg" alt=""></a>

            <div id="profile">
                <img src="images/user2.png" alt="user icon">
                <div class="dropdown" >
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
                        else{
                            echo"Hello There";
                        }                   
                        
                    ?>
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                    <li><a class = 'dropdown-item' href="profile_page.php">Account</a></li>
                    <li><a class = 'dropdown-item' href="order.php">Order History</a></li>
                    <li><a class = 'dropdown-item' href="cart.php">Cart</a></li>
                    <div class="dropdown-divider"></div>
                    <li><a class = 'dropdown-item' href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>

            
    </nav>
    <style>
    a,a:hover{
        color: #000000;
    }
    </style>

    <div class = 'wrapper'>
        <h1 id ='Heading'>
            Your Account
        </h1>
        
        <div id = 'columns2'>
            <div id = 'c1'>
                <a href = "order.php" >
                    <div class = 'box' >
                        <div class = 'iconBG'>
                            <img src="images/order1.png" class = "icons" alt = ''>
                        </div>
                        <div class = 'text'>
                            <h2>
                                Orders
                            </h2>
                            <div class = 'subtext'>
                                View orders
                            </div>
                        </div>
                    </div>
                </a>    
            <a href ="cart.php">   
                    <div class = 'box'>
                        <div class = 'iconBG'>
                            <img src="images/cart2.png" class = "icons" alt = ''>
                        </div>
                        <div class = 'text'>
                            <h2>
                                Cart
                            </h2>
                            <div class = 'subtext'>
                                Items currently <br>in your cart
                            </div>
                        </div>
                    </div>
                </div>
            </a>     
            
            <div id = "c2">
                <a href = "usersettings.php">       
                    <div class = 'box'>
                        <div class = 'iconBG'>
                            <img src="images/user2.png" class = "icons" alt = ''>
                        </div>
                        <div class = 'text'>
                            <h2>
                                Login Info
                            </h2>
                            <div class = 'subtext'>
                                Password, Mobile No,<br> Name
                            </div>
                        </div>
                    </div>
                </a> 
                <a href = 'home1.php'>
                    <div class = 'box'>
                        <div class = 'iconBG'>
                            <img src="images/home.png" class = "icons" alt = ''>
                        </div>
                        <div class = 'text'>
                            <h2>
                                Home 
                            </h2>
                            <div class = 'subtext'>
                                
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>