<?php
include 'config.php'; // Your database connection file

$response = ['status' => 'error', 'message' => 'Error deleting member'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM members_login WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Member deleted successfully'];
    }

    $stmt->close();
    $conn->close();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
