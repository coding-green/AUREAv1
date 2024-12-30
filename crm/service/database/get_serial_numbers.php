<?php
include 'config.php'; // Include your database connection file

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Fetch serial numbers based on selected product
    $sql = "SELECT serial_no, quantity FROM inward_serial WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $sql);

    // Generate options for the serial numbers
    echo "<option value=''>Select Serial Number</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['serial_no']}'>{$row['serial_no']} (Qty: {$row['quantity']})</option>";
    }
}
?>
