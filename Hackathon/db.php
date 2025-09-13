<?php
$host = "localhost";
$user = "root";      // change if needed
$pass = "";          // change if you have MySQL password
$db   = "army_fabric";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
