<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Guy</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
        font-family: "Lato", sans-serif;
        }

        .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        }

        .sidenav a, h4{
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
        }

        .sidenav a:hover {
        color: #f1f1f1;
        }

        .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
        }

        #main {
        transition: margin-left .5s;
        padding: 16px;
        }

        @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
        }
    </style>
</head>
<body>
    <?php
if($_POST && isset($_POST['Logout'])) { 
    
    header("Location: login_delivery.php");
    
}
?>
<div class="container mt-3" id="main">
    <div style="text-align:center; padding-bottom: 30px; margin: 35px;">
    <?php
        session_start();
        $conn = mysqli_connect("localhost", "root", "", "store");
        
        $did=$_SESSION["DID"];
         
        $query = "select stat from delivery_personnel where did=$did";
        $retval = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($retval);
        $stat=$row['stat'];
        ?>

<div id="mySidenav" class="sidenav" style="color: snow; text-align: left;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <h4 style="color: white; margin: bottom 20px; text-align: center;">Change Info</h4>
    <?php
    $query1 = "select delivery_name,phone_number, password from delivery_personnel where did=$did";
    $retval1 = mysqli_query($conn,$query1);
    $row1 = mysqli_fetch_assoc($retval1);
    $phone=$row1['phone_number'];
    $pass=$row1['password'];
    global $name;
    $name = $row1['delivery_name'];
    ?>
    <h5 class="mb-0" style="color: white; margin: 20px 0;">Change Phone number</h5>
    <form class="form"  role="form" autocomplete="off"action="updatephone.php" method="post">
      <input type="hidden" name="did" value="<?php echo $did; ?>">
        <div class="form-group" style="margin: 15px;">
            <label for="inputPasswordOld">Phone number</label>
            <input type="number" class="form-control" id="phone" name="phone" required="" value=<?php echo $phone ?>>
        </div>
        <div class="form-group" style="margin: 15px; text-align: center;">
            <button type="submit" class="btn btn-success btn-sm float-right">Save</button>
        </div>
    </form> 


<h5 class="mb-0" style="color: white; margin: 20px 0;">Change Password</h5> 
<form class="form" role="form" autocomplete="off" id="changePasswordForm">
    <div class="form-group" style="margin: 15px;">
        <label for="inputPasswordOld">Current Password</label>
        <input type="password" class="form-control" id="inputPasswordOld" required="">
    </div>
    <div class="form-group" style="margin: 15px;">
        <label for="inputPasswordNew">New Password</label>
        <input type="password" class="form-control" id="inputPasswordNew" required="">
        <span class="form-text small text-muted">
            The password must be 8-20 characters, and must <em>not</em> contain spaces.
        </span>
    </div>
    <div class="form-group" style="margin: 15px;">
        <label for="inputPasswordNewVerify">Verify</label>
        <input type="password" class="form-control" id="inputPasswordNewVerify" required="">
        <span class="form-text small text-muted">
            To confirm, type the new password again.
        </span>
    </div>
    <div class="form-group" style="margin: 15px; text-align: center;">
        <button type="submit" class="btn btn-success btn-sm float-right">Save</button>
    </div>
</form>
                  
</div>





        <div class="table-responsive" style="margin-bottom: 30px;">
  <table class="table table-hover table-striped">
    <thead class="table-dark ">
      <tr> <th style="width: 0;"></th>
        <th >
          <div class="row align-items-center justify-content-start" style="white-space: nowrap;">
            <div class="col-sm-4" style="text-align: left; padding-left: 10px;">
              <button class="openbtn" onclick="openNav()" style="color: white; background-color: transparent; border: none; outline: none;">
                <span class="material-symbols-outlined">manage_accounts</span>
              </button>
            </div>
            <div class="col-sm-4" style="text-align: center;">
              Welcome <?php echo $name; ?>
            </div>
            <div class="col-sm-4" style="text-align: right;">
              <!-- <button type="button" class="btn btn-outline-info">Logout</button> -->
              <form method = "post" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8"><input type="submit" class="btn btn-outline-info" name = "Logout" value="Logout"></form>
            </div>
          </div>
        </th>
        
        <th style="width: 0;"></th>
      </tr>
    </thead>
  </table>
</div>

        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 30px;">
            <h1 style="margin-right: 10px;">Set Status</h1>
            <form action="update_guy.php" method="post">
                <input type="hidden" name="did" value="<?php echo $did; ?>">
                <?php if ($stat=='inactive'){ ?>
                    <input type="submit" class="btn btn-outline-success btn-lg" value="Active">
                <?php } else if ($stat=='active'){ ?>
                    <input type="submit" class="btn btn-outline-danger btn-lg" value="Inactive">
                <?php } else if ($stat=='busy'){ ?>
                    <input type="submit" class="btn btn-outline-secondary disabled btn-lg" value="Busy">
                <?php } ?>
            </form>
        </div>

        <?php
        
        if ($row['stat']=="inactive"){
            ?><div></div><?php
        }else {?>
        
        <h1 style="text-align:center;">Current Delivery</h1>
        <div class="table-responsive" style="margin-bottom: 30px;">
            <table class="table table-hover table-striped">
                <thead class="table-dark ">
                    <tr>
                        <th>Order Number</th>
                        <th>Name of customer</th>
                        <th>Location</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                            
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "store");

                    $did=$_SESSION['DID'];

                    $sql = "Select o.oid,o.stat,u.addr_l1,u.addr_l2,u.addr_l3,u.user_name,u.phone_number from users u, orders o where u.uid=o.uid and o.stat in ('delivery confirmed','dispatched') and did=$did";
                    $retval = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($retval)>0) {
                        while ($row = mysqli_fetch_assoc($retval)){
                            $oid=$row['oid'];
                            $name=$row['user_name'];
                            $a1=$row['addr_l1'];
                            $a2=$row['addr_l2'];
                            $a3=$row['addr_l3'];
                            $phone=$row['phone_number'];
                            $stat=$row['stat'];
                            // $did=93;
                            ?>
                            <tr>
                            <td><?php echo $oid ?></td>
                            <td style="text-align: center;"><?php echo $name ?></td>
                            <td style="text-align: center;"><?php echo $a1 ?><br><?php echo $a2 ?><br><?php echo $a3 ?></td>
                            <td><?php echo $phone?></td>
                            <td>
                                <form action="update_status.php" method="post">
                                    <input type="hidden" name="oid" value="<?php echo $oid; ?>">
                                    <input type="hidden" name="did" value="<?php echo $did; ?>">
                                    <?php if ($stat=='delivery confirmed'){ ?>
                                    <input type="submit" class="btn btn-outline-success " value="dispatched">
                                    <?php } else if ($stat=='dispatched'){ ?>
                                    <input type="submit" class="btn btn-outline-success " value="delivered">
                                    <?php } ?>
                                </form>
                            </td>
                            </tr><?php
                            
                    }
                }
                    else {
                    $sql1 = "select o.oid,o.stat,u.addr_l1,u.addr_l2,u.addr_l3,u.user_name,u.phone_number from users u, orders o where u.uid=o.uid and o.stat='ordered'";
                    $retval1 = mysqli_query($conn, $sql1);
                    if(mysqli_num_rows($retval1)>0){
                        while ($row = mysqli_fetch_assoc($retval1)){
                            $oid=$row['oid'];
                            $name=$row['user_name'];
                            $a1=$row['addr_l1'];
                            $a2=$row['addr_l2'];
                            $a3=$row['addr_l3'];
                            $phone=$row['phone_number'];
                            // $did=93;
                            ?>
                            <tr>
                            <td><?php echo $oid ?></td>
                            <td><?php echo $name ?></td>
                            <td><?php echo $a1 ?><br><?php echo $a2 ?><br><?php echo $a3 ?></td>
                            <td><?php echo $phone ?></td>
                            <td><form action="update_status.php" method="post">
                                <input type="hidden" name="oid" value="<?php echo $oid; ?>">
                                <input type="hidden" name="did" value="<?php echo $did; ?>">
                                <input type="submit" class="btn btn-outline-success" value="confirm delivery">
                                </form>
                            </td></tr><?php


                        }
                    }
                }?>
   
                </tbody>
            </table>
        </div>
        <?php } ?>
        <h1 style="text-align:center;">Delivery History</h1>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark ">
                    <tr>
                        <th>Order Number</th>
                        <th>Name of customer</th>
                        <th>Location</th>
                        <th>Phone Number</th>
                        <th>Date of Delivery</th>
                    </tr>
                </thead>
                <tbody>
                            
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "store");
                    // $did=93;
                    $sql1 = "select o.oid,o.stat,u.addr_l1,u.addr_l2,u.addr_l3,u.user_name,u.phone_number,o.date_of_delivery from users u, orders o where u.uid=o.uid and o.stat='delivered' and o.did=$did order by o.date_of_delivery desc";
                    $retval1 = mysqli_query($conn, $sql1);
                    if(mysqli_num_rows($retval1)>0){
                        while ($row = mysqli_fetch_assoc($retval1)){
                            $oid=$row['oid'];
                            $name=$row['user_name'];
                            $a1=$row['addr_l1'];
                            $a2=$row['addr_l2'];
                            $a3=$row['addr_l3'];
                            $phone=$row['phone_number'];
                            $date=$row['date_of_delivery']
                            ?>
                            <tr>
                            <td><?php echo $oid ?></td>
                            <td><?php echo $name ?></td>
                            <td style="text-align: left;"><?php echo $a1 ?><br><?php echo $a2 ?><br><?php echo $a3 ?></td>
                            <td><?php echo $phone ?></td>
                            <td><?php echo $date ?></td>
                            </tr><?php
                        }
                    }?>

                </tbody>
            </table>
        </div>
    </div>

<script>
    function openNav() {
    document.getElementById("mySidenav").style.width = "350px";
    document.getElementById("main").style.marginLeft = "350px";
    }

    function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    }

    const form = document.getElementById("changePasswordForm");

form.addEventListener("submit", (event) => {
    event.preventDefault();

    const oldPassword = document.getElementById("inputPasswordOld").value;
    const newPassword = document.getElementById("inputPasswordNew").value;
    const newPasswordVerify = document.getElementById("inputPasswordNewVerify").value;

    if (newPassword !== newPasswordVerify) {
        alert("New passwords do not match.");
        return;
    }

    if (newPassword.length < 8 || newPassword.length > 20 || newPassword.includes(" ")) {
        alert("New password is not valid.");
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const responseText = xhr.responseText;
                if (responseText === "Password changed successfully.") {
                    alert(responseText);
                } else {
                    alert("Error occurred while changing password: " + responseText);
                }
            } else {
                alert("Error occurred while changing password.");
            }
        }
    };
    xhr.open("POST", "updatePassword.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`did=<?php echo $did; ?>&password=${newPassword}&oldPassword=${oldPassword}`);
});

</script>
    
</body>
</html>