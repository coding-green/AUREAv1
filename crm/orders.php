<?php
include 'header.php';
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <!-- Orders List -->
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Orders</h4>
                    </div>
                </div>
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Full Name</th>
                                <th>Shipping City</th>
                                <th>Total Amount</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM orders";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="badge badge-danger mr-2"
                                                style="border: none; background: none;" data-toggle="modal"
                                                data-target="#deleteModal"
                                                onclick="setDeleteOrderId('<?php echo $row['order_id']; ?>')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td><a href="javascript:void(0);" data-toggle="modal" data-target="#viewModal"
                                            onclick="viewOrderDetails('<?php echo $row['order_id']; ?>')">
                                            <?php echo $row['order_id']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        $sql = "SELECT * FROM members_login WHERE user_id = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("s", $row['user_id']);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $member = $result->fetch_assoc();
                                        echo $member['first_name'] . ' ' . $member['last_name'];
                                        ?>
                                    </td>
                                    <td><?php echo $row['shipping_city']; ?></td>
                                    <td><?php echo $row['total_amount']; ?></td>
                                    <td><?php echo $row['order_status']; ?></td>
                                    <td><?php echo $row['payment_status']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this order?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="order_id" id="deleteOrderId">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteOrder()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Response</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="messageModalBody">
                <!-- Dynamic Response Message -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View Order Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="viewOrderId"><strong>Order ID:</strong></label>
                            <p id="viewOrderId"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewTotalAmount"><strong>Total Amount:</strong></label>
                            <p id="viewTotalAmount"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewOrderStatus"><strong>Order Status:</strong></label>
                            <p id="viewOrderStatus"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewPaymentStatus"><strong>Payment Status:</strong></label>
                            <p id="viewPaymentStatus"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="viewShippingCity"><strong>Shipping City:</strong></label>
                            <p id="viewShippingCity"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewOrderDate"><strong>Order Date:</strong></label>
                            <p id="viewOrderDate"></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><strong>Order Items:</strong></label>
                    <table class="table table-bordered" id="orderItemsTable">
                        <thead>
                            <tr>
                                <th>Order Item ID</th>
                                <th>Product ID</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic order item rows will go here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script>
    // Set Order ID for deletion
    function setDeleteOrderId(orderId) {
        document.getElementById('deleteOrderId').value = orderId;
    }

    // Delete Order Function
    function deleteOrder() {
        const orderId = document.getElementById('deleteOrderId').value;

        // AJAX Request to delete the order
        fetch('delete_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `order_id=${encodeURIComponent(orderId)}`
        })
            .then(response => response.json())
            .then(data => {
                // Update Message Modal
                const messageModalBody = document.getElementById('messageModalBody');
                const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));

                if (data.status === 'success') {
                    messageModalBody.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                } else {
                    messageModalBody.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }

                // Close Delete Modal
                $('#deleteModal').modal('hide');

                // Show Message Modal
                messageModal.show();

                // Reload Data
                setTimeout(() => {
                    location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                const messageModalBody = document.getElementById('messageModalBody');
                messageModalBody.innerHTML = `<div class="alert alert-danger">An unexpected error occurred.</div>`;
                const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
                messageModal.show();
            });
    }
    function viewOrderDetails(orderId) {
    fetch('get_order_details.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `order_id=${encodeURIComponent(orderId)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Populate order details
            document.getElementById('viewOrderId').innerText = data.orderDetails.order_id;
            document.getElementById('viewTotalAmount').innerText = data.orderDetails.total_amount;
            document.getElementById('viewOrderStatus').innerText = data.orderDetails.order_status;
            document.getElementById('viewPaymentStatus').innerText = data.orderDetails.payment_status;
            document.getElementById('viewShippingCity').innerText = data.orderDetails.shipping_city;
            document.getElementById('viewOrderDate').innerText = data.orderDetails.created_at;

            // Populate order items
            const orderItemsTable = document.getElementById('orderItemsTable').getElementsByTagName('tbody')[0];
            orderItemsTable.innerHTML = ''; // Clear any previous rows
            data.orderItems.forEach(item => {
                const row = orderItemsTable.insertRow();
                row.innerHTML = `
                    <td>${item.order_item_id}</td>
                    <td>${item.product_name}</td> <!-- Display product name -->
                    <td>${item.quantity}</td>
                    <td>${item.price}</td>
                    <td>${item.total_price}</td>
                `;
            });
        } else {
            console.log('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


</script>

<?php
include 'footer.php';
?>