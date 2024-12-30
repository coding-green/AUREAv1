<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$brandName = $data['categoryName'];

// Check for the last inserted ID in Brands table
$sql = "SELECT brands_id FROM Brands ORDER BY brands_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['brands_id'];

    // Extract numeric part, increment by 1, and format it back with the prefix
    $newId = 'ABB' . str_pad((int)substr($lastId, 3) + 1, 5, '0', STR_PAD_LEFT);
} else {
    // Default starting ID if table is empty
    $newId = 'ABB10001';
}

// Insert the new brand into the database
$insertSql = "INSERT INTO Brands (brands_id, brands_name) VALUES ('$newId', '$brandName')";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["status" => "success", "message" => "Brand added successfully", "id" => $newId]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add brand"]);
}

mysqli_close($conn);
?>
