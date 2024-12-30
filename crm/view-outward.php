<?php
include 'header.php';
$id = base64_decode($_GET['id']);
$sql = "SELECT * FROM inventory_product_outward WHERE outward_id = '$id'";
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
                            <h4 class="card-title">Outward Details</h4>
                        </div>
                        <a href="add-outward.php?id=<?php echo base64_encode($id); ?>"
                            class="btn btn-primary">Edit</a>
                        <button type="button" onclick="window.location.href='outward.php'"
                            class="btn btn-secondary">Back</button>
                    </div>
                    <div class="card-body">
                        <form action="" data-toggle="validator" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Outward Code :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $id; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Invoice No :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['invoice/challan']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Customer Name :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['product_to_name']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Person :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['contact_person_name']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Number :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['contact_person_mobile']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Courier Name :</label>&nbsp;
                                        <b><span 
                                        style="color:green;"><?php echo $row['courier_name']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Courier Tracking ID :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['courier_tracking_id']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dispatch Date :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['dispatch_date']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Delivery Date :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['delivery_date']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status :</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['status']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Remark</label>&nbsp;
                                        <b><span style="color:green;"><?php echo $row['remark']; ?></span></b>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Delivery Proof :</label>&nbsp;
                                        <b><span style="color:green;"><a href="uploads/<?php echo $row['delivery_proof']; ?>">View Proof</a></span></b>
                                    </div>
                                </div>
                                <div class="card-body" style="padding-top:0px;">
                                    <div class="table-responsive mb-3">
                                        <table class="data-table
                                table mb-0 tbl-server-info">
                                            <thead class="bg-white text-uppercase">
                                                <tr class="ligth ligth-data">
                                                    <th style="width: 100%;">Product Details</th>
                                                </tr>
                                            </thead>
                                            <tbody class="ligth-body">
                                                <?php
                                                $sql = "SELECT * FROM outward_serial where outward_id = '" . $id . "'";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <tr>
                                                        <td style="width: 100%;">
                                                            <div class="d-flex align-items-center">
                                                                <b>Product Name: </b> &nbsp;
                                                                <div>
                                                                    <?php
                                                                    $sql = "SELECT * FROM inventory_product_inward where product_id = '" . $row['product_id'] . "'";
                                                                    $result1 = mysqli_query($conn, $sql);
                                                                    $data = mysqli_fetch_assoc($result1);
                                                                    ?>
                                                                    <span
                                                                        style="color:green;"><?php echo $data['product_name']; ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <b>Serial No: </b> &nbsp;
                                                                <div>
                                                                    <span
                                                                        style="color:green;"><?php echo $row['serial_no']; ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <b>Quantity: </b> &nbsp;
                                                                <div>
                                                                    <span
                                                                        style="color:green;"><?php echo $row['quantity']; ?></span>
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