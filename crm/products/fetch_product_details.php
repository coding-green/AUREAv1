<?php
include '../config.php';

$product_id = $_GET['product_id'];

$query = "SELECT * FROM Products WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $response = [
        'product_id' => $row['product_id'],
        'product_name' => $row['product_name'],
        'brand_id' => $row['brand_id'],
        'product_type_id' => $row['product_type_id'],
        'skin_types' => explode(',', $row['skin_type']) // Split skin type string into an array
    ];
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Product not found']);
}
?>
