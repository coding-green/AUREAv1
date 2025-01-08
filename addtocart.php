<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once("header.php");
include_once("config.php");
include_once("function.php");

if (isset($_GET['id'], $_GET['qty']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $id = $_GET['id'];
    $qty = $_GET['qty'];
    $ip_addr = $_SERVER['REMOTE_ADDR'];

    $query = "SELECT id FROM cart WHERE user_id = ? AND product_id = ? LIMIT 1";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $user_id, $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $updateQuery = "UPDATE cart SET qty = qty + ? WHERE user_id = ? AND product_id = ?";
            if ($updateStmt = $conn->prepare($updateQuery)) {
                $updateStmt->bind_param("iss", $qty, $user_id, $id);
                $updateStmt->execute();
                $updateStmt->close();
            }
        } else {
            $insertQuery = "INSERT INTO cart (id, product_id, ip_add, user_id, qty)
                            SELECT NULL, product_id, ?, ?, ? 
                            FROM Products 
                            WHERE product_id = ? AND status = 'active' LIMIT 1";
            if ($insertStmt = $conn->prepare($insertQuery)) {
                $insertStmt->bind_param("ssis", $ip_addr, $user_id, $qty, $id);
                $insertStmt->execute();
                $insertStmt->close();
            }
        }

        $stmt->close();
    } else {
        echo "Unable to process your request.";
    }
    echo "<script>window.location.href='cart.php'</script>";
} else {
    echo "<script>window.location.href='auth/login.php'</script>";
}
