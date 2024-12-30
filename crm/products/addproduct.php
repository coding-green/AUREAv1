<?php
// Fetch data for each table
$brands = mysqli_query($conn, "SELECT brands_id, brands_name FROM Brands ORDER BY brands_name");
$formulations = mysqli_query($conn, "SELECT formulation_id, formulation_name FROM Formulation ORDER BY formulation_name");
$productTypes = mysqli_query($conn, "SELECT product_type_id, product_type_name FROM ProductType ORDER BY product_type_name");
$skinConcerns = mysqli_query($conn, "SELECT skin_concern_id, concern_name FROM SkinConcerns ORDER BY concern_name");
$skinTypes = mysqli_query($conn, "SELECT skin_type_id, skin_type_name FROM SkinTypes ORDER BY skin_type_name");
?>
<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Type *</label>
                                <select class="form-control" name="product_type_id" required>
                                    <option value="">Select Product Type</option>
                                    <?php while ($row = mysqli_fetch_assoc($productTypes)) { ?>
                                        <option value="<?php echo $row['product_type_id']; ?>">
                                            <?php echo $row['product_type_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Name *</label>
                                <input type="text" class="form-control" name="product_name"
                                    placeholder="Enter Product Name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Brand *</label>
                                <select class="form-control" name="brand_id" required>
                                    <option value="">Select Brand</option>
                                    <?php while ($row = mysqli_fetch_assoc($brands)) { ?>
                                        <option value="<?php echo $row['brands_id']; ?>">
                                            <?php echo $row['brands_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Product Tagline</label>
                                <input type="text" class="form-control" name="product_tagline"
                                    placeholder="Enter Product Tagline">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Skin Type *</label>
                                <?php while ($row = mysqli_fetch_assoc($skinTypes)) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skin_type_id[]"
                                            value="<?php echo $row['skin_type_id']; ?>">
                                        <label class="form-check-label">
                                            <?php echo $row['skin_type_name']; ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Skin Concern *</label>
                                <div class="row">
                                    <?php
                                    $concerns = [];
                                    while ($row = mysqli_fetch_assoc($skinConcerns)) {
                                        $concerns[] = $row;
                                    }
                                    $half = ceil(count($concerns) / 2);
                                    ?>
                                    <div class="col-md-6">
                                        <?php for ($i = 0; $i < $half; $i++) { ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="skin_concern_id[]"
                                                    value="<?php echo $concerns[$i]['skin_concern_id']; ?>">
                                                <label class="form-check-label">
                                                    <?php echo $concerns[$i]['concern_name']; ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php for ($i = $half; $i < count($concerns); $i++) { ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="skin_concern_id[]"
                                                    value="<?php echo $concerns[$i]['skin_concern_id']; ?>">
                                                <label class="form-check-label">
                                                    <?php echo $concerns[$i]['concern_name']; ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Formulation *</label>
                                <select class="form-control" name="formulation_id" required>
                                    <option value="">Select Formulation</option>
                                    <?php while ($row = mysqli_fetch_assoc($formulations)) { ?>
                                        <option value="<?php echo $row['formulation_id']; ?>">
                                            <?php echo $row['formulation_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Ideal For *</label>
                                <select class="form-control" name="ideal_for" required>
                                    <option value="">Select Ideal For</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Male & Female">Male & Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Regimen Step </label>
                                <select class="form-control" name="regimen_step">
                                    <option value="">Select Regimen Step</option>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                    <option value="AM/PM">AM & PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Shelf Life *</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control" name="shelf_no"
                                        placeholder="Enter Shelf Life" min="1">
                                    <select class="form-control ml-2" name="shelf_life_unit">
                                        <option value="month">Months</option>
                                        <option value="year">Years</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Period After Opening *</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control" name="period_after_opening_no"
                                        placeholder="Enter Period After Opening" min="1">
                                    <select class="form-control ml-2" name="period_after_opening_unit">
                                        <option value="month">Months</option>
                                        <option value="year">Years</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Size *</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control" name="product_size_no"
                                        placeholder="Enter Product Size" min="1">
                                    <select class="form-control ml-2" name="product_size_unit">
                                        <option value="Gram">Gram</option>
                                        <option value="ML">ML</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Price *</label>
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
                                <label>Product Status *</label>
                                <select class="form-control" name="product_status" required>
                                    <option value="">Select Product Status</option>
                                    <option value="Active">In Stock</option>
                                    <option value="Inactive">Out of Stock</option>
                                    <option value="Discontinued">Discontinued</option>
                                    <option value="Coming Soon">Coming Soon</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Web Status *</label>
                                <select class="form-control" name="web_status" required>
                                    <option value="">Select Web Status</option>
                                    <option value="Active">On Website</option>
                                    <option value="Inactive">Not on Website</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
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
        $("#addProductForm").submit(function (e) {
            e.preventDefault(); // Prevent form submission

            var formData = {
                product_type_id: $("select[name='product_type_id']").val(),
                product_name: $("input[name='product_name']").val(),
                brand_id: $("select[name='brand_id']").val(),
                product_tagline: $("input[name='product_tagline']").val(),
                formulation_id: $("select[name='formulation_id']").val(),
                skin_type_id: $("input[name='skin_type_id[]']:checked").map(function () { return $(this).val(); }).get(),
                skin_concern_id: $("input[name='skin_concern_id[]']:checked").map(function () { return $(this).val(); }).get(),
                product_size: $("input[name='product_size_no']").val() + " " + $("select[name='product_size_unit']").val(),
                product_price: $("input[name='product_price_no']").val(),
                price_unit: $("select[name='product_price_unit']").val(),
                ideal_for: $("select[name='ideal_for']").val(),
                product_status: $("select[name='product_status']").val(),
                web_status: $("select[name='web_status']").val(),
                shelf_no: $("input[name='shelf_no']").val(),
                shelf_life_unit: $("select[name='shelf_life_unit']").val(),
                period_after_opening_no: $("input[name='period_after_opening_no']").val(),
                period_after_opening_unit: $("select[name='period_after_opening_unit']").val(),
                regimen_step: $("select[name='regimen_step']").val(),


            };

            $.ajax({
                type: "POST",
                url: "products/insert.php", // URL for handling the insert
                data: formData, // Data to be sent to the server
                success: function (response) {
                    var jsonResponse = JSON.parse(response); // Parse the JSON response

                    if (jsonResponse.status === 'success') {
                        // Hide the current modal and show the next modal
                        $('#addProductModal').modal('hide');
                        alert('Product added successfully');
                        location.reload();
                    } else {
                        // Show error message if insert fails
                        alert('Error: ' + jsonResponse.message);
                    }
                },
            });
        });
    });
</script>