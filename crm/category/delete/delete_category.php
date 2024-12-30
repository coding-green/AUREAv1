<?php
include '../../config.php';

$data = json_decode(file_get_contents("php://input"));
$productTypeId = $data->id;

// Delete Product Type from the database
$sql = "select * from ProductType where product_type_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "DELETE FROM ProductType WHERE product_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Product type deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete product type"]);
    }
}

// Delete Skin Type from the database
$sql = "select * from SkinTypes where skin_type_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "DELETE FROM SkinTypes WHERE skin_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Skin type deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete skin type"]);
    }
}

// Delete Skin Concerns from the database
$sql = "select * from SkinConcerns where skin_concern_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "DELETE FROM SkinConcerns WHERE skin_concern_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Skin concern deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete skin concern"]);
    }
}

// Delete Aurea Collection from the database
$sql = "select * from AureaCollection where aurea_collection_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "DELETE FROM AureaCollection WHERE aurea_collection_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Aurea collection deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete aurea collection"]);
    }
}

// Delete Formulation from the database
$sql = "select * from Formulation where formulation_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "DELETE FROM Formulation WHERE formulation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Formulation deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete formulation"]);
    }
}

// Delete Brands from the database
$sql = "select * from Brands where brands_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "DELETE FROM Brands WHERE brands_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Brand deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete brand"]);
    }
}

// Delete Size from the database
$sql = "select * from Size where size_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "DELETE FROM Size WHERE size_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Size deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete size"]);
    }
}

// Delete Currency from the database
$sql = "select * from Currency where currency_id = '$productTypeId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $sql = "DELETE FROM Currency WHERE currency_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Currency deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete currency"]);
    }
}

$conn->close();
?>
