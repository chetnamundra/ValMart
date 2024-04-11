<!DOCTYPE html>
<title>valmart</title>
<head class = "a1">
    <link rel="stylesheet" type="text/css" href = "home1.css">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src = 'home1.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<body  >
    <div class="shift"></div>
    <nav id = "TopRibbon">
            <a href ="home1.php"><img id = 'logo' src="images/Llogo.jpg" alt=""></a>

            <div id="profile">
                <img src="images/user2.png" alt="user icon">
                <div class="dropdown" >
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                    <!-- Name of user -->
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
                    <?php
                    if(isset($_SESSION['UID'])){
                        echo "
                        <li><a class = 'dropdown-item' href=\"profile_page.php\">Account</a></li>
                        <li><a class = 'dropdown-item' href=\"order.php\">Order History</a></li>
                        <li><a class = 'dropdown-item' href=\"cart.php\">Cart</a></li>
                        <div class=\"dropdown-divider\"></div>
                        <li>"?><a class='dropdown-item' href="logout.php">Logout</a></li>
                        <?php
                    }
                    else{
                        echo"
                        <li><a class = 'dropdown-item' href=\"login.php\">Login</a></li>
                        <li><a class = 'dropdown-item' href=\"signup.php\">Signup</a></li>
                        ";
                    }
                    ?>
                    </ul>
                </div>
            </div>

            <div id="cartnewbutton">
                <div id="cart" onclick = "Sidebar()" >
                    <img src="images/cart.jpg" alt="">
                    <?php $conn = mysqli_connect("localhost", "root", "", "store");
                    if(isset($_SESSION['UID'])){
                        $sql = "SELECT COALESCE(SUM(quan), 0) AS total FROM cart WHERE uid = $uid";
                        $retval = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($retval) > 0) {
                            $row = mysqli_fetch_assoc($retval);
                            $total = $row['total'];
                            if ($total > 0) {
                                echo '<p class = "cart-num">' . $total . '</p>';
                            } else {
                                echo '<p class = "cart-num">0</p>';
                            }
                        }
                        else{
                            echo '<p class = "cart-num">0</p>';
                        }
                    }
                    
                    ?>
                </div>
            </div>
            <div id="searchBar">
                <form method="post">
                    <input type="text" id="search-input" name = "search" value = "<?php if(isset($_POST['search'])) echo htmlspecialchars($_POST['search'])?>" >
                    <button type="submit" name="btn" id="search-button" ><img src="images/search.png" onclick = "deleteFlex2()"></button>
                </form>
            </div>
    </nav>

    <div id ='slideshow'>
        <div id="leftB" onclick = 'slideshow(-1)'><</div>
        <img src="images/b1.jpg" alt="" class = 'slides' id = 'firstSlide'>
        <img src="images/b2.jpg" alt="" class = 'slides'>
        <img src="images/b3.jpg" alt="" class = 'slides'>
        <img src="images/b4.jpg" alt="" class = 'slides'>
        <img src="images/b5.jpg" alt="" class = 'slides'>
        <div id="rightB" onclick = 'slideshow(+1)'>></div>
</div>

<?php
    $r=0;
    if(!$conn){
        die('Could not connect: '.mysqli_connect_error());
    }

    function display($retval){
        global $conn,$uid;
        echo "<div class=\"flex-container2\" id = 'content'>";
        while($row = mysqli_fetch_assoc($retval)){
            echo "<div class=\"item\">";
            echo "<table class = \"gallery\">";
            echo "<tr class = \"tr\" style=\"height:250px;\" >";
            echo "<td colspan=\"2\" class=\"tr\">";
            $link = $row['link'];
            echo "<img src=$link >";
            echo "</td>";
            echo "</tr>";
            echo "<tr class=\"tr\">";
            echo "<td colspan=\"2\" class=\"tr\">";
            echo "<p class = \"elementname\">{$row['Name']}</p>";
            echo "</td>";
            echo "</tr>";
            echo "<tr class=\"tr\">";
            echo "<td class=\"tr\">";
            $price = $row['price'];
            echo "<p class=\"price\"><span>&#8377;</span>$price</p>";
            echo "</td>";
            echo "<td class=\"tr\" >";
            $pid = $row["PID"];
            $store_quan=$row["quan"];
            //echo $store_quan;
            

            $sql4 = "SELECT quan FROM CART where UID=$uid and PID='$pid'"; 
            $retval4 = mysqli_query($conn,$sql4);
            if(mysqli_num_rows($retval4) > 0) {
              $row4 = mysqli_fetch_assoc($retval4);
              $quan = $row4["quan"];
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
                $a .=$pid; ?>
              
                <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
                <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
                <span id="quan" class="btn btn-default  "><?php echo $quan; ?></span>
                <button id="plus" disabled class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
                </div>
              
            <?php } } else {

                  if ($store_quan>0){
                    $a="cart";
                    $a .=$pid;
                    ?>
                    <div id="<?php echo $a; ?>">
                        <button id="add" class ='btn btn-sm btn-primary' onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">Add</button>
                    </div>
                  <?php
                  } else { 
                    $a="cart";
                    $a .=$pid;
                    ?>
                  
                    <div id="<?php echo $a; ?>">
                        <button id="add" disabled class ='btn btn-sm btn-primary' onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">Add</button>
                    </div>
                  
                <?php }
            }
            
            


            echo "</td>";
                echo "</tr>";
                echo "<tr class=\"tr\">";
                echo "<td colspan=\"2\" class=\"tr\">";
                
                $supporting_info = $row['info'];
                echo "<p class=\"content\">$supporting_info</p>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "</div>";
            
        }
            echo "</div>";
    }

    $sql0 = "SELECT distinct(category) from STORE_INV"; 
    $retval0 = mysqli_query($conn,$sql0);

    if(mysqli_num_rows($retval0) > 0){
        echo "<div class=\"flex-container\" id='category'>";
        while($row0 = mysqli_fetch_assoc($retval0)){
            echo "<div class=\"categ\">";
            $v0 = $row0['category'];
            $v2 = explode(" ", $v0)[0];
    ?>
            <form method="post">
                <input type="submit" value=<?php echo "'$v0'" ?> name=<?php echo "'$v2'" ?>>
            </form>
    <?php
            echo "</div>";    
        }
        echo "</div>";
    }

    if($_POST && isset($_POST['search'])){
        $value_filter = $_POST['search'];
        $query = "SELECT * from store_inv where concat(Name) LIKE '%$value_filter%'";
        $retval = mysqli_query($conn, $query);

        if(mysqli_num_rows($retval) > 0){
            display($retval);
            echo "<div class=\"end-results\">";
            echo "<img src=\"images/no_res.png\" alt=\"Grocery basket\">";
            echo "<p>End of search results</p>";
            echo "</div>";
        }
        else{
            echo "<div class=\"end-results\">";
            echo "<img src=\"images/no_res.png\" alt=\"Grocery basket\">";
            echo "<p>We don't seem to offer $value_filter at the moment</p>";
            echo "</div>";
        }

        $sql = "SELECT * from STORE_INV";
        $retval = mysqli_query($conn, $sql);

        if(mysqli_num_rows($retval) > 0){
            display($retval);
        }
    }
    else{
        $sql0 = "SELECT distinct(category) from STORE_INV"; 
        $retval0 = mysqli_query($conn, $sql0); 
        $r = 0;   
        while($row0 = mysqli_fetch_assoc($retval0)){
            $v2 = $row0['category'];
            $v1 = $row0['category'];
            $v1 = explode(" ", $v1)[0];

            if(isset($_POST["$v1"])){
                $r = 1;
                $sql = "SELECT * from STORE_INV where category like '$v1%'";
                $retval = mysqli_query($conn, $sql);
                if(mysqli_num_rows($retval) > 0){
                    display($retval);
                    echo "<div class=\"end-results\">";
                    echo "<img src=\"images/no_res.png\" alt=\"Grocery basket\">";
                    echo "<p>End of search results</p>";
                    echo "</div>";
                }
            }
        }

        if ($uid!=1){
        ?>

        <div style="text-align:center; background-color: #f1dede; margin:0; padding:0;">
            <h3><b>Your go-to items - </b></h3><p> Based on your ordering prefernces </p>
        </div>
        <?php
        $recq="select s.pid as PID, s.quan, s.name as Name, sum(b.quan),s.info, s.link, s.price 
                from bills b, orders o, store_inv s
                where s.pid=b.PID
                and o.oid=b.OID
                and o.uid=$uid
                group by b.PID
                order by sum(b.quan) desc
                Limit 5";
        $recretval =  mysqli_query($conn, $recq);
        if(mysqli_num_rows($recretval) > 0){
            display($recretval);
        }

         ?>
         
        <div style="text-align:center; background-color: #f1dede; margin:0px; padding:0px;">
            <p> Our other products </p>
        </div>
        <?php
        }
        $sql = "SELECT * from STORE_INV";
        $retval = mysqli_query($conn, $sql);

        if(mysqli_num_rows($retval) > 0){
            display($retval);
        }
    }

?>


    <footer id = 'footer-toggle'>
        <div class="footer-content" >
            <h3>STAFF</h3>
            <div class="mails">
                <div class="mail-item">
                    <div>Customer Service</div>
                    <div>
                        <div class="material-symbols-outlined">support_agent</div>
                        <div>Amal (1BM21AI013)</div>
                    </div>
                    <div>
                        <div class="material-symbols-outlined">mail</div>
                        <div><a style="color:white;" href="mailto:amal.ai21@bmsce.ac.in">amal.ai21@bmsce.ac.in</a></div>
                    </div>
                </div>
                <div class="mail-item">
                    <div>Delivery</div>
                    <div>
                        <div class="material-symbols-outlined">support_agent</div>
                        <div>Chetna (1BM21AI036)</div>
                    </div>
                    <div>
                        <div class="material-symbols-outlined">mail</div>
                        <div><a style="color:white;" href="mailto:chetna.ai21@bmsce.ac.in">chetna.ai21@bmsce.ac.in</a></div>
                    </div>
                </div>
                <div class="mail-item">
                    <div>TroubleShooting</div>
                    <div>
                        <div class="material-symbols-outlined">support_agent</div>
                        <div>Adithya (1BM21AI036)</div>
                    </div>
                    <div>
                        <div class="material-symbols-outlined">mail</div>
                        <div><a style="color:white;" href="mailto:adithyagy.ai21@bmsce.ac.in">adithyagy.ai21@bmsce.ac.in</a></div>
                    </div>
                </div>
            </div>


            <ul class="socials">
                <li><a href="#"><i class="fa fa-facebook icon3d"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus icon3d"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube icon3d"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin-square icon-3d"></i></a></li>
            </ul>
        </div>
    </footer>
    <div id="footer-bottom">
        <p>copyright &copy; <a href="#">ValMart</a>  </p>
        <div id = 'contact' onclick = 'footerToggle()'>&#8679;</div>
                <div class="footer-menu">
                    <ul class="f-menu">
                    <li><a href="https://goo.gl/maps/fLnEjcRHiGUgSVBQ7" target=”_blank” >Home</a></li>
                    <li><a href="https://docs.google.com/document/d/1JZd4O3NVBX2GBIQ-HLqVd4KrAN1kr4AxO3bGMPVKG18/edit?usp=sharing" target=”_blank” >About</a></li>
                    <li><a href="mailto:adithyagy.ai21@bmsce.ac.in">Contact</a></li>
                    </ul>
                </div>
    </div>


<div id="sidebar">
        <p>shopping cart</p>
        <div id = 'close' onclick = 'Sidebar()'>&times;</div>
        <div class="table-responsive" id="recentcart">
    
        <table class="table ">
            <thead><tr>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Amount</th></tr>
            </thead>
            <tbody>
            <?php
            $sql5 = "SELECT s.pid,s.quan as store_quan, s.link,s.price,s.name,c.quan,c.price as amt from store_inv s, cart c where s.pid=c.pid and c.uid=$uid"; 
            $retval5 = mysqli_query($conn, $sql5);
            $total = 0;
            if (mysqli_num_rows($retval5) > 0) {
                while ($row5 = mysqli_fetch_assoc($retval5)) {
                    $pid= $row5['pid'];
                    $link = $row5['link'];
                    $price = $row5['price'];
                    $name = $row5['name'];
                    $quan = $row5['quan'];
                    $amt = $row5['amt'];
                    $store_quan=$row5['store_quan'];
                    $total += $amt;
                    echo "<tr class = 'cart-item'>";
                    echo "<td><img src=\"$link\" style=\"width:20px;height:20px;\">$name</td>";
                    echo "<td>$price</td>";
                    if($store_quan>$quan){
                        $a="cart";
                        $a .=$pid;
                        ?><td>
                        <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
                        <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
                        <span id="quan" class="btn btn-default  "><?php echo $quan; ?></span>
                        <button id="plus" class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
                        </div></td>
                    <?php
                    }else{ 
                        $a="cart";
                        $a .=$pid; 
                        ?>
                        <td>
                        <div id="<?php echo $a; ?>" class="btn-group btn-group-xs">
                        <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
                        <span id="quan" class="btn btn-default  "><?php echo $quan; ?></span>
                        <button id="plus" disabled class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
                        </div></td>
                    
                    <?php } 
                    echo "<td>$amt</td>";
                    echo "</tr>";
                }
            }
            mysqli_close($conn);
            ?>
            <tr class = 'cart-item'>
                <td colspan="3">Total:</td>
                <td><?php echo $total; ?></td>
                
            </tr>
            <tr id = 'checkout' class = 'cart-item'>
                <td colspan = "4"> 
                    
                <form action="cart.php" method="post" onsubmit="<?php if($uid == 1) { ?>return showLoginAlert();<?php } if($total == 0) { ?>return showCartEmptyAlert();<?php } ?>">
                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                    <input class="btn" type="submit" name="submit" value="Proceed to Checkout">
            </form>

            <?php if($uid == 1) { ?>
                <script>
                    function showLoginAlert() {
                        alert("Please login first!");
                        return false;
                    }
                </script>
            <?php } ?>

            <script>
                function showCartEmptyAlert() {
                    alert("Your cart is empty. Please add items to proceed to checkout.");
                    return false;
                }
            </script>

                </td>
            </tr>   
        
        
        </tbody>
        </table>
    </div>
</div>

<div class="shift"></div>
</body>

