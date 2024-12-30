<?php
include 'header.php';
$id = base64_decode($_GET['installation_id']);  // Decoding the id

if(isset($_POST['submit'])){
    // Capture and sanitize POST inputs
    $installation_code = mysqli_real_escape_string($conn, $_POST['installation_code']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $installation_date = mysqli_real_escape_string($conn, $_POST['installation_date']);
    $warranty_period = mysqli_real_escape_string($conn, $_POST['warranty_period']);
    $warranty_start_date = mysqli_real_escape_string($conn, $_POST['warranty_start_date']);
    $warranty_end_date = mysqli_real_escape_string($conn, $_POST['warranty_end_date']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);

    // Allowed file extensions
    $allowed_extensions = array('pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'mp4', 'avi');

    // Handle file uploads
    // Installation Report
    if(isset($_FILES['installation_report']) && $_FILES['installation_report']['error'] == 0){
        $report_extension = pathinfo($_FILES['installation_report']['name'], PATHINFO_EXTENSION);
        if(in_array(strtolower($report_extension), $allowed_extensions)){
            $installation_report = $id . '_report.' . $report_extension; // Filename as installation_id_report.extension
            $installation_report_temp = $_FILES['installation_report']['tmp_name'];
            move_uploaded_file($installation_report_temp, "../uploads/installation_report/$installation_report");
        } else {
            echo "<script>alert('Invalid file type for Installation Report.');</script>";
            exit;
        }
    } else {
        $installation_report = ''; // Handle as per your requirement
    }

    // Installation Photo or Video
    if(isset($_FILES['installation_photo']) && $_FILES['installation_photo']['error'] == 0){
        $photo_extension = pathinfo($_FILES['installation_photo']['name'], PATHINFO_EXTENSION);
        if(in_array(strtolower($photo_extension), $allowed_extensions)){
            $installation_photo = $id . '_photo.' . $photo_extension;
            $installation_photo_temp = $_FILES['installation_photo']['tmp_name'];
            move_uploaded_file($installation_photo_temp, "../uploads/installation_photo_videos/$installation_photo");
        } else {
            echo "<script>alert('Invalid file type for Installation Photo/Video.');</script>";
            exit;
        }
    } else {
        $installation_photo = ''; // Handle as per your requirement
    }

    // Delivery Challan
    if(isset($_FILES['delivery_challan']) && $_FILES['delivery_challan']['error'] == 0){
        $challan_extension = pathinfo($_FILES['delivery_challan']['name'], PATHINFO_EXTENSION);
        if(in_array(strtolower($challan_extension), $allowed_extensions)){
            $delivery_challan = $id . '_challan.' . $challan_extension;
            $delivery_challan_temp = $_FILES['delivery_challan']['tmp_name'];
            move_uploaded_file($delivery_challan_temp, "../uploads/delivery_challan/$delivery_challan");
        } else {
            echo "<script>alert('Invalid file type for Delivery Challan.');</script>";
            exit;
        }
    } else {
        $delivery_challan = ''; // Handle as per your requirement
    }

    // Prepare SQL statement
    $sql = "UPDATE product_installation SET 
            installation_date = '$installation_date', 
            installation_report = '$installation_report', 
            after_installation_file = '$installation_photo', 
            warranty_period = '$warranty_period', 
            warranty_start_date = '$warranty_start_date', 
            warranty_expiry_date = '$warranty_end_date', 
            delivery_challan = '$delivery_challan', 
            remarks = '$remarks', 
            installation_status = 'Installation Done' 
            WHERE installation_id = '$id'";

    // Execute SQL query and handle errors
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Installation submitted successfully.');</script>";
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
                            <h4 class="card-title">Submit Installation</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data" id="installationForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        $id = base64_decode($_GET['installation_id']);
                                        ?>
                                        <label>Installation Code *</label>
                                        <input type="text" class="form-control" name="installation_code"
                                            value="<?php echo $id; ?>" readonly required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <?php
                                // Fetch customer name based on outward_id
                                $sql = "SELECT * FROM product_installation WHERE installation_id = '$id'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $outward = $row['outward_id'];

                                $sql = "SELECT * FROM inventory_product_outward WHERE outward_id = '$outward'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $customer_name = $row['product_to_name'];
                                ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Name *</label>
                                        <input type="text" class="form-control" name="customer_name" required readonly
                                            value="<?php echo $customer_name; ?>">
                                    </div>
                                </div>

                                <!-- Other fields -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Installation Date *</label>
                                        <input type="date" class="form-control" name="installation_date" id="installation_date" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Installation Report *</label>
                                        <input type="file" class="form-control" name="installation_report" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Installation Photo Or Video</label>
                                        <input type="file" class="form-control" name="installation_photo">
                                    </div>
                                </div>

                                <!-- Warranty details -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Warranty Period *</label>
                                        <select class="form-control" name="warranty_period" id="warranty_period" required>
                                            <option value="">Select Warranty Period</option>
                                            <option value="0.5">6 Months</option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                            <option value="5">5 Years</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Warranty Start Date *</label>
                                        <input type="date" class="form-control" name="warranty_start_date" id="warranty_start_date" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Warranty End Date *</label>
                                        <input type="date" class="form-control" name="warranty_end_date" id="warranty_end_date" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Delivery Challan *</label>
                                        <input type="file" class="form-control" name="delivery_challan" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" name="remarks" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <a href="outward.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript for auto-filling warranty start date and calculating warranty end date
document.getElementById('installation_date').addEventListener('change', function() {
    var installationDate = this.value;
    document.getElementById('warranty_start_date').value = installationDate;
});

document.getElementById('warranty_period').addEventListener('change', function() {
    var startDate = document.getElementById('warranty_start_date').value;
    var period = parseFloat(this.value);
    
    if (startDate && period) {
        var warrantyEndDate = new Date(startDate);
        var daysToAdd = period === 0.5 ? 182.5 : 365 * period;
        warrantyEndDate.setDate(warrantyEndDate.getDate() + daysToAdd);

        var year = warrantyEndDate.getFullYear();
        var month = ('0' + (warrantyEndDate.getMonth() + 1)).slice(-2);
        var day = ('0' + warrantyEndDate.getDate()).slice(-2);
        document.getElementById('warranty_end_date').value = year + '-' + month + '-' + day;
    }
});
</script>

<?php
include 'footer.php';
?>
