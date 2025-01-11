<?php

use App\Controllers\session;
$session=new session();
$session->start();


if ($session->has('UserName')) {
    header("Location: /home");  
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/_min.css"> 
    <link rel="stylesheet" href="css/_Login.css">


    
    <title>Login</title>
</head>
<body>

    <div class="login-container">
  <div class="login-box">
    <div class="login-header">
      <h2>Welcome Back</h2>
    </div>
    <form class="login-form" id="Login">
      <div class="form-group">
        <div class="input-icon">
          <i class="fas fa-user"></i>
        </div>
        <input type="text" name="UserName" name="UserName" placeholder="UserName" id="userName" required>
      </div>
      
      <div class="form-group">
        <div class="input-icon">
          <i class="fas fa-lock"></i>
        </div>
        <input type="password" name="password" id="password" placeholder="Password" required>
      </div>

      <button type="submit" class="login-btn">Login</button>
    </form>
  </div>
</div>
<script src="../js/all.min.js"></script>

<script src="../js/Login.js"></script>
</body>
</html>