<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password']; // plain text

    $stmt = $conn->prepare("INSERT INTO users (username,email,mobile,password,role,status) VALUES (?,?,?,?, 'user','pending')");
    $stmt->bind_param("ssss", $username,$email,$mobile,$password);

    if($stmt->execute()){
        echo "<script>alert('Registration successful! Please wait for admin approval.'); window.location='login.php';</script>";
    } else {
        echo "Error: ".$stmt->error;
    }
}
?>
