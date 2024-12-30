<?php
include '../../config.php';

$data = json_decode(file_get_contents("php://input"));
$skinConcernId = $data->id;

if (!isset($skinConcernId)) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$conn->begin_transaction();

try {
    $sql = "SELECT skin_concern_id, concern_name FROM SkinConcerns WHERE skin_concern_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $skinConcernId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowdata = $result->fetch_assoc();
        $skinConcernId = $rowdata['skin_concern_id'];
        $concernName = $rowdata['concern_name'];

        // Insert into Trash_SkinConcerns
        $sql = "INSERT INTO Trash_SkinConcerns (skin_concern_id, concern_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $skinConcernId, $concernName);
        $stmt->execute();

        // Delete from SkinConcerns
        $sql = "DELETE FROM SkinConcerns WHERE skin_concern_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $skinConcernId);
        $stmt->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Skin concern deleted successfully"]);
    } else {
        throw new Exception("Skin concern not found");
    }
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?>
