<?php
// Include your database connection
include 'config.php';

// Check if order_id is passed via POST
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Prepare the SQL query to fetch order details
    $sql = "SELECT o.*, m.first_name, m.last_name FROM orders o
            JOIN members_login m ON o.user_id = m.user_id
            WHERE o.order_id = ?";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the order_id to the prepared statement
        $stmt->bind_param("s", $order_id);
        
        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Fetch the order details
                $order = $result->fetch_assoc();

                // Return order details as JSON
                echo json_encode([
                    'status' => 'success',
                    'order' => [
                        'order_id' => $order['order_id'],
                        'full_name' => $order['first_name'] . ' ' . $order['last_name'],
                        'shipping_city' => $order['shipping_city'],
                        'total_amount' => $order['total_amount'],
                        'order_status' => $order['order_status'],
                        'payment_status' => $order['payment_status'],
                        'order_date' => $order['created_at']
                    ]
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Order not found.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to execute query.']);
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL query.']);
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Order ID not provided.']);
}
?>
