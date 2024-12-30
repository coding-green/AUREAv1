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
  <title>Signup Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="popup-auth-container">
    <h1 class="popup-auth-title">Sign Up</h1>
    <form id="popup-auth-signupForm" action="signup_handle.php" method="POST">
      <input type="text" id="popup-auth-signupName" name="user_name" placeholder="Enter your name" required>
      <input type="email" id="popup-auth-signupEmail" name="email" placeholder="Enter your email" required>
      <input type="password" id="popup-auth-signupPassword" name="password" placeholder="Create a password" required>
      <input type="password" id="popup-auth-confirmPassword" name="confirm_password" placeholder="Confirm a password" required>
      <input type="submit" value="Sign Up">
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
