<?php
include_once 'config.php';
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['product_id'], $_SESSION['id'])) {
    $product_id = $data['product_id'];
    $user_id = $_SESSION['id'];

    $query = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $product_id, $user_id);
        $success = $stmt->execute();
        echo json_encode(['success' => $success]);
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database query error']);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data or user not logged in']);
}
