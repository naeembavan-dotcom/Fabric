<?php
$servername = "localhost";  // or 127.0.0.1
$username   = "root";       // default in XAMPP
$password   = "";           // default empty in XAMPP
$dbname     = "army_fabric";       // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
