<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin order history</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <style>
        
        details > summary {
  list-style: none;
}

details summary::-webkit-details-marker {
  display:none;
}
    </style>
</head>
<?php
if($_POST && isset($_POST['Logout'])) { 
    session_start();
    session_unset();
    session_destroy();
    header("Location: home1.php");   
}
?>
<body>
<?php
$conn = mysqli_connect("localhost", "root", "", "store");
 ?>
<div class="container mt-5">
        <div class="table-responsive" style="margin-bottom: 30px;">
            <table class="table table-hover table-striped">
                <thead class="table-dark ">
                    <tr>
                        <th style="text-align: left; padding-left: 10px">
                        <a href="admin.php" class="btn btn-outline-info">Store Inventory</a>
                        </th>
                        <th>ADMIN</th>
                        <th style="padding-right: 10px; text-align: right;">
                        <form method = "post" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8"><input type="submit" class="btn btn-outline-info" name = "Logout" value="Logout"></form>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>

  <h1 style="text-align: center;">Order History</h1>
  <div class="table-responsive">          
  <table class="table  ">
        <thead class="table-dark ">
            <tr><td></td><td>
            <div class="row"  style="text-align: center;">
                <div class="col-sm-1" > OID </div>
                <div class="col-sm-1" > UID </div>
                <div class="col-sm-1" > DID </div>
                <div class="col-sm-2" > Date of order </div>
                <div class="col-sm-2" > Date of delivery</div>
                <div class="col-sm-3" > status</div>
                <div class="col-sm-2" > TOTAL</div>
            </div>
</td><td></td></tr>
        </thead>
        <tbody>
            <?php 
            $sql = "Select * from orders order by oid";
            $retval = mysqli_query($conn, $sql);
            if(mysqli_num_rows($retval)>0) {
                while ($row = mysqli_fetch_assoc($retval)){
                    $oid=$row['OID'];
                    ?>
                    <tr><td><span class="material-symbols-outlined">
                            expand_circle_down
                            </span></td>
                    
                     <td> <details><summary><div class="row" style="text-align: center;"> 
                        
                     <div class="col-sm-1" ><?php echo $row['OID'] ?> </div>
                     <div class="col-sm-1" ><?php echo $row['UID'] ?> </div>
                     <div class="col-sm-1" ><?php echo $row['DID'] ?> </div>     
                     <div class="col-sm-2" ><?php echo  $row['Date_of_order'] ?> </div>
                     <div class="col-sm-2" ><?php echo $row['Date_of_delivery'] ?> </div>
                     <div class="col-sm-3" ><?php echo $row['stat'] ?> </div>
                     <div class="col-sm-2" ><span>&#8377;</span><?php echo $row['total'] ?> </div>
                </div>
                </summary>
                <div class="row" style="padding-top: 30px;" >
                <div class="col-sm-6" >
                    <h6 style="text-align: center;">BILL</h6>
                <div class="table-responsive">          
                    <table class="table table-hover ">
                    <thead class="table-dark " >
                        <tr>
                            <th style="font-weight: normal;">Product</th>
                            <th style="font-weight: normal;">Price</th>
                            <th style="font-weight: normal;">Quantity</th>
                            <th style="font-weight: normal;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql1 = "Select s.link,s.name,s.price,b.quan,b.price as amt from store_inv s, bills b where b.pid=s.pid and b.oid=$oid";
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
                    </tbody>
                    </table>
                </div></div>
                <div class="col-sm-3" >
                    <h6 style="text-align: center;"> Customer details </h6>
                    <?php
                    $uid=$row['UID'];
                    $sql2 = "Select * from users where uid=$uid";
                    $retval2 = mysqli_query($conn, $sql2);
                    if(mysqli_num_rows($retval2)>0) {
                        while ($row2 = mysqli_fetch_assoc($retval2)){
                            ?>
                            <div class="table-responsive">          
                            <table class="table table-hover table-bordered table-condensed ">
                                <tbody>
                            <tr>
                                <th class="table-dark" style="font-weight: normal;">Name</th>
                            <td><?php echo  $row2['User_name'] ?></td>
                            </tr>
                            <tr>
                                <th class="table-dark" style="font-weight: normal;">Email</th>
                            <td><?php echo  $row2['email'] ?></td>
                            </tr>
                            <tr>
                                <th class="table-dark" style="font-weight: normal;">Phone Number</th>
                            <td><?php echo  $row2['phone_number'] ?></td>
                            </tr>
                            <tr>
                                <th class="table-dark" style="font-weight: normal;">Address</th>
                            <td><?php echo  $row2['Addr_l1'] ?><br><?php echo  $row2['Addr_l2'] ?><br><?php echo  $row2['Addr_l3'] ?></td>
                            </tr>
                        </tbody>
                        </table>
                        </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-sm-3" >
                    <h6 style="text-align: center;"> Delivery details</h6>
                    <?php
                    $did=$row['DID'];
                    if($did!= NULL){
                        $sql2 = "Select * from delivery_personnel where did=$did";
                        $retval2 = mysqli_query($conn, $sql2);
                        if(mysqli_num_rows($retval2)>0 && $did != "") {
                            while ($row2 = mysqli_fetch_assoc($retval2)){
                                ?>
                                <div class="table-responsive">          
                                <table class="table table-hover  table-bordered table-condensed ">
                                    <tbody>
                                <tr>
                                    <th class="table-dark" style="font-weight: normal;">Name</th>
                                <td><?php echo  $row2['Delivery_name'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-dark" style="font-weight: normal;">Aadhaar Number</th>
                                <td><?php echo  $row2['aadhaar'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-dark" style="font-weight: normal;">Phone Number</th>
                                <td><?php echo  $row2['phone_number'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-dark" style="font-weight: normal;">License Number</th>
                                <td><?php echo  $row2['License_number'] ?></td>
                                </tr>
                                
                            </tbody>
                            </table>
                            </div>
                                <?php
                            }
                        }
                    }    
                    ?>
                </div>


                </detail>
                </td><td></td>
                </tr>
                <?php
                }
            }
            ?>

        
      
    </tbody>
  </table>
  </div>
</div>
    
</body>
</html>