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
        $outward = $row['outward_id'];
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
    $installation_code = $_POST['installation_code'];
    $sql = "SELECT * FROM inventory_product_outward WHERE outward_id = '$outward'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $contact_person = $row['contact_person_name'];
    $contact_mobile = $row['contact_person_mobile'];
    $invoice_no = $_POST['invoice_no'];
    $customer_name = $_POST['customer_name'];
    $operator_id = $_POST['operator_id'];

    // Insert operation
    $sql ="insert into `product_installation` (`installation_id`, `outward_id`, `invoice/challan`, `product_to_name`, `contact_person_name`, `contact_person_mobile`, `operator_id`)
    VALUES ('$installation_code', '$outward', '$invoice_no', '$customer_name', '$contact_person', '$contact_mobile', '$operator_id')";
    if (mysqli_query($conn, $sql)) {
        echo '<script>window.location.href="outward.php"</script>';
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
                                Assign Operator
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Service Code *</label>
                                        <?php
                                        // Fetch the last inserted outward ID for new entries
                                        $sql = "SELECT installation_id FROM product_installation ORDER BY installation_id DESC LIMIT 1";
                                        $result = mysqli_query($conn, $sql);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            $row = mysqli_fetch_assoc($result);
                                            $lastId = $row['installation_id'];

                                            // Extract the numeric part from the last ID
                                            $numericPart = intval(substr($lastId, 4)); // Assuming the first 4 characters are 'GMDO'
                                        
                                            // Increment the numeric part by 1
                                            $newIdNumber = $numericPart + 1;

                                            // Generate the new outward ID with leading zeros
                                            $newinstallationId = 'GMDI' . str_pad($newIdNumber, 5, '0', STR_PAD_LEFT);
                                        } else {
                                            // If no records are found, start with the first outward code
                                            $newinstallationId = 'GMDI00001';
                                        }
                                        ?>
                                        <input type="text" class="form-control" name="installation_code"
                                            value="<?php echo $newinstallationId; ?>" readonly required>
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
                                        <label>Operator Name</label>
                                        <select class="form-control" name="operator_id">
                                            <option value="">Select Operator</option>
                                            <option value="GMD100302">Rahul Thate</option>
                                            <option value="GMD100309">Ruturaj Bhagwat</option>
                                            <option value="GMD100310">Pushpak Mahakalkar</option>
                                            <option value="GMD100311">Gaurav Singh</option>
                                            <option value="GMD100302">Rohit Kumar</option>
                                            <option value="GMD100302">Kapil Bhuwan</option>
                                            <option value="GMD100302">Avinash Rupnare</option>
                                            <option value="GMD100302">Ritesh Singh</option>
                                            <option value="GMD100302">Govind Singh</option>
                                        </select>
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