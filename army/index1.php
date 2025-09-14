<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Indian Army Fabric Optimization | Get Started</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      background: url('https://images.unsplash.com/photo-1611223491833-6ecdfd4c8af5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      overflow: hidden;
      position: relative;
    }
    /* Overlay for dark effect */
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }
    .container {
      position: relative;
      z-index: 2;
      max-width: 900px;
      padding: 30px;
      animation: fadeIn 2s ease-in-out;
    }
    h1 {
      font-size: 3rem;
      margin-bottom: 20px;
      color: #b6ffb6;
      text-transform: uppercase;
      letter-spacing: 2px;
      animation: slideDown 1.5s ease;
    }
    p {
      font-size: 1.3rem;
      margin-bottom: 40px;
      line-height: 1.8;
      animation: fadeIn 3s ease;
    }
    .btn {
      background-color: #28a745;
      color: white;
      padding: 15px 45px;
      border: none;
      border-radius: 40px;
      font-size: 1.3rem;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      box-shadow: 0px 4px 15px rgba(0,0,0,0.4);
    }
    .btn:hover {
      background-color: #1e7e34;
      transform: scale(1.05);
      box-shadow: 0px 6px 20px rgba(0,0,0,0.6);
    }
    footer {
      position: absolute;
      bottom: 15px;
      width: 100%;
      text-align: center;
      font-size: 0.9rem;
      color: #ddd;
      z-index: 2;
      animation: fadeIn 4s ease;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideDown {
      from { transform: translateY(-50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    /* Floating particles (creative effect) */
    .particle {
      position: absolute;
      width: 8px; height: 8px;
      background: #28a745;
      border-radius: 50%;
      opacity: 0.6;
      animation: float 8s infinite ease-in-out;
    }
    @keyframes float {
      0% { transform: translateY(0); opacity: 0.6; }
      50% { transform: translateY(-100px); opacity: 1; }
      100% { transform: translateY(0); opacity: 0.6; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>AI/ML Fabric Optimization System</h1>
    <p>
      Smarter fabrics, sustainable solutions, and optimized logistics for the Indian Army.  
      From the icy Ladakh to the deserts of Rajasthan, one system to manage it all.
    </p>
    <a href="login.php" class="btn">Get Started</a>
  </div>
  <footer>
    © 2025 Indian Army Fabric Optimization | Powered by AI/ML
  </footer>

  <!-- Floating particles -->
  <div class="particle" style="left:10%; animation-delay: 0s;"></div>
  <div class="particle" style="left:30%; animation-delay: 2s;"></div>
  <div class="particle" style="left:50%; animation-delay: 4s;"></div>
  <div class="particle" style="left:70%; animation-delay: 1s;"></div>
  <div class="particle" style="left:90%; animation-delay: 3s;"></div>
</body>
</html>