<?php
include '../../config.php';

$data = json_decode(file_get_contents("php://input"));
$productTypeId = $data->id;

if (!isset($productTypeId)) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$conn->begin_transaction();

try {
    $sql = "SELECT product_type_name FROM ProductType WHERE product_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productTypeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowdata = $result->fetch_assoc();
        $productTypeName = $rowdata['product_type_name'];

        // Insert into Trash_ProductType
        $sql = "INSERT INTO Trash_ProductType (product_type_id, product_type_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $productTypeId, $productTypeName);
        $stmt->execute();

        // Delete from ProductType
        $sql = "DELETE FROM ProductType WHERE product_type_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $productTypeId);
        $stmt->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Product type deleted successfully"]);
    } else {
        throw new Exception("Product type not found");
    }
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?>
