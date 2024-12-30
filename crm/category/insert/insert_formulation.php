<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$formulationName = $data['categoryName'];

// Check for the last inserted ID in Formulation table
$sql = "SELECT formulation_id FROM Formulation ORDER BY formulation_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lastId = $row['formulation_id'];

    // Extract numeric part, increment by 1, and format it back with the prefix
    $newId = 'ABF' . str_pad((int)substr($lastId, 3) + 1, 5, '0', STR_PAD_LEFT);
} else {
    // Default starting ID if table is empty
    $newId = 'ABF10001';
}

// Insert the new formulation into the database
$insertSql = "INSERT INTO Formulation (formulation_id, formulation_name) VALUES ('$newId', '$formulationName')";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["status" => "success", "message" => "Formulation added successfully", "id" => $newId]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add formulation"]);
}

mysqli_close($conn);
?>
