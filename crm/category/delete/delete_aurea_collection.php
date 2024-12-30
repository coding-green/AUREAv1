<?php
include '../../config.php';

$data = json_decode(file_get_contents("php://input"));
$aureaCollectionId = $data->id;

if (!isset($aureaCollectionId)) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$conn->begin_transaction();

try {
    $sql = "SELECT aurea_collection_id, aurea_collection_name FROM AureaCollection WHERE aurea_collection_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $aureaCollectionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowdata = $result->fetch_assoc();
        $aureaCollectionId = $rowdata['aurea_collection_id'];
        $aureaCollectionName = $rowdata['aurea_collection_name'];

        // Insert into Trash_AureaCollection
        $sql = "INSERT INTO Trash_AureaCollection (aurea_collection_id, aurea_collection_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $aureaCollectionId, $aureaCollectionName);
        $stmt->execute();

        // Delete from AureaCollection
        $sql = "DELETE FROM AureaCollection WHERE aurea_collection_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $aureaCollectionId);
        $stmt->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Aurea collection deleted successfully"]);
    } else {
        throw new Exception("Aurea collection not found");
    }
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?>
