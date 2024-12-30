<?php
include 'header.php';
$id = base64_decode($_GET['id']);

# ADD SERIAL
if (isset($_POST['product_code'])) {
    $serial_code = $_POST['serial_code'];
    $receive_by = $_POST['receive_by'];
    $from = $_POST['from'];
    $quantity = $_POST['quantity'];
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : NULL; // Check if expiry_date is provided

    // SQL query to check if serial code already exists
    $sql = "SELECT * FROM inward_serial WHERE product_id = ? AND serial_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id, $serial_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Serial already exists');</script>";
        echo "<script>window.location.href='add-inward-serial.php?id=" . base64_encode($id) . "';</script>";
        exit();
    } else {
        // Insert new serial code (expiry_date is optional)
        $sql = "INSERT INTO inward_serial (product_id, serial_no, receive_by, product_from, quantity, expiry_date) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $id, $serial_code, $receive_by, $from, $quantity, $expiry_date);

        if ($stmt->execute()) {
            echo "<script>alert('Serial added successfully');</script>";
        } else {
            echo "<script>alert('Failed to add serial');</script>";
        }
    }
}


# DELETE SERIAL
if (isset($_POST['delete'])) {
    $sid = $_POST['id'];
    $sql = "DELETE FROM inward_serial WHERE serial_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sid);

    if ($stmt->execute()) {
        echo "<script>alert('Serial deleted successfully');</script>";
        echo "<script>window.location.href='add-inward-serial.php?id=" . base64_encode($id) . "';</script>";
    } else {
        echo "<script>alert('Failed to delete serial');</script>";
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
                            <h4 class="card-title">Add Serial</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" data-toggle="validator" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Code *</label>
                                        <input type="text" class="form-control" name="product_code"
                                            value="<?php echo $id; ?>" readonly required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Receive By *</label>
                                        <input type="text" class="form-control" placeholder="Enter Receiver Name"
                                            data-errors="Please Enter Receiver Name." required name="receive_by">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>From *</label>
                                        <input type="text" class="form-control" placeholder="Enter From Name"
                                            data-errors="Please Enter From Name." required name="from">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="serial_code">Serial Code *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="serial_code" name="serial_code"
                                                placeholder="Enter Serial Code" required>
                                            <span class="input-group-text" onclick="fillSerialCode()">
                                                <i class="fas fa-sync-alt"></i>
                                            </span>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Quantity *</label>
                                        <input type="number" class="form-control" placeholder="Enter Quantity"
                                            data-errors="Please Enter Quantity." required name="quantity" min="1" step="1">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Optional Expiry Date</label>
                                        <input type="date" class="form-control" name="expiry_date">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>      
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Add Serial</button>
                            <button type="button" onclick="window.location.href='products.php'"
                                class="btn btn-secondary">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Serial list section -->
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
                                $sql = "SELECT * FROM inward_serial WHERE product_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s", $id);
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
                                            <div class="d-flex align-items-center">
                                                <b>Receive By:</b>&nbsp;
                                                <div><span style="color:green;"><?php echo $row['receive_by']; ?></span></div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <b>From:</b>&nbsp;
                                                <div><span style="color:green;"><?php echo $row['product_from']; ?></span></div>
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

<!-- JavaScript -->
<script>
    function generateSerialCode(length = 12) {
        const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        let serialCode = '';
        for (let i = 0; i < length; i++) {
            serialCode += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return serialCode;
    }

    function fillSerialCode() {
        const serialCode = generateSerialCode();
        document.getElementById('serial_code').value = serialCode;
    }
</script>

<style>
    .input-group-text {
        cursor: pointer;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>