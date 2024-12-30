<?php
include '../../config.php';

// Decode JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);
$productTypeId = $data['id'];
$productTypeName = $data['name'];

// Update Product Type in the database
$sql = "select * from ProductType where product_type_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$sql = "UPDATE ProductType SET product_type_name = ? WHERE product_type_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $productTypeName, $productTypeId);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Product type updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update product type"]);
}
}

// Update Skin Type in the database
$sql = "select * from SkinTypes where skin_type_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "UPDATE SkinTypes SET skin_type_name = ? WHERE skin_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $productTypeName, $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Skin type updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update skin type"]);
    }
}

// Update Skin Concerns in the database
$sql = "select * from SkinConcerns where skin_concern_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "UPDATE SkinConcerns SET concern_name = ? WHERE skin_concern_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $productTypeName, $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Skin concern updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update skin concern"]);
    }
}

// Update Aurea Collection in the database
$sql = "select * from AureaCollection where aurea_collection_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "UPDATE AureaCollection SET aurea_collection_name = ? WHERE aurea_collection_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $productTypeName, $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Aurea collection updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update Aurea collection"]);
    }
}

// Update Formulation in the database
$sql = "select * from Formulation where formulation_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "UPDATE Formulation SET formulation_name = ? WHERE formulation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $productTypeName, $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Formulation updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update Formulation"]);
    }
}

// Update Brands in the database
$sql = "select * from Brands where brands_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "UPDATE Brands SET brands_name = ? WHERE brands_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $productTypeName, $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Brand updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update Brand"]);
    }
}

// Update Size in the database
$sql = "select * from Size where size_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "UPDATE Size SET size_name = ? WHERE size_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $productTypeName, $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Size updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update Size"]);
    }
}

// Update Currency in the database
$sql = "select * from Currency where currency_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "UPDATE Currency SET currency_name = ? WHERE currency_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $productTypeName, $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Currency updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update Currency"]);
    }
}


$stmt->close();
$conn->close();
?>
