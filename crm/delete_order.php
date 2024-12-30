<?php
// Include your database connection
include 'config.php';

// Check if order_id is passed via POST
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Prepare the SQL statement to delete the order
    $sql = "DELETE FROM orders WHERE order_id = ?";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the order_id to the prepared statement
        $stmt->bind_param("s", $order_id);
        
        // Execute the query
        if ($stmt->execute()) {
            // Success: Return success status
            echo json_encode(['status' => 'success', 'message' => 'Order deleted successfully.']);
        } else {
            // Failure: Return error status
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete order.']);
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
