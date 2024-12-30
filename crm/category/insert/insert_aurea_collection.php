<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$collectionName = $data['categoryName'];

// Check for the last inserted ID in AureaCollection table
$sql = "SELECT aurea_collection_id FROM AureaCollection ORDER BY aurea_collection_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['aurea_collection_id'];

    // Extract numeric part, increment by 1, and format it back with the prefix
    $newId = 'ABAC' . str_pad((int)substr($lastId, 4) + 1, 5, '0', STR_PAD_LEFT);
} else {
    // Default starting ID if table is empty
    $newId = 'ABAC10001';
}

// Insert the new collection into the database
$insertSql = "INSERT INTO AureaCollection (aurea_collection_id, aurea_collection_name) VALUES ('$newId', '$collectionName')";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["status" => "success", "message" => "Aurea collection added successfully", "id" => $newId]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add Aurea collection"]);
}

mysqli_close($conn);
?>
