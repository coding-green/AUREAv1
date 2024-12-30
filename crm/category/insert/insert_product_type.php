<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$productTypeName = $data['categoryName'];

// Check for the last inserted ID in ProductType table
$sql = "SELECT product_type_id FROM ProductType ORDER BY product_type_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['product_type_id'];

    // Extract numeric part, increment by 1, and format it back with the prefix
    $newId = 'ABPT' . str_pad((int)substr($lastId, 4) + 1, 5, '0', STR_PAD_LEFT);
} else {
    // Default starting ID if table is empty
    $newId = 'ABPT10001';
}

// Insert the new product type into the database
$insertSql = "INSERT INTO ProductType (product_type_id, product_type_name) VALUES ('$newId', '$productTypeName')";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["status" => "success", "message" => "Product type added successfully", "id" => $newId]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add product type"]);
}

mysqli_close($conn);
?>