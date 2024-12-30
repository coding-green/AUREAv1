<?php
include 'header.php';

// Initialize form data variables
$product_code = $customer_name = $invoice_no = $contact_person = $contact_mobile = "";

// Check if id is passed (for updating)
if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']);  // Decoding the id

    // Fetch data for the selected outward inventory to populate the form
    $sql = "SELECT * FROM inventory_product_outward WHERE outward_id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Populate form data with fetched data
        $product_code = $row['outward_id'];
        $customer_name = $row['product_to_name'];
        $invoice_no = $row['invoice/challan'];
        $contact_person = $row['contact_person_name'];
        $contact_mobile = $row['contact_person_mobile'];
    }
} else {
    $id = '';  // No ID means it's an add operation
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_code = $_POST['outward_code'];
    $customer_name = $_POST['customer_name'];
    $invoice_no = $_POST['invoice_no'];
    $contact_person = $_POST['contact_person'];
    $contact_mobile = $_POST['contact_mobile'];

    if ($id) {
        // Update operation
        $sql = "UPDATE `inventory_product_outward` 
                SET `product_to_name` = '$customer_name', 
                    `invoice/challan` = '$invoice_no', 
                    `contact_person_name` = '$contact_person', 
                    `contact_person_mobile` = '$contact_mobile' 
                WHERE `outward_id` = '$id'";
    } else {
        // Insert operation
        $sql = "INSERT INTO `inventory_product_outward` 
                (`outward_id`, `product_to_name`, `invoice/challan`, `contact_person_name`, `contact_person_mobile`)
                VALUES ('$product_code', '$customer_name', '$invoice_no', '$contact_person', '$contact_mobile')";
    }

    if (mysqli_query($conn, $sql)) {
        echo '<script>window.location.href="select-outward-products.php?outward_id=' . base64_encode($product_code) . '"</script>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
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
                                <?php echo $id ? 'Update Outward Inventory' : 'Add Outward Inventory'; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Outward Code *</label>
                                        <?php if ($id == ''): ?>
                                            <?php
                                            // Fetch the last inserted outward ID for new entries
                                            $sql = "SELECT outward_id FROM inventory_product_outward ORDER BY outward_id DESC LIMIT 1";
                                            $result = mysqli_query($conn, $sql);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                $row = mysqli_fetch_assoc($result);
                                                $lastId = $row['outward_id'];

                                                // Extract the numeric part from the last ID
                                                $numericPart = intval(substr($lastId, 4)); // Assuming the first 4 characters are 'GMDO'
                                        
                                                // Increment the numeric part by 1
                                                $newIdNumber = $numericPart + 1;

                                                // Generate the new outward ID with leading zeros
                                                $newOutwardId = 'GMDO' . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT);
                                            } else {
                                                // If no records are found, start with the first outward code
                                                $newOutwardId = 'GMDO00001';
                                            }
                                            ?>
                                            <input type="text" class="form-control" name="outward_code"
                                                value="<?php echo $newOutwardId; ?>" readonly required>
                                        <?php else: ?>
                                            <!-- In case of update, show the existing outward ID -->
                                            <input type="text" class="form-control" name="outward_code"
                                                value="<?php echo $product_code; ?>" readonly required>
                                        <?php endif; ?>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Invoice / Challan No. *</label>
                                        <input type="text" class="form-control" name="invoice_no" required
                                            value="<?php echo $invoice_no; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Name *</label>
                                        <input type="text" class="form-control" name="customer_name" required
                                            value="<?php echo $customer_name; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Person Name</label>
                                        <input type="text" class="form-control" name="contact_person"
                                            value="<?php echo $contact_person; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Person Mobile</label>
                                        <input type="text" class="form-control" name="contact_mobile"
                                            value="<?php echo $contact_mobile; ?>">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="outward.php" class="btn btn-secondary">Cancel</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
