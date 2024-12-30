<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $imagePath = $_POST['imagePath'];
    $imageType = $_POST['imageType'];
    // Delete image from the server
    if (file_exists($imagePath)) {
        unlink($imagePath);  // Remove the image file from the server
    }

    // Update the database to remove the image path
    if ($imageType == 'main') {
        // Remove the main image path
        $stmt = $conn->prepare("UPDATE product_images SET main_image_path = NULL WHERE product_id = ?");
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
    } elseif ($imageType == 'bulk') {
        // Remove the image from bulk images
        $stmt = $conn->prepare("SELECT image_paths FROM product_images WHERE product_id = ?");
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
        $stmt->bind_result($imagePaths);
        $stmt->fetch();
        $stmt->close();

        $imagePathsArray = explode(',', $imagePaths);
        $imagePathsArray = array_filter($imagePathsArray, function ($path) use ($imagePath) {
            return $path !== $imagePath;
        });

        $updatedImagePaths = implode(',', $imagePathsArray);
        $stmt = $conn->prepare("UPDATE product_images SET image_paths = ? WHERE product_id = ?");
        $stmt->bind_param("ss", $updatedImagePaths, $product_id);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Image removed successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove image']);
    }

    $stmt->close();
    $conn->close();
}
?>
