<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register | Indian Army Fabric Optimization</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center/cover;height:100vh;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;}
body::before{content:"";position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.65);z-index:1;}
header{position:fixed;top:0;left:0;width:100%;background:rgba(0,0,0,0.7);color:#b6ffb6;padding:15px 20px;text-align:center;font-size:1.3rem;font-weight:bold;z-index:3;backdrop-filter:blur(6px);}
footer{position:fixed;bottom:10px;left:0;right:0;text-align:center;color:#ddd;font-size:0.9rem;z-index:3;}
.register-box{position:relative;z-index:2;background:rgba(255,255,255,0.08);backdrop-filter:blur(10px);display:flex;width:750px;border-radius:15px;box-shadow:0 8px 25px rgba(0,0,0,0.6);overflow:hidden;animation:fadeIn 1.5s ease;margin-top:80px;}
.left-panel{width:50%;background:rgba(40,167,69,0.85);color:white;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:30px;}
.left-panel h2{font-size:2rem;margin-bottom:15px;}
.left-panel p{font-size:1rem;line-height:1.5;}
.right-panel{width:50%;padding:40px;text-align:center;color:white;}
.right-panel h2{margin-bottom:20px;color:#b6ffb6;text-transform:uppercase;}
.right-panel input{width:100%;padding:12px;margin:8px 0;border:none;border-radius:8px;outline:none;font-size:1rem;background:rgba(255,255,255,0.9);}
.right-panel button{width:100%;padding:12px;background:#28a745;color:white;border:none;border-radius:8px;font-size:1.1rem;font-weight:bold;cursor:pointer;transition:0.3s;margin-top:10px;}
.right-panel button:hover{background:#1e7e34;transform:scale(1.05);}
.right-panel p{margin-top:15px;font-size:0.9rem;}
.right-panel a{color:#b6ffb6;text-decoration:none;font-weight:bold;}
.right-panel a:hover{text-decoration:underline;}
@keyframes fadeIn{from{opacity:0;transform:translateY(-30px);}to{opacity:1;transform:translateY(0);}}
</style>
</head>
<body>
<header>Indian Army Fabric Optimization System</header>
<div class="register-box">
<div class="left-panel">
<h2>Join the Mission</h2>
<p>Be part of the AI/ML-powered revolution in Army fabric management. Register now to access smart insights on fabrics, sustainability, and logistics.</p>
</div>
<div class="right-panel">
<h2>Create Account</h2>
<form action="save_register.php" method="POST">
<input type="text" name="username" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email Address" required>
<input type="text" name="mobile" placeholder="Mobile Number" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login Here</a></p>
</div>
</div>
<footer>© 2025 Indian Army Fabric Optimization | Powered by AI/ML</footer>
</body>
</html>
