<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$skinTypeName = $data['categoryName'];

// Check for the last inserted ID in SkinTypes table
$sql = "SELECT skin_type_id FROM SkinTypes ORDER BY skin_type_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['skin_type_id'];

    // Extract numeric part, increment by 1, and format it back with the prefix
    $newId = 'ABST' . str_pad((int)substr($lastId, 4) + 1, 5, '0', STR_PAD_LEFT);
} else {
    // Default starting ID if table is empty
    $newId = 'ABST10001';
}

// Insert the new skin type into the database
$insertSql = "INSERT INTO SkinTypes (skin_type_id, skin_type_name) VALUES ('$newId', '$skinTypeName')";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["status" => "success", "message" => "Skin type added successfully", "id" => $newId]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add skin type"]);
}

mysqli_close($conn);
?>
