<?php
if (isset($_POST["did"]) && isset($_POST["password"]) && isset($_POST["oldPassword"])) {
    $did = $_POST["did"];
    $password = $_POST["password"];
    $oldPassword = $_POST["oldPassword"];

    // Verify the old password
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "store");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT password FROM delivery_personnel WHERE did = $did";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($oldPassword!=$row["password"]) {
            echo "wrong password entered.";
            exit();
        }

        // Update the password
        
        $sql = "UPDATE delivery_personnel SET password = '$password' WHERE did = $did";
        if ($conn->query($sql) === TRUE) {
            echo "Password changed successfully.";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Error: delivery personnel not found.";
    }

    $conn->close();
}


