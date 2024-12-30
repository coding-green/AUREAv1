<?php
include '../../config.php';

$data = json_decode(file_get_contents("php://input"));
$brandId = $data->id;

if (!isset($brandId)) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$conn->begin_transaction();

try {
    $sql = "SELECT brands_id, brands_name FROM Brands WHERE brands_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $brandId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowdata = $result->fetch_assoc();
        $brandsId = $rowdata['brands_id'];
        $brandsName = $rowdata['brands_name'];

        // Insert into Trash_Brands
        $sql = "INSERT INTO Trash_Brands (brands_id, brands_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $brandsId, $brandsName);
        $stmt->execute();

        // Delete from Brands
        $sql = "DELETE FROM Brands WHERE brands_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $brandId);
        $stmt->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Brand deleted successfully"]);
    } else {
        throw new Exception("Brand not found");
    }
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?>
