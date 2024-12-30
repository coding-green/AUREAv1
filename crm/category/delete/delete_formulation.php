<?php
include '../../config.php';

$data = json_decode(file_get_contents("php://input"));
$formulationId = $data->id;

if (!isset($formulationId)) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$conn->begin_transaction();

try {
    $sql = "SELECT formulation_id, formulation_name FROM Formulation WHERE formulation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $formulationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowdata = $result->fetch_assoc();
        $formulationId = $rowdata['formulation_id'];
        $formulationName = $rowdata['formulation_name'];

        // Insert into Trash_Formulation
        $sql = "INSERT INTO Trash_Formulation (formulation_id, formulation_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $formulationId, $formulationName);
        $stmt->execute();

        // Delete from Formulation
        $sql = "DELETE FROM Formulation WHERE formulation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $formulationId);
        $stmt->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Formulation deleted successfully"]);
    } else {
        throw new Exception("Formulation not found");
    }
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conn->close();
}
?>
