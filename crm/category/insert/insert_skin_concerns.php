<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$concernName = $data['categoryName'];

// Check for the last inserted ID in SkinConcerns table
$sql = "SELECT skin_concern_id FROM SkinConcerns ORDER BY skin_concern_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['skin_concern_id'];

    // Extract numeric part, increment by 1, and format it back with the prefix
    $newId = 'ABSC' . str_pad((int)substr($lastId, 4) + 1, 5, '0', STR_PAD_LEFT);
} else {
    // Default starting ID if table is empty
    $newId = 'ABSC10001';
}

// Insert the new skin concern into the database
$insertSql = "INSERT INTO SkinConcerns (skin_concern_id, concern_name) VALUES ('$newId', '$concernName')";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["status" => "success", "message" => "Skin concern added successfully", "id" => $newId]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add skin concern"]);
}

mysqli_close($conn);
?>
