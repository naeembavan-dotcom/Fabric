<?php
session_start();
include "config.php"; // Make sure db.php exists in the same folder

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        if($password === $row['password']){ // plain-text password check
            if($row['status'] === 'approved'){
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                
                if($row['role'] === 'admin'){
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } elseif($row['status'] === 'pending'){
                $error = "⏳ Your account is waiting for admin approval.";
            } else {
                $error = "🚫 Your account has been blocked by admin.";
            }
        } else {
            $error = "❌ Invalid password.";
        }
    } else {
        $error = "❌ No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Indian Army Fabric Optimization</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{
    background:url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
    height:100vh; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden;
}
body::before{
    content:""; position:absolute; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:1;
}
header{
    position:fixed; top:0; left:0; width:100%; background:rgba(0,0,0,0.7); color:#b6ffb6; padding:15px 20px; text-align:center; font-size:1.3rem; font-weight:bold; z-index:3; backdrop-filter:blur(6px);
}
footer{
    position:fixed; bottom:10px; left:0; right:0; text-align:center; color:#ddd; font-size:0.9rem; z-index:3;
}
.login-box{
    position:relative; z-index:2; background:rgba(255,255,255,0.08); backdrop-filter:blur(10px); width:400px; padding:40px; border-radius:15px; box-shadow:0 8px 25px rgba(0,0,0,0.6); animation:fadeIn 1.5s ease; margin-top:80px; text-align:center; color:white;
}
.login-box h2{margin-bottom:20px;color:#b6ffb6;}
.login-box input{width:100%; padding:12px; margin:8px 0; border:none; border-radius:8px; outline:none; font-size:1rem; background:rgba(255,255,255,0.9);}
.login-box button{width:100%; padding:12px; background:#28a745; color:white; border:none; border-radius:8px; font-size:1.1rem; font-weight:bold; cursor:pointer; transition:0.3s; margin-top:10px;}
.login-box button:hover{background:#1e7e34; transform:scale(1.05);}
.login-box p{margin-top:15px; font-size:0.9rem;}
.login-box a{color:#b6ffb6; text-decoration:none; font-weight:bold;}
.login-box a:hover{text-decoration:underline;}
.error{background: rgba(255,0,0,0.2); padding:10px; border-radius:8px; margin-bottom:10px; color:#ff9999;}
@keyframes fadeIn{from{opacity:0;transform:translateY(-30px);}to{opacity:1;transform:translateY(0);}}
</style>
</head>
<body>
<header>Indian Army Fabric Optimization System</header>

<div class="login-box">
<h2>Login</h2>
<?php if(!empty($error)){ echo "<div class='error'>$error</div>"; } ?>
<form method="POST">
<input type="email" name="email" value="ramesh@gmail.com"placeholder="Email Address" required>
<input type="password" name="password" value="1111" placeholder="Password" required>
<button type="submit">Login</button>
</form>
<p>Don’t have an account? <a href="register.php">Register Here</a></p>
</div>

<footer>© 2025 Indian Army Fabric Optimization | Powered by AI/ML</footer>
</body>
</html>
