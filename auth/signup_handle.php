<?php
include '../config.php'; // Ensure this file correctly sets up the $pdo variable

session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_email'])) {
    header('Location: ../index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['user_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $confirmPassword = $_POST['confirm_password'] ?? null;

    // Validate inputs
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    try {
        // Check if email already exists
        $query = "SELECT COUNT(*) FROM users WHERE user_email = :user_email";
        $query2 = "SELECT MAX(ID) FROM users";
        $stmt = $pdo->prepare($query);
        $stmt2 = $pdo->prepare($query2);
        $stmt->bindValue(':user_email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $stmt2->execute();
        $userExists = $stmt->fetchColumn();
        $user_id = $stmt2->fetchColumn();

        if ($userExists) {
            die("Email is already registered.");
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user
        $insertQuery = "INSERT INTO users (user_id, user_name, user_email, user_password) VALUES (:user_id, :user_name, :user_email, :user_password)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindValue(':user_email', $email, PDO::PARAM_STR);
        $insertStmt->bindValue(':user_name', $name, PDO::PARAM_STR);
        $insertStmt->bindValue(':user_id', 'ABU' . (10001 + $user_id), PDO::PARAM_STR);
        $insertStmt->bindValue(':user_password', $hashedPassword, PDO::PARAM_STR);
        $insertStmt->execute();

        echo "Signup successful! You can now <a href='login.php'>login</a>.";
    } catch (Exception $e) {
        // Log the error and show a friendly message
        error_log($e->getMessage());
        die("An error occurred. Please try again later.");
    }
}
?>
