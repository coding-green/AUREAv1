<?php
include '../config.php';// Include your database connection

header('Content-Type: application/json'); // Set response type to JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reel_id = mysqli_real_escape_string($conn, $_POST['id']);

    // SQL to delete the reel
    $sql = "DELETE FROM reels WHERE reel_id = '$reel_id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}
?>
