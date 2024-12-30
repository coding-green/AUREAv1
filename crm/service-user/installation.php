<?php
include 'header.php';




?>

<div class="content-page">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Installations List</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th  style="width: 10%;">Installation Details</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM product_installation where user_id = '$user_id'";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <b>Installation Code: </b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['installation_id']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Customer Name: </b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['product_to_name']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Opreator Name: </b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['contact_person_name']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Installation Method: </b>&nbsp;
                                            <div>
                                                <span
                                                    style="color:green;"><?php echo $row['method_of_installation']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Shecdule Date: </b>&nbsp;
                                            <div>
                                                <span
                                                    style="color:green;"><?php echo $row['plan_to_install_date']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Status: </b>&nbsp;
                                            <div>
                                                <span style="color:green;"><?php echo $row['installation_status']; ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <b>Action: </b>&nbsp;&nbsp;&nbsp;
                                            <div>
                                                <?php
                                                if ($row['installation_status'] == "Opreator Assign") {
                                                    ?>
                                                    <a class="badge badge-secondary mr-2" data-toggle="tooltip"
                                                        data-placement="top" title="" data-original-title="edit"
                                                        href="edit-installation.php?installation_id=<?php echo base64_encode($row['installation_id']); ?>"><i
                                                            class="fa fa-pencil-alt"></i></a>
                                                    <?php
                                                }else if ($row['installation_status'] == "Installation Shedule") {
                                                    ?>
                                                    <a class="badge badge-primary mr-2" data-toggle="tooltip"
                                                        data-placement="top" title="" data-original-title="edit"
                                                        href="submit-installation.php?installation_id=<?php echo base64_encode($row['installation_id']); ?>"><i
                                                            class="fa fa-pencil-alt"></i></a>
                                                    <?php
                                                }else if ($row['installation_status'] == "Installation Reports Pending") {
                                                    ?>
                                                    <a class="badge badge-warning mr-2" data-toggle="tooltip"
                                                        data-placement="top" title="" data-original-title="edit"
                                                        href="reports-installation.php?installation_id=<?php echo base64_encode($row['installation_id']); ?>"><i
                                                            class="fa fa-pencil-alt"></i></a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
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