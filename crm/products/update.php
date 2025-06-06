<?php
include '../config.php'; // Include your database connection

// Handle the request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $product_id = base64_decode($_POST['product_id']);
    $product_name  = $_POST['product_name'];
    $product_type_id = $_POST['product_type_id'];
    $brand_id = $_POST['brand_id'];
    $tagline = $_POST['product_tagline'];
    $formulation_id = $_POST['formulation_id'];
    $skin_type_id = implode(',', array_map(function($item) use ($conn) { return mysqli_real_escape_string($conn, $item); }, $_POST['skin_type_id'])); // Sanitize array items
    $skin_concern_id = implode(',', array_map(function($item) use ($conn) { return mysqli_real_escape_string($conn, $item); }, $_POST['skin_concern_id'])); // Sanitize array items
    $regimen_step = $_POST['regimen_step'];
    $product_size = $_POST['product_size_no'];
    $product_size_unit = $_POST['product_size_unit'];
    $product_size = $product_size . ' ' . $product_size_unit;
    $product_price = $_POST['product_price_no'];
    $product_price_unit = $_POST['product_price_unit'];
    $ideal_for = $_POST['ideal_for'];
    $product_status = $_POST['product_status'];
    $web_status = $_POST['web_status'];
    $aurea_collection_id = $_POST['aurea_collection_id'];
    $shelf_no = $_POST['shelf_no'];
    $shelf_unit = $_POST['shelf_life_unit'];
    $shelf_life = $shelf_no . ' ' . $shelf_unit;
    $regimen_step = $_POST['regimen_step'];
    $key_ingredients = $_POST['key_ingredients'];
    $how_to_use = $_POST['how_to_use'];
    $benefits = $_POST['benefits'];
    $product_description = $_POST['product_description'];
    $all_ingredients = $_POST['all_ingredients'];
    $warning_statement = $_POST['warning_statement'];
    $period_after_opening_no = $_POST['period_after_opening_no'];
    $period_after_opening_unit = $_POST['period_after_opening_unit'];
    $period_after_opening = $period_after_opening_no . ' ' . $period_after_opening_unit;

    // Update query
    $update_query = "UPDATE Products SET 
                        product_name = '$product_name',
                        product_type = '$product_type_id',
                        brand = '$brand_id',
                        product_tagline = '$tagline',
                        skin_type = '$skin_type_id',
                        skin_concern = '$skin_concern_id',
                        formulation_texture = '$formulation_id',
                        size = '$product_size',
                        price = '$product_price',
                        currency = '$product_price_unit',
                        ideal_for = '$ideal_for',
                        product_status = '$product_status',
                        product_web_status = '$web_status',
                        featured_status = '$aurea_collection_id', 
                        shelf_life = '$shelf_life', 
                        regimen_recommendation = '$regimen_step',
                        key_ingredients = '$key_ingredients',
                        how_to_use = '$how_to_use',
                        product_benefits = '$benefits',
                        description = '$product_description',
                        all_ingredients = '$all_ingredients',
                        warning_statement = '$warning_statement',
                        period_after_opening = '$period_after_opening' WHERE product_id = '$product_id'";

    // Execute the query
    if (mysqli_query($conn, $update_query)) {
        echo json_encode(['status' => 'success', 'message' => 'Product details updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed: ' . mysqli_error($conn)]);
    }
}
?>
