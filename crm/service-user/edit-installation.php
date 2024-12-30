<?php
include 'header.php';

// Initialize form data variables
$product_code = $customer_name = $invoice_no = $contact_person = $contact_mobile = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $installation_code = $_POST['installation_code'];
    $invoice_no = $_POST['invoice_no'];
    $customer_name = $_POST['customer_name'];
    $contact_person = $_POST['contact_person'];
    $contact_mobile = $_POST['contact_mobile'];
    $intall_method = $_POST['intall_method'];
    $installation_date = $_POST['installation_date'];

    // Prepare an insert statement
    $sql = "update product_installation set method_of_installation = '$intall_method', plan_to_install_date = '$installation_date', installation_status= 'Installation Shedule' where installation_id = '$installation_code'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Installation scheduled successfully.');</script>";
        echo "<script>window.location.href='installation.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
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
                                Shedule Installation
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        $id = base64_decode($_GET['installation_id']);  // Decoding the id
                                        ?>
                                        <label>Installation Code *</label>
                                        <input type="text" class="form-control" name="installation_code"
                                            value="<?php echo $id; ?>" readonly required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <?php
                                $sql = "SELECT * FROM product_installation WHERE installation_id = '$id'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $outward = $row['outward_id'];
                                $sql = "SELECT * FROM inventory_product_outward WHERE outward_id = '$outward'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $invoice_no = $row['invoice/challan'];
                                $customer_name = $row['product_to_name'];
                                $contact_person = $row['contact_person_name'];
                                $contact_mobile = $row['contact_person_mobile'];
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Invoice / Challan No. *</label>
                                        <input type="text" class="form-control" name="invoice_no" required readonly 
                                            value="<?php echo $invoice_no; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Name *</label>
                                        <input type="text" class="form-control" name="customer_name" required readonly 
                                            value="<?php echo $customer_name; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Person Name *</label>
                                        <input type="text" class="form-control" name="contact_person" required readonly 
                                            value="<?php echo $contact_person; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Person Mobile *</label>
                                        <input type="text" class="form-control" name="contact_mobile" required readonly 
                                            value="<?php echo $contact_mobile; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Installation Method *</label>
                                        <select class="form-control" name="intall_method" required>
                                            <option value="">Select</option>
                                            <option value="Visit">Visit</option>
                                            <option value="Video Call">Video Call</option>
                                            <option value="Instruction Videos">Instruction Videos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Installation Date *</label>
                                        <input type="date" class="form-control" name="installation_date" required>
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