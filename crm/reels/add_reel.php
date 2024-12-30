<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $reel_brand = mysqli_real_escape_string($conn, $_POST['reel_brand']);
    $reel_url = mysqli_real_escape_string($conn, $_POST['reel_url']);

    // Generate Product ID (example: AB/R0001)
    $query = "SELECT MAX(CAST(SUBSTRING(reel_id, 6) AS UNSIGNED)) AS max_id FROM reels";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Database query failed: " . mysqli_error($conn)); // Check for database query errors
    }
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'] ? $row['max_id'] : 0; // fallback to 0 if NULL
    $reel_id = 'AB/R' . str_pad($max_id + 1, 4, '0', STR_PAD_LEFT);



    // Insert new reel
    $insert_sql = "INSERT INTO reels (reel_id, reel_brand, reel_url, reel_status, reel_type) VALUES ('$reel_id', '$reel_brand', '$reel_url', 'Active','Home')";
    if (mysqli_query($conn, $insert_sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Reel added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding reel: ' . mysqli_error($conn)]);
    }
}
?>