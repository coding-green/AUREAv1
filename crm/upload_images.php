<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    // Handle main image upload
    if (isset($_FILES['mainImage']) && $_FILES['mainImage']['error'] == 0) {
        $mainImage = $_FILES['mainImage'];
        $mainImagePath = 'uploads/images/' . uniqid('main_') . '.' . pathinfo($mainImage['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($mainImage['tmp_name'], $mainImagePath)) {
            // Update main image path in the database
            $stmt = $conn->prepare("UPDATE product_images SET main_image_path = ? WHERE product_id = ?");
            $stmt->bind_param("ss", $mainImagePath, $product_id);
            $stmt->execute();
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload main image']);
            exit;
        }
    }

    // Handle bulk image upload
    if (isset($_FILES['bulkImages']) && $_FILES['bulkImages']['error'][0] == 0) {
        $bulkImages = $_FILES['bulkImages'];
        $bulkImagePaths = [];
        foreach ($bulkImages['tmp_name'] as $index => $tmpName) {
            $bulkImagePath = 'uploads/images/' . uniqid('bulk_') . '.' . pathinfo($bulkImages['name'][$index], PATHINFO_EXTENSION);
            if (move_uploaded_file($tmpName, $bulkImagePath)) {
                $bulkImagePaths[] = $bulkImagePath;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload one or more bulk images']);
                exit;
            }
        }

        // Update database with the new bulk image paths
        $stmt = $conn->prepare("UPDATE product_images SET image_paths = ? WHERE product_id = ?");
        $stmt->bind_param("ss", implode(',', $bulkImagePaths), $product_id);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['status' => 'success', 'message' => 'Images uploaded successfully']);
    $conn->close();
}
?>
