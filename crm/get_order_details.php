<?php
include 'config.php'; // Include the database configuration file

// Check if order_id is set
if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Fetch the order details
    $sqlOrder = "SELECT * FROM orders WHERE order_id = ?";
    $stmtOrder = $conn->prepare($sqlOrder);
    $stmtOrder->bind_param("s", $orderId);
    $stmtOrder->execute();
    $orderResult = $stmtOrder->get_result();

    // Check if the order exists
    if ($orderResult->num_rows > 0) {
        $orderDetails = $orderResult->fetch_assoc();

        // Fetch order items along with product names
        $sqlItems = "SELECT oi.*, p.product_name 
                     FROM order_items oi
                     JOIN Products p ON oi.product_id = p.product_id
                     WHERE oi.order_id = ?";
        $stmtItems = $conn->prepare($sqlItems);
        $stmtItems->bind_param("s", $orderId);
        $stmtItems->execute();
        $itemResult = $stmtItems->get_result();
        $orderItems = [];

        while ($item = $itemResult->fetch_assoc()) {
            $orderItems[] = $item;
        }

        // Return the order details and items as JSON
        echo json_encode([
            'status' => 'success',
            'orderDetails' => $orderDetails,
            'orderItems' => $orderItems
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Order not found'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No order ID provided'
    ]);
}

mysqli_close($conn); // Close the database connection
?>
