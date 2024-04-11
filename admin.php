<?php
if($_POST && isset($_POST['Logout'])) { 


    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    
}
?>

<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $quan = $_POST['Quan'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $info = $_POST['info'];

    $imagename =$_FILES['img']['name'];

    $imagepath = 'images/';
    $link = $imagepath . $imagename;
    
    // Upload the image file
    $img_dir = '/Applications/xampp/htdocs/final/images/'; // Change this to your desired directory
    $img_file = $img_dir . basename($_FILES['img']['name']);
    move_uploaded_file($_FILES['img']['tmp_name'], $img_file);

    // Save the form data to a database using prepared statements
    $conn = new mysqli("localhost", "root", "", "store");
    $query = "INSERT INTO store_inv (pid, name, quan, price, category, link, info) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdiiss", $pid, $name, $quan, $price, $category, $link, $info);
    $stmt->execute();
    $stmt->close();

    // Redirect the user to a confirmation page
    header('Location: admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>store inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        #quan{
            width:50px;
            text-align: center;
        }
        #number{
            width: 7em;
        }
        #imgg{
            width: 10em;
        }
        .red{
            color : red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
    <div class="table-responsive" style="margin-bottom: 30px;">
            <table class="table table-hover table-striped ">
                <thead class="table-dark ">
                    <tr>
                        <th style="text-align: left; padding-left: 10px">
                        <a href="store_order.php" class="btn btn-outline-info">Order History</a>
                        </th>
                        <th>ADMIN</th>
                        <th style="padding-right: 10px; text-align: right;">
                         <form method = "post" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8"><input type="submit" class="btn btn-outline-info" name = "Logout" value="Logout"></form>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        <h1 style="text-align:center;">Store Inventory</h1>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark ">
                    <tr>
                        <th>PID</th>
                        <th>image</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Tagline</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form action="admin.php" method="post" enctype="multipart/form-data">
                            <td><input type="text" size=4 required name = "pid" value = "<?php if(isset($_POST['pid'])) echo htmlspecialchars($_POST['pid'])?>"></td>
                            <td><input type="file" id="imgg" size=5 id="img" name="img" accept="image/*"></td>
                            <td><input type="text" required name = "name" value = "<?php if(isset($_POST['name'])) echo htmlspecialchars($_POST['name'])?>"></td>
                            <td><input type="number" id="number" required name = "Quan" value = "<?php if(isset($_POST['quan'])) echo htmlspecialchars($_POST['quan'])?>"></td>
                            <td><input type="number" id="number" required name = "price" value = "<?php if(isset($_POST['price'])) echo htmlspecialchars($_POST['price'])?>"></td>
                            <td> <select name="category" >
                                <option value="baked goods<">baked goods</option>
                                <option value="canned">canned</option>
                                <option value="cereals">cereals</option>
                                <option value="Daily Essentials">Daily Essentials</option>
                                <option value="dairy">dairy</option>
                                <option value="Desserts">Desserts</option>
                                </select></td>
                            <td><input type="text" required name = "info" value = "<?php if(isset($_POST['info'])) echo htmlspecialchars($_POST['info'])?>">
                            <input type="submit" value="Add Item">
                            </td>
                        </form>
                    </tr>
                            
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "store");
                    $sql = "select * from store_inv order by quan";
                    $retval = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($retval)>0){
                        while ($row = mysqli_fetch_assoc($retval)){
                            if($row["quan"] <= 5){
                                echo "<td><span style=\"color: red;\">{$row['PID']}</td>";
                                echo "<td><span style=\"color: red;\"><img src=\"{$row['link']}\" style=\"width:50px;height:auto;\"></td>";
                                echo "<td><span style=\"color: red;\">{$row['Name']}</td>";
                                echo "<td><span style=\"color: red;\">";
                                $pid= $row['PID'];
                                $a="cart";
                                $a .=$pid; ?>
                                <div id="<?php echo $a; ?>">
                                    <button id="minus" class="btn btn-outline-dark btn-sm" onclick="updateInv('subraction.php', '<?php echo $pid; ?>','<?php echo $a; ?>')" data-pid="<?php echo $pid; ?>">-</button>
                                    <span id="quan" style="width:50px;"><?php echo $row['quan']; ?></span>
                                    <button id="plus" class="btn btn-outline-dark btn-sm" onclick="updateInv('addition.php', '<?php echo $pid; ?>','<?php echo $a; ?>')" data-pid="<?php echo $pid; ?>">+</button>
                                </div>
                                <?php 
                                echo "</td>";
                                echo "<td><span style=\"color: red;\"><span>&#8377;</span>{$row['price']}</td>";
                                echo "<td><span style=\"color: red;\">{$row['category']}</td>";
                                echo "<td><span style=\"color: red;\">{$row['info']}</td>";
                                echo "</tr>";
                            }
                            else{
                                echo "<td>{$row['PID']}</td>";
                                echo "<td><img src=\"{$row['link']}\" style=\"width:50px;height:auto;\"></td>";
                                echo "<td>{$row['Name']}</td>";
                                echo "<td>";
                                $pid= $row['PID'];
                                $a="cart";
                                $a .=$pid; ?>
                                <div id="<?php echo $a; ?>">
                                    <button id="minus" class="btn btn-outline-dark btn-sm" onclick="updateInv('subraction.php', '<?php echo $pid; ?>','<?php echo $a; ?>')" data-pid="<?php echo $pid; ?>">-</button>
                                    <span id="quan" style="width:50px;"><?php echo $row['quan']; ?></span>
                                    <button id="plus" class="btn btn-outline-dark btn-sm" onclick="updateInv('addition.php', '<?php echo $pid; ?>','<?php echo $a; ?>')" data-pid="<?php echo $pid; ?>">+</button>
                                </div>
                                <?php 
                                echo "</td>";
                                echo "<td><span>&#8377;</span>{$row['price']}</td>";
                                echo "<td>{$row['category']}</td>";
                                echo "<td>{$row['info']}</td>";
                                echo "</tr>";
                            }
                        }
                    }?>
                </tbody>
            </table>
        </div>
    </div>
<script>
    function updateInv(action, pid,a) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                // Update the shopping cart element with the response from the server
                    var cartElement = document.getElementById(a);
                    cartElement.innerHTML = xhr.responseText;
                } else {
                    console.error(xhr.status);  
                }
            }
        };
        xhr.open("POST", action);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("pid=" + pid);
    }   
</script>                           
</body>
</html>