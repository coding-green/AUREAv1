<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("SELECT main_image_path, image_paths FROM product_images WHERE product_id = ?");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $stmt->bind_result($mainImagePath, $imagePaths);
    $stmt->fetch();
    $stmt->close();

    $response = ['status' => 'error', 'message' => 'No images found.'];

    if ($mainImagePath || $imagePaths) {
        $response['status'] = 'success';
        $response['mainImage'] = $mainImagePath ? $mainImagePath : null;

        $response['bulkImages'] = [];
        if ($imagePaths) {
            $response['bulkImages'] = explode(',', $imagePaths);
        }
    }

    echo json_encode($response);
}
?>
