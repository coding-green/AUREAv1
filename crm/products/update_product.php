<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $product_id = $_POST['products_code'];
    $price = $_POST['products_price'];

    // Update the product details
    $sql = "UPDATE Products SET price = '$price' WHERE product_id = '$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update product.']);
    }

    $conn->close();
}
?>
