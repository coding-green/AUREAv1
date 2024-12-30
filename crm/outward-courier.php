<?php
include 'header.php';
$outward_id = base64_decode($_GET['outward_id']);  // Decoding the id if passed

// Initialize variables for form data
$courier_name = $courier_tracking_id = $dispatch_date = $delivery_date = $delivery_status = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courier_name = $_POST['courier_name'];
    $courier_tracking_id = $_POST['courier_tracking_id'];
    $dispatch_date = $_POST['dispatch_date'];
    $delivery_date = $_POST['delivery_date'];
    $delivery_status = $_POST['delivery_status'];
    $remarks = $_POST['remarks'];

    $filename = $_FILES['delivery_proof']['name'];
    $tempname = $_FILES['delivery_proof']['tmp_name'];
    $folder = "uploads/" . $filename;

    // Check if the file was uploaded without errors
    if (move_uploaded_file($tempname, $folder)) {
        // Insert or update form data into the database
        $sql = "UPDATE `inventory_product_outward` 
                SET `courier_name`='$courier_name', `courier_tracking_id`='$courier_tracking_id', 
                `dispatch_date`='$dispatch_date', `delivery_date`='$delivery_date', `status`='$delivery_status', 
                `delivery_proof`='$filename', `remark`='$remarks'
                WHERE `outward_id`='$outward_id'";

        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Outward Courier details updated successfully")</script>';
            echo '<script>window.location.href="view-outward.php?id=' . base64_encode($outward_id) . '"</script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error uploading the file.";
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
                                <?php echo $outward_id ? 'Update Outward Inventory' : 'Add Outward Inventory'; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data"> <!-- Add enctype here -->
                            <div class="row">
                                <?php
                                $sql = "SELECT * FROM inventory_product_outward WHERE outward_id = '$outward_id'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $courier_name = $row['courier_name'];
                                $courier_tracking_id = $row['courier_tracking_id'];
                                $dispatch_date = $row['dispatch_date'];
                                $delivery_date = $row['delivery_date'];
                                $delivery_status = $row['status'];
                                $remarks = $row['remark'];
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Outward ID *</label>
                                        <input type="text" class="form-control" name="outward_id" required readonly
                                            value="<?php echo isset($outward_id) ? $outward_id : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Courier Name *</label>
                                        <input type="text" class="form-control" name="courier_name" required
                                            value="<?php echo isset($courier_name) ? $courier_name : ''; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Courier Tracking ID *</label>
                                        <input type="text" class="form-control" name="courier_tracking_id" required
                                            value="<?php echo isset($courier_tracking_id) ? $courier_tracking_id : ''; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dispatch Date *</label>
                                        <input type="date" class="form-control" name="dispatch_date" required
                                            value="<?php echo isset($dispatch_date) ? $dispatch_date : ''; ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Delivery Date </label>
                                        <input type="date" class="form-control" name="delivery_date"
                                            value="<?php echo isset($delivery_date) ? $delivery_date : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Delivery Proof </label>
                                        <input type="file" class="form-control" name="delivery_proof">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Remarks </label>
                                        <input type="text" class="form-control" name="remarks"
                                            value="<?php echo isset($remarks) ? $remarks : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Delivery Status *</label>
                                        <select class="form-control" name="delivery_status" required>
                                            <option value="Pending" <?php echo $delivery_status == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Delivered" <?php echo $delivery_status == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="select-outward-products.php?outward_id=<?php echo base64_encode($outward_id); ?>"
                                class="btn btn-secondary">Back</a>
                            <a href="outward.php" class="btn btn-success">Finish</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>