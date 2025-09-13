<?php
session_start();
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if(isset($_SESSION['user_email'], $data['page'], $data['action'])){
    $stmt = $conn->prepare("INSERT INTO user_activity (user_email, page_name, action) VALUES (?,?,?)");
    $stmt->bind_param("sss", $_SESSION['user_email'], $data['page'], $data['action']);
    $stmt->execute();
}
?>
