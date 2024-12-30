<?php
include '../../config.php';

$data = json_decode(file_get_contents("php://input"));
$skinTypeId = $data->id;

if (!isset($skinTypeId)) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$conn->begin_transaction();

try {
    $sql = "SELECT skin_type_id, skin_type_name FROM SkinTypes WHERE skin_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $skinTypeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowdata = $result->fetch_assoc();
        $skinTypeId = $rowdata['skin_type_id'];
        $skinTypeName = $rowdata['skin_type_name'];

        // Insert into Trash_SkinTypes
        $sql = "INSERT INTO Trash_SkinTypes (skin_type_id, skin_type_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $skinTypeId, $skinTypeName);
        $stmt->execute();

        // Delete from SkinTypes
        $sql = "DELETE FROM SkinTypes WHERE skin_type_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $skinTypeId);
        $stmt->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Skin type deleted successfully"]);
    } else {
        throw new Exception("Skin type not found");
    }
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?>
