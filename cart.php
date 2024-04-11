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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link rel="stylesheet" type="text/css" href = "home1.css">
  <link rel="stylesheet" type="text/css" href = "cart.css">
  <script src = 'home1.js'></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

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

                    </button>
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
            
            
    </nav>
  
  <div class="container mt-5">

    <div class="row">
      <div class="col-sm-12" style="text-align: center;"> 
        <h1> BILLING INFORMATION </h1>
      </div>
    </div>

    <div class="row">
      <?php
      $conn = mysqli_connect("localhost", "root", "", "store");

      $sql = "Select * from users where uid=$uid";
      $retval = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($retval);?>

      <div class="col-sm-3">
        <p style="font-weight: bold;"> NAME : </p><br>
        <p> <?php echo  $row['User_name'] ?> </p>
      </div>
      <div class="col-sm-3">
        <p style="font-weight: bold;"> PHONE NUMBER : </p><br>
        <p> <?php echo  $row['phone_number'] ?> </p>
      </div>
      <div class="col-sm-3">
        <p style="font-weight: bold;"> EMAIL : </p><br>
        <p> <?php echo  $row['email'] ?> </p>
      </div>
      <div class="col-sm-3">
        <p style="font-weight: bold;"> SHIPPING & BILLING ADDRESS : </p><br>
        <p> <?php echo  $row['Addr_l1'] ?><br><?php echo  $row['Addr_l2'] ?><br><?php echo  $row['Addr_l3'] ?></p>
      </div>
    </div>
    <div class="row" style="padding-top: 30px;" >
      <div class="col-sm-12" >
          <h3 style="text-align: center;">BILL</h3>
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
          <tbody>
              <?php
              $sql1 = "Select s.link,s.name,s.price,c.quan,c.price as amt from store_inv s, cart c where c.pid=s.pid and c.uid=$uid";
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
              <tr>
                <td colspan="3">Total : </td>
                <?php
                if(isset($_SESSION['UID'])){
                        $sql = "SELECT COALESCE(SUM(price), 0) AS total FROM cart WHERE uid = $uid";
                        $retval = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($retval) > 0) {
                            $row = mysqli_fetch_assoc($retval);
                            $total_amt = $row['total'];
                    }
                  }
                  ?>
                <td><span>&#8377;</span><?php echo $total_amt ?></td>
              </tr>
                  
          </tbody>
          </table>
      </div>
    </div>
    <?php
      $sql5 = "SELECT count(*) as total from cart where uid=$uid";
      $retval5 = mysqli_query($conn, $sql5);

      if(mysqli_num_rows($retval5)>0) {
          $row5 = mysqli_fetch_assoc($retval5);
          global $total;
          $total = $row5['total'];   
      }
      ?>
    <div class="row">
      <div class="col-sm-12" style="text-align: center;"> 
      <form action="checkout.php" method="post" onsubmit="<?php if($total == 0 || !isset($_POST['terms'])) { ?>return showLoginAlert();<?php } ?>">
        <input type="hidden" name="uid" value="<?php echo $uid; ?>">
        <label>
          <input type="checkbox" name="terms" id="terms" required>
          I have read and agree to the <a href="#" id="terms-link" target="_blank">terms and conditions</a>.
        </label>
        <br>
        <input class="btn submit-btn" type="submit" name="submit" value="Confirm Order">
      </form>

      <?php if($total == 0) { ?>
    <script>
        function showLoginAlert() {
            alert("Please add items in cart to place an order");
            return false;
        }
    </script>
<?php } ?>
      </div>
    </div>
  </div>
  <div class="modal">
        <div class="modal-content">
          <h2>Terms and Conditions</h2>
          <ul>
            <li> No return/cancellation of Order is allowed.</li>
            <li> Any delay in Delivery of items does not come under our responsibility</li>
            <li> If items arent fresh/broken, can be replaced by calling our customer service</li>
            <li> Rate us on google and help us grow</li>
            <!-- <li> Sir give us full marks or ill call reddy anna gang</li>
            <li> What ra? Sudeep </li> -->
          </ul>

        </div>
      </div>
  
</body>
<script>
  // Get the modal and close button elements
const modal = document.querySelector('.modal');
const closeButton = document.createElement('span');
closeButton.className = 'close-modal';
closeButton.innerHTML = '&times;';

// Add the close button to the modal content
modal.querySelector('.modal-content').appendChild(closeButton);

// Open the modal when the terms link is clicked
document.querySelector('#terms-link').addEventListener('click', function(event) {
  event.preventDefault();
  modal.style.display = 'block';
});

// Close the modal when the overlay or close button is clicked
modal.addEventListener('click', function(event) {
  if (event.target === modal || event.target === closeButton) {
    modal.style.display = 'none';
  }
});

// Close the modal when the escape key is pressed
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    modal.style.display = 'none';
  }
});
</script>
</html>