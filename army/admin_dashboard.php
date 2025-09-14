<?php
session_start();
include 'config.php';

// Only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}
//$user_id = $_SESSION['user_id'] ?? null; 
$stmt->execute([$_SESSION['user_id']]);

// Handle approve/reject actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'approve') {
        $conn->query("UPDATE users SET status='approved' WHERE id=$id");
    } elseif ($_GET['action'] === 'reject') {
        $conn->query("UPDATE users SET status='rejected' WHERE id=$id");
    }
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
$pendingUsers = $conn->query("SELECT * FROM users WHERE status='pending' ORDER BY id ASC");

// Fetch activities
$activityLogs = $conn->query("SELECT * FROM user_activity ORDER BY timestamp DESC LIMIT 20");

// Count quick stats
$totalUsers = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$approvedUsers = $conn->query("SELECT COUNT(*) as c FROM users WHERE status='approved'")->fetch_assoc()['c'];
$pendingCount = $conn->query("SELECT COUNT(*) as c FROM users WHERE status='pending'")->fetch_assoc()['c'];
$rejectedCount = $conn->query("SELECT COUNT(*) as c FROM users WHERE status='rejected'")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Army Fabric Optimization</title>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
    margin: 0;
    font-family: 'Quicksand', sans-serif;
    background: #f4f6f9;
    display: flex;
}
.sidebar {
    width: 250px;
    background: #1b5e20;
    color: white;
    height: 100vh;
    position: fixed;
    top: 0; left: 0;
    padding-top: 20px;
}
.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
}
.sidebar a {
    display: block;
    padding: 12px 20px;
    color: white;
    text-decoration: none;
    transition: background 0.3s;
}
.sidebar a:hover {
    background: #2e7d32;
}
.main {
    margin-left: 250px;
    padding: 20px;
    flex: 1;
}
header {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #1b5e20;
}
.cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    flex: 1 1 200px;
    text-align: center;
}
.card h3 {
    margin: 10px 0;
    color: #1b5e20;
}
.table-container {
    margin-top: 20px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    overflow-x: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}
th {
    background: #e8f5e9;
}
.approve {
    background: #28a745; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;
}
.reject {
    background: #d32f2f; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;
}
.system-health, .alerts {
    margin-top: 20px;
    display: flex;
    gap: 20px;
}
.alert-box {
    flex: 1;
    padding: 15px;
    border-radius: 10px;
    background: #fff3cd;
    border: 1px solid #ffeeba;
}
.health-box {
    flex: 1;
    padding: 15px;
    border-radius: 10px;
    background: #d4edda;
    border: 1px solid #c3e6cb;
}
canvas {
    margin-top: 20px;
    background: #fff;
    border-radius: 12px;
    padding: 15px;
}
.logout {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: white;
    color: #1b5e20;
    padding: 8px 15px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="#overview">System Overview</a>
    <a href="#users">User Management</a>
    <a href="#activity">Real-time Activity</a>
    <a href="#reports">Analysis & Reports</a>
    <a href="#health">System Health</a>
    <a href="#alerts">Alerts & Notifications</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <header>Admin Dashboard</header>

    <!-- System Overview -->
    <section id="overview">
        <div class="cards">
            <div class="card"><h3>Total Users</h3><p><?= $totalUsers ?></p></div>
            <div class="card"><h3>Approved</h3><p><?= $approvedUsers ?></p></div>
            <div class="card"><h3>Pending</h3><p><?= $pendingCount ?></p></div>
            <div class="card"><h3>Rejected</h3><p><?= $rejectedCount ?></p></div>
        </div>
    </section>

    <!-- User Management -->
    <section id="users" class="table-container">
        <h3>User Management</h3>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Status</th><th>Action</th></tr>
            <?php while($row = $pendingUsers->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['mobile'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <a href="admin_dashboard.php?action=approve&id=<?= $row['id'] ?>"><button class="approve">Approve</button></a>
                    <a href="admin_dashboard.php?action=reject&id=<?= $row['id'] ?>"><button class="reject">Reject</button></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Real-time Activity -->
    <section id="activity" class="table-container">
        <h3>Recent User Activities</h3>
        <table>
            <tr><th>User Email</th><th>Page</th><th>Action</th><th>Time</th></tr>
            <?php while($row = $activityLogs->fetch_assoc()): ?>
            <tr>
                <td><?= $row['user_email'] ?></td>
                <td><?= $row['page_name'] ?></td>
                <td><?= $row['action'] ?></td>
                <td><?= $row['timestamp'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Reports -->
    <section id="reports">
        <h3>Analysis & Reports</h3>
        <canvas id="userChart"></canvas>
    </section>

    <!-- System Health -->
    <section id="health" class="system-health">
        <div class="health-box">
            <h4>Database Status</h4>
            <p>✅ Connected and running</p>
        </div>
        <div class="health-box">
            <h4>Server Load</h4>
            <p>Normal</p>
        </div>
    </section>

    <!-- Alerts -->
    <section id="alerts" class="alerts">
        <div class="alert-box">
            <h4>⚠️ Pending Users</h4>
            <p>You have <?= $pendingCount ?> users awaiting approval.</p>
        </div>
        <div class="alert-box">
            <h4>🔔 System Notification</h4>
            <p>All services are running smoothly.</p>
        </div>
    </section>
</div>

<script>
// Chart.js Users Report
const ctx = document.getElementById('userChart');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Approved', 'Pending', 'Rejected'],
        datasets: [{
            data: [<?= $approvedUsers ?>, <?= $pendingCount ?>, <?= $rejectedCount ?>],
            backgroundColor: ['#28a745','#ffc107','#dc3545']
        }]
    }
});
</script>
</body>
</html>
