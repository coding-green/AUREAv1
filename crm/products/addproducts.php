<?php

// Fetch data for Step 1
$brands = mysqli_query($conn, "SELECT brands_id, brands_name FROM Brands ORDER BY brands_name");
$formulations = mysqli_query($conn, "SELECT formulation_id, formulation_name FROM Formulation ORDER BY formulation_name");
$productTypes = mysqli_query($conn, "SELECT product_type_id, product_type_name FROM ProductType ORDER BY product_type_name");

// Fetch data for Step 2
$collections = mysqli_query($conn, "SELECT aurea_collection_id, aurea_collection_name FROM AureaCollection ORDER BY aurea_collection_name");
?>



<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Step 1 Form -->
                <form id="step1Form" method="post">
                    <div class="form-group">
                        <label>Product Type</label>
                        <select class="form-control" name="product_type_id" required>
                            <option value="">Select Product Type</option>
                            <?php while ($row = mysqli_fetch_assoc($productTypes)) { ?>
                                <option value="<?php echo $row['product_type_id']; ?>">
                                    <?php echo $row['product_type_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" name="product_name" placeholder="Enter Product Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="nextStep">Next</button>
                    </div>
                </form>

                <!-- Step 2 Form (hidden initially) -->
                <form id="step2Form" method="post" enctype="multipart/form-data" style="display: none;">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" id="step2ProductName" name="product_name" readonly>
                    </div>
                    <div class="form-group">
                        <label>Aurea Collection</label>
                        <select class="form-control" name="aurea_collection_id">
                            <option value="">Select Collection</option>
                            <?php while ($row = mysqli_fetch_assoc($collections)) { ?>
                                <option value="<?php echo $row['aurea_collection_id']; ?>">
                                    <?php echo $row['aurea_collection_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Shelf Life</label>
                        <div class="d-flex">
                            <input type="number" class="form-control" name="shelf_no" placeholder="Enter Shelf Life" min="1">
                            <select class="form-control ml-2" name="shelf_life_unit">
                                <option value="month">Months</option>
                                <option value="year">Years</option>
                            </select>
                        </div>
                    </div>
                    <!-- Additional Step 2 fields -->
                    <div class="form-group">
                        <label>Key Ingredients</label>
                        <textarea class="form-control" name="key_ingredients" placeholder="Enter Key Ingredients"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Product Benefits</label>
                        <textarea class="form-control" name="benefits" placeholder="Enter Product Benefits"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Handle the Next button click
        $("#nextStep").on("click", function () {
            // Get product name from Step 1
            const productName = $("input[name='product_name']").val();

            // Validate required fields in Step 1
            if (!productName || $("select[name='product_type_id']").val() === "") {
                alert("Please complete all required fields in Step 1.");
                return;
            }

            // Populate Step 2 fields
            $("#step2ProductName").val(productName);

            // Switch from Step 1 to Step 2
            $("#step1Form").hide();
            $("#step2Form").show();
            $(".modal-title").text("Add More Details");
        });

        // Handle Step 2 form submission
        $("#step2Form").on("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "products/update.php", // Update PHP script
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.status === "success") {
                        alert("Product added successfully!");
                        window.location.href = "products.php"; // Redirect to product listing
                    } else {
                        alert("Error: " + data.message);
                    }
                },
                error: function () {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>
