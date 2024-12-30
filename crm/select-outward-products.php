<?php
include 'header.php';  // Include the header file for database connection
$outward_id = base64_decode($_GET['outward_id']);  // Decoding the id if passed

if (isset($_POST['add_outward'])) {
    $product_id = $_POST['product_id'];
    $serial_no = $_POST['serial_no'];
    $quantity = $_POST['quantity'];

    // Fetch the current quantity, receive_by, and product_from from inward_serial
    $sql = "SELECT quantity, receive_by, product_from FROM inward_serial WHERE product_id = ? AND serial_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $product_id, $serial_no);
    $stmt->execute();
    $stmt->bind_result($current_quantity, $receive_by, $product_from);
    $stmt->fetch();
    $stmt->close();

    if ($current_quantity >= $quantity) {
        // Subtract the quantity from inward_serial
        $new_quantity = $current_quantity - $quantity;
        $update_sql = "UPDATE inward_serial SET quantity = ? WHERE product_id = ? AND serial_no = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iss", $new_quantity, $product_id, $serial_no);
        $update_stmt->execute();
        $update_stmt->close();

        // Insert the new record into outward_serial
        $status = 'outward';  // Modify this as per your logic
        $insert_sql = "INSERT INTO outward_serial (outward_id, serial_no, product_id, receive_by, product_from, quantity, status) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sssssis", $outward_id, $serial_no, $product_id, $receive_by, $product_from, $quantity, $status);
        $insert_stmt->execute();
        $insert_stmt->close();

        echo "Outward record added successfully!";
    } else {
        echo "Error: Quantity exceeds available stock.";
    }
}

// Delete outward product and restore quantity to inward_serial table
if (isset($_POST['delete'])) {
    $serial_no = $_POST['id'];  // serial_no

    // Fetch the quantity and product details from outward_serial before deletion
    $fetch_sql = "SELECT product_id, serial_no, quantity FROM outward_serial WHERE serial_no = ?";
    $stmt = $conn->prepare($fetch_sql);
    $stmt->bind_param("s", $serial_no);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($fetch_row = $result->fetch_assoc()) {
        $product_id = $fetch_row['product_id'];
        $serial_no = $fetch_row['serial_no'];
        $quantity = $fetch_row['quantity'];

        // Update the quantity in inward_serial
        $update_sql = "UPDATE inward_serial SET quantity = quantity + ? WHERE product_id = ? AND serial_no = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iss", $quantity, $product_id, $serial_no);
        if ($update_stmt->execute()) {
            // Delete the outward product after updating the inward_serial
            $delete_sql = "DELETE FROM outward_serial WHERE serial_no = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("s", $serial_no);
            if ($delete_stmt->execute()) {
                echo "<script>alert('Outward product deleted successfully');</script>";
                echo "<script>window.location.href='select-outward-products.php?outward_id=" . base64_encode($outward_id) . "';</script>";
            } else {
                echo "<script>alert('Failed to delete outward product');</script>";
            }
        } else {
            echo "<script>alert('Failed to restore quantity');</script>";
        }
        $update_stmt->close();
    }
    $stmt->close();
}
?>

<div class="content-page">
    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">
                                <?php echo $out_id ? 'Update Outward Inventory' : 'Add Outward Inventory'; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Outward ID *</label>
                                        <input type="text" class="form-control" name="outward_id" required readonly
                                            value="<?php echo isset($outward_id) ? $outward_id : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Product *</label>
                                        <select class="form-control" id="product_id" name="product_id" required>
                                            <option value="">Select Product</option>
                                            <?php
                                            // Fetch products from inventory_product_inward table
                                            $sql = "SELECT product_id, product_name FROM inventory_product_inward";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['product_id']}'>{$row['product_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Serial Number *</label>
                                        <select class="form-control" id="serial_no" name="serial_no" required>
                                            <option value="">Select Serial Number</option>
                                            <!-- Options will be loaded dynamically via AJAX -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Quantity *</label>
                                        <input type="number" class="form-control" name="quantity" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" name="add_outward">ADD</button>
                            <a href="outward-courier.php?outward_id=<?php echo base64_encode($outward_id); ?>"
                                class="btn btn-secondary">Next</a>
                                <a href="outward.php" class="btn btn-danger">Back</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Display the Outward Serial Records -->
            <div class="col-sm-12">
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="data-table table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">
                                <tr class="light light-data">
                                    <th>Serial Details</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody class="light-body">
                                <?php
                                $sql = "SELECT * FROM outward_serial WHERE outward_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $outward_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td style="width:80%;">
                                            <div class="d-flex align-items-center">
                                                <b>Product ID:</b>&nbsp;
                                                <div><span style="color:green;"><?php echo $row['product_id']; ?></span></div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <b>Serial No:</b>&nbsp;
                                                <div><span style="color:green;"><?php echo $row['serial_no']; ?></span></div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <b>Quantity:</b>&nbsp;
                                                <div><span style="color:green;"><?php echo $row['quantity']; ?></span></div>
                                            </div>
                                        </td>
                                        <td style="width:20%;">
                                            <div class="d-flex align-items-center list-action">
                                                <form action="" method="post">
                                                    <input type="hidden" name="id" value="<?php echo $row['serial_no']; ?>">
                                                    <button type="submit" class="badge badge-danger mr-2"
                                                        style="border: none; background: none;" name="delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- jQuery for dynamic serial number loading -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Trigger when the product is selected
        $('#product_id').change(function () {
            var product_id = $(this).val(); // Get selected product ID

            if (product_id !== "") {
                $.ajax({
                    url: 'database/get_serial_numbers.php', // PHP file to handle the request
                    type: 'POST',
                    data: { product_id: product_id },
                    success: function (response) {
                        $('#serial_no').html(response); // Update the serial_no dropdown
                    }
                });
            } else {
                $('#serial_no').html('<option value="">Select Serial Number</option>'); // Reset if no product is selected
            }
        });
    });
</script>
