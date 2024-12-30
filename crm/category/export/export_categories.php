<?php

include '../../config.php'; // Ensure correct path to config.php

// Retrieve category from the query string
$category = $_GET['category'] ?? 'product-type';

// Set CSV headers for download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $category . '_categories.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Output header row based on category
if ($category === 'product-type') {
    fputcsv($output, ['Product Type ID', 'Product Type Name']);
    $query = "SELECT product_type_id, product_type_name FROM ProductType";
} elseif ($category === 'skin-type') {
    fputcsv($output, ['Skin Type ID', 'Skin Type Name']);
    $query = "SELECT skin_type_id, skin_type_name FROM SkinTypes";
} elseif ($category === 'skin-concern') {
    fputcsv($output, ['Skin Concern ID', 'Concern Name']);
    $query = "SELECT skin_concern_id, concern_name FROM SkinConcerns";
} elseif ($category === 'formulation') {
    fputcsv($output, ['Formulation ID', 'Formulation Name']);
    $query = "SELECT formulation_id, formulation_name FROM Formulation";
} elseif ($category === 'brand') {
    fputcsv($output, ['Brand ID', 'Brand Name']);
    $query = "SELECT brands_id, brands_name FROM Brands";
} elseif ($category === 'aurea-collection') {
    fputcsv($output, ['Aurea Collection ID', 'Aurea Collection Name']);
    $query = "SELECT aurea_collection_id, aurea_collection_name FROM AureaCollection";
} elseif ($category === 'size') {
    fputcsv($output, ['Size ID', 'Size Name']);
    $query = "SELECT size_id, size_name FROM Size";
} elseif ($category === 'currency') {
    fputcsv($output, ['Currency ID', 'Currency Name']);
    $query = "SELECT currency_id, currency_name FROM Currency";
} else {
    fputcsv($output, ['ID', 'Name']); // Generic headers if no category matches
    $query = "SELECT id, name FROM GenericTable"; // Adjut to a default query or show an error
}

// Execute the query
$result = mysqli_query($conn, $query);

// Output each row of data
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

// Close the output stream
fclose($output);
exit();
?>
