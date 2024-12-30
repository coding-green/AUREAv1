<?php
include 'header.php';


?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <!-- Home Reels -->
            <div class="col-lg-5">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Home Reels</h4>
                    </div>
                    <!-- Add Home Reel Button -->
                    <a href="#" class="btn btn-primary add-list" data-toggle="modal" data-target="#addHomeReel">
                        <i class="las la-plus mr-3"></i>Add Home Reel
                    </a>


                </div>
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th style="width: 10px;">#</th>
                                <th>Brand</th>
                                <th>URL</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM reels where reel_type = 'home'";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="badge badge-danger mr-2"
                                                style="border: none; background: none;"
                                                onclick="deleteReel('<?php echo $row['reel_id']; ?>', this)">
                                                <i class="fa fa-trash"></i>
                                            </button>


                                            <!-- Trigger Button -->
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $row['reel_brand']; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo $row['reel_url']; ?>" target="_blank">
                                            Click View
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Product -->
            <div class="col-lg-7">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Product Reels</h4>
                    </div>
                    <a href="#" class="btn btn-primary add-list" data-toggle="modal" data-target="#addproductReel"><i
                            class="las la-plus mr-3"></i>Add Product Reel</a>
                    </a>
                </div>
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>No of Reels</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM reels where reel_type = 'product'";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="view-product" data-id="<?php echo $row['reel_id']; ?>"
                                                data-toggle="modal" data-target="#productDetailsModal">
                                                <?php
                                                $sql1 = "SELECT * FROM Products where product_id = '" . $row['product_id'] . "'";
                                                $result1 = mysqli_query($conn, $sql1);
                                                $row1 = mysqli_fetch_assoc($result1);
                                                echo $row1['product_name'];
                                                ?>
                                            </a>
                                            <!-- Trigger Button -->
                                        </div>
                                    </td>

                                    <td>
                                        <?php echo $row['reel_brand']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['reel_url']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['reel_status'] == 'Active') {
                                            echo '<span class="badge badge-success">Active</span>';
                                        } else if ($row['status'] == 'Inactive') {
                                            echo '<span class="badge badge-danger">Inactive</span>';
                                        }
                                        ?>
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




<!-- Add Home Reel Modal -->
<div class="modal fade" id="addHomeReel" tabindex="-1" aria-labelledby="addHomeReelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHomeReelLabel">Add Home Reel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addReelForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reelBrand">Brand *</label>
                        <input type="text" class="form-control" id="reelBrand" name="reel_brand"
                            placeholder="Enter Reel Brand" required>
                    </div>
                    <div class="form-group">
                        <label for="reelURL">Reel URL *</label>
                        <input type="url" class="form-control" id="reelURL" name="reel_url" placeholder="Enter Reel URL"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Reel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Add Home Reel
    document.getElementById('addReelForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('reels/add_reel.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload(); // Reload the page to update table
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred.');
            });
    });
    //delete
    function deleteReel(reelId, button) {
        if (confirm("Are you sure you want to delete this reel?")) {
            $.ajax({
                url: 'reels/delete_reel.php',
                type: 'POST',
                data: { id: reelId },
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.status === 'success') {
                        alert(result.message);
                        // Remove the row from the table dynamically
                        $(button).closest('tr').remove();
                    } else {
                        alert('Failed to delete the reel: ' + result.message);
                    }
                },
                error: function () {
                    alert('An error occurred while trying to delete the reel.');
                }
            });
        }
    }



</script>

<?php
include 'footer.php';
?>