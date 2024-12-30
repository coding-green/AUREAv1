<?php
include 'header.php';
$id = base64_decode($_GET['id']);
$sql = "SELECT * FROM inventory_product_inward WHERE product_id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>

<div class="content-page">
    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Product Details</h4>
                        </div>
                        <button type="button" onclick="window.location.href='products.php'"
                            class="btn btn-secondary">Back</button>
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
                                        <label>Product Name *</label>
                                        <input type="text" class="form-control" name="product_code"
                                            value="<?php echo $row['product_name']; ?>" readonly required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date *</label>
                                        <input type="text" class="form-control" name="product_code"
                                            value="<?php echo $row['created_at']; ?>" readonly required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <div class="table-responsive mb-3">
                                            <table class="data-table table mb-0 tbl-server-info">
                                                <thead class="bg-white text-uppercase">
                                                    <tr class="light light-data">
                                                        <th>Serial Details</th>
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
                                                            <td style="width:100%;">
                                                                <div class="d-flex align-items-center">
                                                                    <b>Product ID:</b>&nbsp;
                                                                    <div><span
                                                                            style="color:green;"><?php echo $row['product_id']; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <b>Serial No:</b>&nbsp;
                                                                    <div><span
                                                                            style="color:green;"><?php echo $row['serial_no']; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <b>Quantity:</b>&nbsp;
                                                                    <div><span
                                                                            style="color:green;"><?php echo $row['quantity']; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <b>Receive By:</b>&nbsp;
                                                                    <div><span
                                                                            style="color:green;"><?php echo $row['receive_by']; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center">
                                                                    <b>From:</b>&nbsp;
                                                                    <div><span
                                                                            style="color:green;"><?php echo $row['product_from']; ?></span>
                                                                    </div>
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
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">





            </div>
            <!-- Page end  -->
        </div>
    </div>
</div>
<!-- Wrapper End-->


<?php include 'footer.php'; ?>