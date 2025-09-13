<?php
session_start();
include 'db.php';

// Only admin can access
if(!isset($_SESSION['role']) || $_SESSION['role']!=='admin'){
    die("Access denied.");
}

// Handle approve/reject actions
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);
    if($_GET['action'] === 'approve'){
        $conn->query("UPDATE users SET status='approved' WHERE id=$id");
    } elseif($_GET['action'] === 'reject'){
        $conn->query("UPDATE users SET status='rejected' WHERE id=$id");
    }
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
$pendingUsers = $conn->query("SELECT * FROM users WHERE status='pending' ORDER BY id ASC");

// Fetch real activity feed
$activityLogs = $conn->query("SELECT * FROM user_activity ORDER BY timestamp DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Army Fabric Optimization</title>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body{
    font-family:'Quicksand',sans-serif;
    background:#f0f2f5;
    margin:0;
}
header{
    background:#1b5e20;
    color:white;
    padding:15px 20px;
    text-align:center;
    font-size:1.5rem;
    font-weight:bold;
}
.logout{
    position:fixed;
    top:15px;
    right:20px;
    background:white;
    color:#1b5e20;
    padding:10px 15px;
    border-radius:5px;
    font-weight:bold;
    text-decoration:none;
    box-shadow:0 2px 6px rgba(0,0,0,0.2);
}
.logout:hover{
    background:#1b5e20;
    color:white;
}
.container{
    display:flex;
    flex-wrap:wrap;
    margin:20px;
    gap:20px;
    justify-content:flex-start;
}
.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    flex:1 1 700px;
    max-width:100%;
}
.card h3{
    color:#1b5e20;
    margin-bottom:15px;
}
table{
    width:100%;
    border-collapse:collapse;
}
th, td{
    padding:10px;
    border-bottom:1px solid #ddd;
    text-align:left;
}
th{
    background:#e8f5e9;
}
button{
    padding:5px 10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-weight:bold;
}
.approve{
    background:#28a745;
    color:white;
}
.reject{
    background:#d32f2f;
    color:white;
}
button:hover{
    opacity:0.9;
}
.activity-feed{
    margin-top:15px;
    background:#fff;
    padding:15px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    max-height:400px;
    overflow-y:auto;
}
.activity-feed h4{
    color:#1b5e20;
    margin-bottom:10px;
}
.activity-feed table{
    width:100%;
    border-collapse:collapse;
}
.activity-feed th, .activity-feed td{
    padding:8px;
    border-bottom:1px solid #eee;
    font-size:0.9rem;
}
</style>
</head>
<body>

<header>Admin Dashboard</header>
<a href="logout.php" class="logout">Logout</a>

<div class="container">

    <!-- Pending Users -->
    <div class="card">
        <h3>Pending Users</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Action</th>
            </tr>
            <?php while($row = $pendingUsers->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['mobile'] ?></td>
                <td>
                    <a href="admin_dashboard.php?action=approve&id=<?= $row['id'] ?>"><button class="approve">Approve</button></a>
                    <a href="admin_dashboard.php?action=reject&id=<?= $row['id'] ?>"><button class="reject">Reject</button></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- All Users -->
    <div class="card">
        <h3>All Users</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Status</th>
                <th>Registered At</th>
            </tr>
            <?php while($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['mobile'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Activity Feed -->
    <div class="card activity-feed">
        <h4>Recent User Activities</h4>
        <table>
            <tr>
                <th>User Email</th>
                <th>Page</th>
                <th>Action</th>
                <th>Time</th>
            </tr>
            <?php while($row = $activityLogs->fetch_assoc()): ?>
            <tr>
                <td><?= $row['user_email'] ?></td>
                <td><?= $row['page_name'] ?></td>
                <td><?= $row['action'] ?></td>
                <td><?= $row['timestamp'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

</body>
</html>
