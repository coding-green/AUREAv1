<?php
include 'header.php';

# Delete outward product and restore quantity to inward table
if (isset($_POST['delete'])) {
    $id = $_POST['id'];  // outward_id


    // Fetch the quantity and product details from the outward_serial table before deleting
    $fetch_sql = "SELECT product_id, serial_no, quantity FROM outward_serial WHERE outward_id = '$id'";
    $fetch_result = mysqli_query($conn, $fetch_sql);

    while ($fetch_row = mysqli_fetch_assoc($fetch_result)) {
        $product_id = $fetch_row['product_id'];
        $serial_no = $fetch_row['serial_no'];
        $quantity = $fetch_row['quantity'];

        // Update the quantity in the inward_serial table
        $update_sql = "UPDATE inward_serial SET quantity = quantity + '$quantity' WHERE product_id = '$product_id' AND serial_no = '$serial_no'";
        if (mysqli_query($conn, $update_sql)) {
            // Delete the outward product
            $sql = "DELETE FROM inventory_product_outward WHERE outward_id = '$id'";
            if (mysqli_query($conn, $sql)) {
                $sql = "DELETE FROM outward_serial WHERE outward_id = '$id'";
                if (mysqli_query($conn, $sql)) {

                    echo "<script>alert('Outward product deleted successfully');</script>";
                    echo "<script>window.location.href='outward.php';</script>";
                } else {
                    echo "<script>alert('Failed to delete outward product');</script>";
                }
            } else {
                echo "<script>alert('Failed to delete outward product');</script>";
            }
        } else {
            echo "<script>alert('Failed to restore quantity');</script>";
        }
    }


}
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Outward List</h4>
                    </div>
                    <a href="add-outward.php" class="btn btn-primary add-list"><i class="las la-plus mr-3"></i>Add
                        Outward</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>Outward Details</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM inventory_product_outward";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td style="width: 10%;">
                                        <div class="d-flex align-items-center">
                                            <b>Code:</b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['outward_id']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Invoice No:</b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['invoice/challan']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Customer Name:</b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['product_to_name']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Courier Name:</b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['courier_name']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>DOC ID:</b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['courier_tracking_id']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Dispatch Date:</b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['dispatch_date']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Action:</b>&nbsp;
                                            <a class="badge badge-primary mr-2" data-toggle="tooltip" data-placement="top"
                                                title="" data-original-title="add"
                                                href="select-outward-products.php?outward_id=<?php echo base64_encode($row['outward_id']); ?>"><i
                                                    class="ri-add-fill mr-0"></i></a>
                                            <a class="badge badge-secondary mr-2" data-toggle="tooltip" data-placement="top"
                                                title="" data-original-title="View"
                                                href="view-outward.php?id=<?php echo base64_encode($row['outward_id']); ?>"><i
                                                    class="ri-eye-fill mr-0"></i></a>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?php echo $row['outward_id']; ?>">
                                                <button type="submit" class="badge badge-danger mr-2" data-toggle="tooltip"
                                                    style="border: none; background: none;" name="delete"
                                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                                    data-placement="top" title="" data-original-title="delete"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Page end  -->
    </div>
</div>
</div>
<?php
include 'footer.php';
?>