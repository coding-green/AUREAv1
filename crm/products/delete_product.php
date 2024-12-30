<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    $response = [];
    $sql = "DELETE FROM Products WHERE product_id = '$id'";
    if (mysqli_query($conn, $sql)) {
        $response['status'] = 'success';
        $response['message'] = 'Product deleted successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to delete the product.';
    }
    
    // Return JSON response
    echo json_encode($response);
    exit;
}
