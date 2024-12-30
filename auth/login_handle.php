<?php
include './config.php';

session_start();

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    header('Location: ../index.php');
    exit;
}

// Function to validate username and password
function validateUser($inputEmail, $inputPassword, $pdo)
{
    try {
        if (empty($inputEmail) || empty($inputPassword)) {
            return false; // Early return if inputs are empty
        }

        $query = "SELECT * FROM users WHERE user_email = :user_email";
        $stmt = $pdo->prepare($query);
        echo "<script>alert('" . $inputEmail . "');</script>";

        // Bind parameter safely
        $stmt->bindValue(':user_email', $inputEmail, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($inputPassword, $user['user_password'])) {
            $_SESSION['email'] = $user['user_email'];
            $_SESSION['id'] = $user['user_id'];
            return true; // Valid credentials
        }
    } catch (Exception $e) {
        // Log the error or display a friendly message
        error_log($e->getMessage());
    }

    return false; // Invalid credentials or error occurred
}

// Sample input (e.g., from a login form)
$inputEmail = $_POST['email'] ?? null; // Use null coalescing operator to handle unset keys
$inputPassword = $_POST['password'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (validateUser($inputEmail, $inputPassword, $pdo)) {
        // echo "Login successful!";
        header('Location: ../index.php');
    } else {
        // echo "Invalid username or password.";
        header('Location: ./login.php');
    }
}
