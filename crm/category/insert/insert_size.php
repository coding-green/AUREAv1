<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$sizeName = $data['categoryName'];

// Check for the last inserted ID in Size table
$sql = "SELECT size_id FROM Size ORDER BY size_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['size_id'];

    // Extract numeric part, increment by 1, and format it back with the prefix
    $newId = 'SZ' . str_pad((int)substr($lastId, 2) + 1, 5, '0', STR_PAD_LEFT);
} else {
    // Default starting ID if table is empty
    $newId = 'SZ10001';
}

// Insert the new size into the database
$insertSql = "INSERT INTO Size (size_id, size_name) VALUES ('$newId', '$sizeName')";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["status" => "success", "message" => "Size added successfully", "id" => $newId]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add size"]);
}

mysqli_close($conn);
?>
