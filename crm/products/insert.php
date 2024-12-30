<?php
include '../config.php'; // Include your database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Collect and sanitize the POST data
$product_type_id = mysqli_real_escape_string($conn, $_POST['product_type_id']);
$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
$brand_id = mysqli_real_escape_string($conn, $_POST['brand_id']);
$product_tagline = mysqli_real_escape_string($conn, $_POST['product_tagline']);
$formulation_id = mysqli_real_escape_string($conn, $_POST['formulation_id']);
$skin_type_id = implode(',', array_map(function($item) use ($conn) { return mysqli_real_escape_string($conn, $item); }, $_POST['skin_type_id'])); // Sanitize array items
$skin_concern_id = implode(',', array_map(function($item) use ($conn) { return mysqli_real_escape_string($conn, $item); }, $_POST['skin_concern_id'])); // Sanitize array items
$product_size = mysqli_real_escape_string($conn, $_POST['product_size']);
$product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
$product_price_unit = mysqli_real_escape_string($conn, $_POST['price_unit']);
$ideal_for = mysqli_real_escape_string($conn, $_POST['ideal_for']);
$product_status = mysqli_real_escape_string($conn, $_POST['product_status']);
$web_status = mysqli_real_escape_string($conn, $_POST['web_status']);
$shelf_no = mysqli_real_escape_string($conn, $_POST['shelf_no']);
$shelf_life_unit = mysqli_real_escape_string($conn, $_POST['shelf_life_unit']);
$period_after_opening_no = mysqli_real_escape_string($conn, $_POST['period_after_opening_no']);
$period_after_opening_unit = mysqli_real_escape_string($conn, $_POST['period_after_opening_unit']);
$regimen_step = mysqli_real_escape_string($conn, $_POST['regimen_step']);



// Generate Product ID (example: AB/P0001)
$query = "SELECT MAX(CAST(SUBSTRING(product_id, 6) AS UNSIGNED)) AS max_id FROM Products";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn)); // Check for database query errors
}
$row = mysqli_fetch_assoc($result);
$max_id = $row['max_id'] ? $row['max_id'] : 0; // fallback to 0 if NULL
$new_product_id = 'AB/P' . str_pad($max_id + 1, 4, '0', STR_PAD_LEFT);

// Insert the data into the Products table
$sql = "INSERT INTO Products (product_id, product_type, product_name, brand, product_tagline, skin_type, skin_concern, formulation_texture, size, price, ideal_for, product_status, product_web_status, status, currency, shelf_life, regimen_recommendation, period_after_opening)
        VALUES ('$new_product_id', '$product_type_id', '$product_name', '$brand_id', '$product_tagline', '$skin_type_id', '$skin_concern_id', '$formulation_id', '$product_size', '$product_price','$ideal_for', '$product_status', '$web_status', 'active', '$product_price_unit', '$shelf_no $shelf_life_unit', '$regimen_step', '$period_after_opening_no $period_after_opening_unit')";


if (mysqli_query($conn, $sql)) {
    $sql = "INSERT INTO product_images (product_id) VALUES ('$new_product_id')";
    mysqli_query($conn, $sql); // Insert a new row into the product_images table
    echo json_encode(['status' => 'success', 'product_id' => base64_encode($new_product_id)]); // Return success and product_id
} else {
    echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]); // Return error
}
// Close the connection
mysqli_close($conn);
?>
