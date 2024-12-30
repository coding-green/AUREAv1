<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="popup-auth-container" >
    <h1 class="popup-auth-title">Login</h1>
    <form id="popup-auth-loginForm" action="login_handle.php" method="POST">
      <input type="email" id="popup-auth-loginEmail" name="email" placeholder="Enter your email" required>
      <input type="password" id="popup-auth-loginPassword" name="password" placeholder="Enter your password" required>
      <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
  </div>
</body>
</html>
