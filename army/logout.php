<?php
// logout.php - User logout
require_once 'session.php';

session_destroy();
header('Location: login.php');
exit();
?>