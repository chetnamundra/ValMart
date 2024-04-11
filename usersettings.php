<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="home1.css">
    <link rel="stylesheet" type="text/css" href="order.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel = "stylesheet" href = 'usersettings.css'>
  </head>
  <body>
  <div class="shift"></div>
    
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

if (isset($_POST['Logout'])) { 
    session_destroy(); // destroy the session
    $uid = 1; // set $uid to 1
    header("Location: home1.php"); // redirect the user to the home page
    exit(); // stop executing the script
}   
      // Get the user's information
      $id = $uid; // replace with the actual user ID
      $query = "SELECT user_name, password, email, addr_l1,addr_l2,addr_l3, phone_number FROM users WHERE uid = $id";
      $result = $conn->query($query);
      $user = $result->fetch_assoc();
    ?>
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
                    <!-- <li><form method = "post" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                         accept-charset="UTF-8"><input type="submit" class="dropdown-item" name = "Logout" value="Logout"></form></li> -->
                </ul>
            </div>
        </div>
    </nav>
  <div id = 'columns' class = 'form-row' >  
    <div id = 'c1'>  
      <form class = 'form-group' action="user-settings.php" method="post">
      <br>
        <input type="hidden" name="uid" value="<?php echo $id; ?>">
        <label class="col-sm-2 col-form-label" for="name">Name:</label>
        <input type="text" id="name" name="User_name" value="<?php echo $user['user_name']; ?>">
        <input type="submit" class = 'btn btn-sm' name="submit" value="Update Name">
      </form>

      <form class = 'form-group ' action="user-settings.php" method="post">
        <input type="hidden" name="uid" value="<?php echo $id; ?>">
        <label class="col-sm-2 col-form-label" for="password">Password:</label>
        <input type="password" id="password" name="password" ><br>
        <label class="col-sm-2 col-form-label" for="password">Confirm_Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" class = 'btn btn-sm' name="submit" value="Update Password">
      </form>
      <form class = 'form-group' action="user-settings.php" method="post">
        <input type="hidden" name="uid" value="<?php echo $id; ?>">
        <label class="col-sm-2 col-form-label" for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone_number" value="<?php echo $user['phone_number']; ?>">
        <input type="submit" class = 'btn btn-sm' name="submit" value="Update Phone">
      </form>

      
    </div>
    <div id="c2">
    <form class = 'form-group' action="user-settings.php" method="post"><input type="hidden" name="uid" value="<?php echo $id; ?>">
        <label class="col-sm-2 col-form-label" for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" disabled>
      </form>
      <form  class = 'form-group'action="user-settings.php" method="post">
        <input type="hidden" name="uid" value="<?php echo $id; ?>">
        <label class="col-sm-2 col-form-label" for="address">Address line 1:</label>
        <input type="text" id="address" name="addr_l1" value="<?php echo $user['addr_l1']; ?>">
        <input type="submit" class = 'btn btn-sm' name="submit" value="Update Address line 1">
      </form>
    
      <form class = 'form-group' action="user-settings.php" method="post">
        <input type="hidden" name="uid" value="<?php echo $id; ?>">
        <label class="col-sm-2 col-form-label" for="address">line 2:</label>
        <input type="text" id="address" name="addr_l2" value="<?php echo $user['addr_l2']; ?>">
        <input type="submit" class = 'btn btn-sm' name="submit" value="Update Address  line 2">
      </form>

      <form class = 'form-group' action="user-settings.php" method="post">
      <input type="hidden" name="uid" value="<?php echo $id; ?>">
        <label class="col-sm-2 col-form-label" for="address">line 3:</label>
        <input type="text" id="address" name="addr_l3" value="<?php echo $user['addr_l3']; ?>">
        <input type="submit" class = 'btn btn-sm' name="submit" value='Update Address line 3'>
      </form>

      
    </div>
  </div> 
    

<script>
      const form = document.querySelector('#signup-form');

form.addEventListener('submit', (e) => {
  e.preventDefault();

  const password = form.querySelector('#password').value;
  const confirmPassword = form.querySelector('#confirm-password').value;


  if (password !== confirmPassword) {
    alert('Passwords do not match');
    return;
  }

  // send data to the server (using ajax or fetch)
});
        </script>
  </body>
</html>  