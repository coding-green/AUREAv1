<?php
include 'header.php';
// Fetch data for each table
$collections = mysqli_query($conn, "SELECT aurea_collection_id, aurea_collection_name FROM AureaCollection");
$brands = mysqli_query($conn, "SELECT brands_id, brands_name FROM Brands order by brands_name");
$formulations = mysqli_query($conn, "SELECT formulation_id, formulation_name FROM Formulation order by formulation_name");
$productTypes = mysqli_query($conn, "SELECT product_type_id, product_type_name FROM ProductType order by product_type_name");
$skinConcerns = mysqli_query($conn, "SELECT skin_concern_id, concern_name FROM SkinConcerns order by concern_name");
$skinTypes = mysqli_query($conn, "SELECT skin_type_id, skin_type_name FROM SkinTypes order by skin_type_name");

$product_id = base64_decode($_GET['productid']);
$product = mysqli_query($conn, "SELECT * FROM Products WHERE product_id = '$product_id'");
$row_product = mysqli_fetch_assoc($product);
?>

<div class="content-page">
    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Update Details</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="updateProductForm" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" name="product_name"
                                            value="<?php echo $row_product['product_name']; ?>"
                                            placeholder="Enter Product Name">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Product Type *</label>
                                        <select class="form-control" name="product_type_id" required>
                                            <?php
                                            // Display the currently selected product type
                                            if ($productTypes && mysqli_num_rows($productTypes) > 0) {
                                                while ($row = mysqli_fetch_assoc($productTypes)) {
                                                    $isSelected = ($row['product_type_id'] == $row_product['product_type']) ? 'selected' : '';
                                                    echo '<option value="' . htmlspecialchars($row['product_type_id']) . '" ' . $isSelected . '>' . htmlspecialchars($row['product_type_name']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No product types available</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Brand *</label>
                                        <select class="form-control" name="brand_id" required>
                                            <?php
                                            
                                            // Display the currently selected brand
                                            if ($brands && mysqli_num_rows($brands) > 0) {
                                                while ($row = mysqli_fetch_assoc($brands)) {
                                                    $isSelected = ($row['brands_id'] == $row_product['brand']) ? 'selected' : '';
                                                    echo '<option value="' . htmlspecialchars($row['brands_id']) . '" ' . $isSelected . '>' . htmlspecialchars($row['brands_name']) . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No brands available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Formulation *</label>
                                        <select class="form-control" name="formulation_id" required>
                                            <option value="">Select Formulation</option>
                                            <?php
                                            // Assuming $row_product contains the current product data
                                            $selectedFormulationId = $row_product['formulation_texture']; // Get the current formulation ID
                                            
                                            // Loop through available formulations
                                            if ($formulations && mysqli_num_rows($formulations) > 0) {
                                                while ($row = mysqli_fetch_assoc($formulations)) {
                                                    // Check if the formulation is the selected one
                                                    $isSelected = ($row['formulation_id'] == $selectedFormulationId) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?php echo htmlspecialchars($row['formulation_id']); ?>"
                                                        <?php echo $isSelected; ?>>
                                                        <?php echo htmlspecialchars($row['formulation_name']); ?>
                                                    </option>
                                                    <?php
                                                }
                                            } else {
                                                echo '<option value="">No formulations available</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Regimen Step</label>
                                        <select class="form-control" name="regimen_step">
                                            <option value="">Select Regimen Step</option>
                                            <option value="AM" <?php echo ($row_product['regimen_recommendation'] == 'AM') ? 'selected' : ''; ?>>AM</option>
                                            <option value="PM" <?php echo ($row_product['regimen_recommendation'] == 'PM') ? 'selected' : ''; ?>>PM</option>
                                            <option value="AM/PM" <?php echo ($row_product['regimen_recommendation'] == 'AM/PM') ? 'selected' : ''; ?>>
                                                AM & PM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Skin Type *</label>
                                        <?php
                                        // Assuming $selectedSkinTypes contains an array of IDs for the selected skin types
                                        $selectedSkinTypes = explode(',', $row_product['skin_type']); // Example: "1,2,3" -> [1, 2, 3]
                                        
                                        // Loop through available skin types
                                        if ($skinTypes && mysqli_num_rows($skinTypes) > 0) {
                                            while ($row = mysqli_fetch_assoc($skinTypes)) {
                                                // Check if the current skin type is selected
                                                $isChecked = in_array($row['skin_type_id'], $selectedSkinTypes) ? 'checked' : '';
                                                ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="skin_type_id[]"
                                                        value="<?php echo htmlspecialchars($row['skin_type_id']); ?>" <?php echo $isChecked; ?>>
                                                    <label class="form-check-label">
                                                        <?php echo htmlspecialchars($row['skin_type_name']); ?>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo '<p>No skin types available.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Skin Concern *</label>
                                        <div class="row">
                                            <?php
                                            // Assuming $selectedSkinConcerns contains an array of IDs for the selected skin concerns
                                            $selectedSkinConcerns = explode(',', $row_product['skin_concern']); // Example: "4,5,6" -> [4, 5, 6]
                                            
                                            // Loop through available skin concerns
                                            if ($skinConcerns && mysqli_num_rows($skinConcerns) > 0) {
                                                $count = 0; // Counter to track items
                                                while ($row = mysqli_fetch_assoc($skinConcerns)) {
                                                    // Check if the current skin concern is selected
                                                    $isChecked = in_array($row['skin_concern_id'], $selectedSkinConcerns) ? 'checked' : '';

                                                    // Start a new column for every 3 items
                                                    if ($count % 3 === 0) {
                                                        echo '<div class="col-md-4">'; // Open a new column
                                                    }
                                                    ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="skin_concern_id[]"
                                                            value="<?php echo htmlspecialchars($row['skin_concern_id']); ?>"
                                                            <?php echo $isChecked; ?>>
                                                        <label class="form-check-label">
                                                            <?php echo htmlspecialchars($row['concern_name']); ?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                    $count++;

                                                    // Close the column after 3 items
                                                    if ($count % 3 === 0) {
                                                        echo '</div>'; // Close the column
                                                    }
                                                }

                                                // Close any unclosed column
                                                if ($count % 3 !== 0) {
                                                    echo '</div>';
                                                }
                                            } else {
                                                echo '<p>No skin concerns available.</p>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Size *</label>
                                        <div class="d-flex">
                                            <?php
                                            // Assuming $row_product['product_size'] is in the format like "1 gram"
                                            $product_size = $row_product['size'];
                                            $size_value = ''; // Default empty value
                                            $size_unit = ''; // Default empty unit
                                            
                                            // Split the size string into number and unit
                                            $size_parts = explode(' ', $product_size);
                                            if (count($size_parts) == 2) {
                                                $size_value = $size_parts[0]; // Numeric part
                                                $size_unit = $size_parts[1];  // Unit part
                                            }
                                            ?>
                                            <input type="number" class="form-control" name="product_size_no"
                                                placeholder="Enter Product Size" min="1"
                                                value="<?php echo isset($size_value) ? htmlspecialchars($size_value) : ''; ?>">
                                            <select class="form-control ml-2" name="product_size_unit">
                                                <option value="Gram" <?php echo ($size_unit == 'Gram') ? 'selected' : ''; ?>>Gram</option>
                                                <option value="ML" <?php echo ($size_unit == 'ML') ? 'selected' : ''; ?>>
                                                    ML</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Price *</label>
                                        <div class="d-flex">
                                            <?php
                                            // Assuming the price and currency are fetched from the database like this:
                                            $product_price = $row_product['price'];  // The price value (e.g., 100)
                                            $currency = $row_product['currency'];   // The currency (e.g., 'INR')
                                            
                                            // Set default values if not set
                                            $price_value = isset($product_price) ? $product_price : '';
                                            $currency_value = isset($currency) ? $currency : 'INR'; // Default to INR if no currency is set
                                            ?>
                                            <input type="text" class="form-control" name="product_price_no"
                                                placeholder="Enter Product Price" min="1"
                                                value="<?php echo htmlspecialchars($price_value); ?>">

                                            <select class="form-control ml-2" name="product_price_unit">
                                                <option value="INR" <?php echo ($currency_value == 'INR') ? 'selected' : ''; ?>>INR</option>
                                                <option value="USD" <?php echo ($currency_value == 'USD') ? 'selected' : ''; ?>>USD</option>
                                                <option value="AUD" <?php echo ($currency_value == 'AUD') ? 'selected' : ''; ?>>AUD</option>
                                                <option value="EUR" <?php echo ($currency_value == 'EUR') ? 'selected' : ''; ?>>EUR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Shelf Life *</label>
                                        <div class="d-flex">
                                            <?php
                                            // Assuming $row_product['shelf_life'] is in the format like "12 month"
                                            $shelf_life = $row_product['shelf_life'];
                                            $shelf_value = ''; // Default empty value
                                            $shelf_unit = ''; // Default empty unit
                                            
                                            // Split the shelf life string into number and unit
                                            $shelf_parts = explode(' ', $shelf_life);
                                            if (count($shelf_parts) == 2) {
                                                $shelf_value = $shelf_parts[0]; // Numeric part
                                                $shelf_unit = $shelf_parts[1];  // Unit part
                                            }
                                            ?>
                                            <input type="number" class="form-control" name="shelf_no"
                                                placeholder="Enter Shelf Life" min="1"
                                                value="<?php echo isset($shelf_value) ? htmlspecialchars($shelf_value) : ''; ?>">
                                            <select class="form-control ml-2" name="shelf_life_unit">
                                                <option value="month" <?php echo ($shelf_unit == 'month') ? 'selected' : ''; ?>>Months</option>
                                                <option value="year" <?php echo ($shelf_unit == 'year') ? 'selected' : ''; ?>>Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Period After Opening *</label>
                                        <div class="d-flex">
                                            <?php
                                            // Assuming $row_product['period_after_opening'] is in the format like "12 month"
                                            $period_after_opening = $row_product['period_after_opening'];
                                            $period_value = ''; // Default empty value
                                            $period_unit = ''; // Default empty unit
                                            
                                            // Split the period_after_opening string into number and unit
                                            $period_parts = explode(' ', $period_after_opening);
                                            if (count($period_parts) == 2) {
                                                $period_value = $period_parts[0]; // Numeric part
                                                $period_unit = $period_parts[1];  // Unit part
                                            }
                                            ?>
                                            <input type="number" class="form-control" name="period_after_opening_no"
                                                placeholder="Enter Period After Opening" min="1"
                                                value="<?php echo isset($period_value) ? htmlspecialchars($period_value) : ''; ?>">
                                            <select class="form-control ml-2" name="period_after_opening_unit">
                                                <option value="month" <?php echo ($period_unit == 'month') ? 'selected' : ''; ?>>Months</option>
                                                <option value="year" <?php echo ($period_unit == 'year') ? 'selected' : ''; ?>>Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Product Tagline</label>
                                        <input type="text" class="form-control" name="product_tagline"
                                            value="<?php echo $row_product['product_tagline']; ?>"
                                            placeholder="Enter Product Tagline">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Key Ingredients</label>
                                        <textarea class="form-control" name="key_ingredients"
                                            placeholder="Enter Key Ingredients"><?php echo $row_product['key_ingredients']; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>How to Use</label>
                                        <textarea class="form-control" name="how_to_use"
                                            placeholder="Enter How to Use"><?php echo $row_product['how_to_use']; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Benefits</label>
                                        <textarea class="form-control" name="benefits"
                                            placeholder="Enter Benefits"><?php echo $row_product['product_benefits']; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Product Description</label>
                                        <textarea class="form-control" name="product_description"
                                            placeholder="Enter Product Description"><?php echo $row_product['description']; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>All Ingredients</label>
                                        <textarea class="form-control" name="all_ingredients"
                                            placeholder="Enter All Ingredients"><?php echo $row_product['all_ingredients']; ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Warning Statement</label>
                                        <textarea class="form-control" name="warning_statement"
                                            placeholder="Enter Warning Statement"><?php echo $row_product['warning_statement']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Status *</label>
                                        <select class="form-control" name="product_status" required>
                                            <option value="">Select Product Status</option>
                                            <option value="Active" <?php echo ($row_product['product_status'] == 'Active') ? 'selected' : ''; ?>>In Stock</option>
                                            <option value="Inactive" <?php echo ($row_product['product_status'] == 'Inactive') ? 'selected' : ''; ?>>Out
                                                of Stock</option>
                                            <option value="Discontinued" <?php echo ($row_product['product_status'] == 'Discontinued') ? 'selected' : ''; ?>>
                                                Discontinued</option>
                                            <option value="Coming Soon" <?php echo ($row_product['product_status'] == 'Coming Soon') ? 'selected' : ''; ?>>
                                                Coming Soon</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Web Status *</label>
                                        <select class="form-control" name="web_status" required>
                                            <option value="">Select Web Status</option>
                                            <option value="Active" <?php echo ($row_product['product_web_status'] == 'Active') ? 'selected' : ''; ?>>On
                                                Website</option>
                                            <option value="Inactive" <?php echo ($row_product['product_web_status'] == 'Inactive') ? 'selected' : ''; ?>>
                                                Not on Website</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ideal For *</label>
                                        <select class="form-control" name="ideal_for" required>
                                            <option value="">Select Ideal For</option>
                                            <option value="Male" <?php echo ($row_product['ideal_for'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo ($row_product['ideal_for'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                            <option value="Male & Female" <?php echo ($row_product['ideal_for'] == 'Male & Female') ? 'selected' : ''; ?>>Male & Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Aurea Collection</label>
                                        <select class="form-control" name="aurea_collection_id">
                                            <option value="">Select Collection</option>
                                            <?php while ($row = mysqli_fetch_assoc($collections)) { ?>
                                                <option value="<?php echo $row['aurea_collection_id']; ?>" <?php echo ($row['aurea_collection_id'] == $row_product['featured_status']) ? 'selected' : ''; ?>>
                                                    <?php echo $row['aurea_collection_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-danger mr-2">Reset</button>
                            <button type="button" onclick="window.location.href='products.php'"
                                class="btn btn-secondary">Cancel</button>
                        </form>
                        <div id="responseMessage" style="display: none;" class="alert"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Listen for form submission
        $("#updateProductForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this); // Use FormData to handle file uploads

            // Add product_id to form data
            formData.append("product_id", "<?php echo base64_encode($product_id); ?>");

            // Make AJAX request
            $.ajax({
                type: "POST",
                url: "products/update.php", // Point to the update script
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Let the browser handle the content type
                success: function (response) {
                    var data = JSON.parse(response); // Parse the JSON response

                    if (data.status == 'success') {
                        // Show success message
                        $("#responseMessage").show().removeClass().addClass('alert alert-success').text(data.message);

                        // Optionally redirect after a short delay
                        setTimeout(function () {
                            window.location.href = "products.php";
                        }, 2000);
                    } else {
                        // Show error message
                        $("#responseMessage").show().removeClass().addClass('alert alert-danger').text(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Display error message
                    $("#responseMessage").show().removeClass().addClass('alert alert-danger').text("There was an error: " + error);
                }
            });
        });
    });
</script>

<?php
include 'footer.php';
?>