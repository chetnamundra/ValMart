<?PHP
// form handler
if($_POST && isset($_POST['name'],$_POST['password'],$_POST['email'],$_POST['phone'],$_POST['confirm_password'],$_POST['ad1'],$_POST['ad2'],$_POST['ad3'])) {   
    
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "STORE";
    $conn = mysqli_connect($host,$user,$pass,$database);
    if(!$conn){
        die('Could not connect: '.mysqli_connect_error());
    }
    echo 'Connected successfully<br>';    
    
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $ad1 = $_POST['ad1'];
    $ad2 = $_POST['ad2'];
    $ad3 = $_POST['ad3'];
    $confirm_password = $_POST['confirm_password'];

    $sql2 = "SELECT email from users where email='$email'";
    $retval0 = mysqli_query($conn,$sql2);
    if(mysqli_num_rows($retval0)>0){
       
        echo "<script language='javascript'>
        alert('Email already exists. Try logging in');
        window.location.href='signup.php';
        </script>
        ";
        die;
           
    }
    if (strlen($password) < 8 ||strlen($password) >20  ){
        echo "<script language='javascript'>
        alert('Password length should be between 8 and 20');
        window.location.href='signup.php';
        </script>
        ";
        die;

    }
    if($password != $confirm_password){
        echo "<script language='javascript'>
        alert('Passwords do not match.');
        window.location.href='signup.php';
        </script>
        ";
        die;                
    }
    else if(!is_numeric($phone)){
        echo "<script language='javascript'>
                alert('Please enter a valid phone number');
                </script>
                ";         
    }
    else{
        $sql2 = "SELECT MAX(UID) from users";
        $retval0 = mysqli_query($conn,$sql2);
        if(mysqli_num_rows($retval0)>0){
            $row0 = mysqli_fetch_assoc($retval0);
            $v0 = $row0['MAX(UID)'];
            $v1 = $v0+1;
    
            $hashed_pass= password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT into users values($v1,'$name','$phone','$email','$hashed_pass','$ad1','$ad2','$ad3')";
            $retval = mysqli_query($conn,$sql);
            
            header("Location:login.php");
        }
        
        echo'<script>function validate(){alert("procceding to login page");return true;}</script>';

    }
    
   
}
?>

<!DOCTYPE html>
    <head>
        
        <title>Welcome</title>
        <link rel='stylesheet' type = 'text/css' href = 'selector.css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    <div class="row">
        
        <div class="col-md-6">
            
            <div id = 'logo'><img src="images/LlogoT.png" width="400px"></div>
           
            <div id = "login-card">
                <a  href="signup.php"><button class='btn btn-lg'>Sign Up</button></a>
                <a  href="login.php"><button class='btn btn-lg'>User Log In</button></a>
                <a  href="login_delivery.php"><button class='btn btn-lg'>Delivery Personnel Log In</button></a>
                <a  href="admin_login.php"><button class='btn btn-lg'>Admin Log In</button></a>
                <a  href="mailto:adithyagy.ai21@bmsce.ac.in"><button class='btn btn-lg'>Want to join us? Contact Us</button></a>
            </div>

        </div>
        <div class="col-md-6" id="something" >
        <div class="center" style="width: 700px;" >
            <h1>Sign Up</h1>
            
        
            <form method="post" onsubmit = "return validate()">
                
                <table width="100%" >
                <tr><td>
                <div class="type1" style="width:310px; margin-right:10px;">
                    <input type="text"  required name = "name" value = "<?php if(isset($_POST['name'])) echo htmlspecialchars($_POST['name'])?>">
                    <span></span>
                    <label>Name</label>
                </div>
                <div class="type1" style="width:310px; margin-right:10px;">
                    <input type="email" required name = "email" value = "<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email'])?>">
                    <span></span>
                    <label>Email</label>
                </div>
                <div class="type1" style="width:310px; margin-right:10px;">
                    <input type="password" required name = "password" value = "<?php if(isset($_POST['password'])) echo htmlspecialchars($_POST['password'])?>" >
                    <span></span>
                    <label>Create Password</label>
                </div>
                <div class="type1" style="width:310px; margin-right:10px;">
                    <input type="password"  required name = "confirm_password" value = "<?php if(isset($_POST['confirm_password'])) echo htmlspecialchars($_POST['confirm_password'])?>">
                    <span></span>
                    <label>Confirm Password</label>
                </div>
                
                </td>
                <td>
                <div class="type1" style="width:310px; margin-left:10px;">
                <input type="number" required name = "phone" value = "<?php if(isset($_POST['phone'])) echo htmlspecialchars($_POST['phone'])?>">
                    <span></span>
                    <label>Phone Number</label>
                </div>
               
                <div class="type1"  style="width:310px; margin-left:10px;">
                    <input type="text" required name = "ad1" value = "<?php if(isset($_POST['ad1'])) echo htmlspecialchars($_POST['ad1'])?>" >
                    <span></span>
                    <label>Address Line 1</label>
                </div>
                <div class="type1" style="width:310px; margin-left:10px;">
                    <input type="text" required name = "ad2" value = "<?php if(isset($_POST['ad2'])) echo htmlspecialchars($_POST['ad2'])?>">
                    <span></span>
                    <label>Address Line 2</label>
                </div>
                <div class="type1" style="width:310px; margin-left:10px;">
                    <input type="text"required name = "ad3" value = "<?php if(isset($_POST['ad3'])) echo htmlspecialchars($_POST['ad3'])?>" > 
                    <span></span>
                    <label>Address Line 3</label>
                </div>
                
                
                </td>
            </tr>
                <tr>
                    <td colspan=2>
                
                    <input type="submit" value="Sign Up">
            </td>
            </tr>
            <tr><td> Password should be between 8 to 20 characters. </td></tr>
            
                
            </form>

        </table>
        </div>
        </div>
    </div>
    <div class="ripple-background">
        <div class="circle shade1 xxlarge" ></div>
        <div class="circle shade2 xlarge" ></div>
        <div class="circle shade3 large" ></div>
        <div class="circle shade4 medium" ></div>
        <div class="circle shade5 small" ></div>
    </div>
        
        
</body>        
</html>
    
        
