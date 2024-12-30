<?php
include '../config.php';

if (isset($_POST['id'])) {
    $productId = $_POST['id'];
    $sql = "SELECT * FROM Products WHERE product_id = '$productId'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Fetch product type information
        $productTypeId = $product['product_type'];
        $sqlpt = "SELECT * FROM ProductType WHERE product_type_id = '$productTypeId'";
        $resultpt = mysqli_query($conn, $sqlpt);

        if ($resultpt) {
            $productType = mysqli_fetch_assoc($resultpt);
            $product['product_type_name'] = $productType['product_type_name'];  // Assuming column name is 'product_type_name'
        } else {
            $product['product_type_name'] = 'Unknown';
        }

        // Send back the product data as JSON
        echo json_encode($product);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided.']);
}

mysqli_close($conn);
?>
