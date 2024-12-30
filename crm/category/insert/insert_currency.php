<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$currencyName = $data['categoryName'];

// Check for the last inserted ID in Currency table
$sql = "SELECT currency_id FROM Currency ORDER BY currency_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['currency_id'];

    // Extract numeric part, increment by 1, and format it back with the prefix
    $newId = 'CUR' . str_pad((int)substr($lastId, 3) + 1, 5, '0', STR_PAD_LEFT);
} else {
    // Default starting ID if table is empty
    $newId = 'CUR10001';
}

// Insert the new currency into the database
$insertSql = "INSERT INTO Currency (currency_id, currency_name) VALUES ('$newId', '$currencyName')";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["status" => "success", "message" => "Currency added successfully", "id" => $newId]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add currency"]);
}

mysqli_close($conn);
?>
