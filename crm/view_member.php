<?php
include 'config.php'; // Your database connection file

$response = ['status' => 'error', 'message' => 'Member not found'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    $sql = "SELECT * FROM members_login WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc();
        $response = [
            'status' => 'success',
            'member' => $member
        ];
    }

    $stmt->close();
    $conn->close();
}

header('Content-Type: application/json');
echo json_encode($response);
?>
