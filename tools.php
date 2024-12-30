<?php
include 'header.php';
?>



<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <!-- Orders List -->
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Beauty Tools</h4>
                    </div>
                    <a href="#" class="btn btn-primary add-list" data-toggle="modal" data-target="#addProductModal">
                        <i class="las la-plus mr-3"></i>Add Beauty Tools
                    </a>
                </div>
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>#</th>
                                <th>Tool Id</th>
                                <th>Tool Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM beauty_tools";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="badge badge-danger mr-2"
                                                style="border: none; background: none;" data-toggle="modal"
                                                data-target="#deleteModal"
                                                onclick="setDeleteOrderId('<?php echo $row['order_id']; ?>')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td><a href="javascript:void(0);" data-toggle="modal" data-target="#viewModal"
                                            onclick="viewOrderDetails('<?php echo $row['order_id']; ?>')">
                                            <?php echo $row['tool_id']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row['tool_name']; ?>

                                    </td>
                                    <td><?php echo $row['brand']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['stock']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Beauty Tool</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tool Name *</label>
                                <input type="text" class="form-control" name="tool_name" placeholder="Enter Tool Name"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Category *</label>
                                <input type="text" class="form-control" name="category" value="Beauty Tools" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Brand *</label>
                                <input type="text" class="form-control" name="brand" placeholder="Enter Brand" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tool Price *</label>
                                <div class="d-flex">
                                    <input type="text" class="form-control" name="product_price_no"
                                        placeholder="Enter Product Price" min="1">
                                    <select class="form-control ml-2" name="product_price_unit">
                                        <option value="INR">INR</option>
                                        <option value="USD">USD</option>
                                        <option value="AUD">AUD</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stock *</label>
                                <input type="number" class="form-control" name="stock" placeholder="Enter Stock"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tool Status *</label>
                                <select class="form-control" name="tool_status" required>
                                    <option value="">Select Tool Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Key Benefits </label>
                                <textarea class="form-control" name="key_benefits" placeholder="Enter Key Benefits"
                                    rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>What to use it with </label>
                                <textarea class="form-control" name="what_to_use_with"
                                    placeholder="Enter What to use it with" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>How to Use </label>
                                <textarea class="form-control" name="how_to_use" placeholder="Enter How to Use"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Product Description </label>
                                <textarea class="form-control" name="product_description"
                                    placeholder="Enter Description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Product Details</label>
                                <textarea class="form-control" name="product_details"placeholder="Enter Product Details"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding-bottom: 0px;">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger">Reset</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#addProductForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'add_beauty_tool.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Beauty Tool added successfully');
                        location.reload();
                    } else {
                        alert('Error adding Beauty Tool');
                    }
                }
            });
        });
    });
</script>
<?php
include 'footer.php';
?>