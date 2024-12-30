<?php
include 'header.php';
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Delivered Products List</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>Outward Code</th>
                                <th>Invoice/Challan</th>
                                <th>Customer Name</th>
                                <th>Contact Person</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM inventory_product_outward WHERE status = 'Delivered'";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['outward_id']; ?></td>
                                    <td><?php echo $row['invoice/challan']; ?></td>
                                    <td><?php echo $row['product_to_name']; ?></td>
                                    <td><?php echo $row['contact_person_name']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <a class="badge badge-secondary mr-2" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="view"
                                            href="view_delivered_products.php?id=<?php echo base64_encode($row['outward_id']); ?>"><i
                                                class="ri-eye-line mr-0"></i></a>
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