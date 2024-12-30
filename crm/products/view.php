<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $products_id = mysqli_real_escape_string($conn, $_POST['id']);

    // Fetch product details using a prepared statement
    $sql = "SELECT * FROM Products WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $products_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Output details in a form
        ?>
        <form method="POST" action="update_product.php"> <!-- action to handle form submission -->
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Code *</label>
                        <input type="text" class="form-control" name="products_code"
                            value="<?php echo htmlspecialchars($row['product_id']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Product Type *</label>
                        <?php
                        $sql = "SELECT * FROM ProductType WHERE product_type_id = '{$row['product_type']}'";
                        $result = mysqli_query($conn, $sql);
                        $product_type = mysqli_fetch_assoc($result);
                        ?>
                        <input type="text" class="form-control" name="products_type"
                            value="<?php echo htmlspecialchars($product_type['product_type_name']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Product Name *</label>
                        <input type="text" class="form-control" name="products_name"
                            value="<?php echo htmlspecialchars($row['product_name']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Brand *</label>
                        <?php
                        $sql = "SELECT * FROM Brands WHERE brands_id = '{$row['brand']}'";
                        $result = mysqli_query($conn, $sql);
                        $brand = mysqli_fetch_assoc($result);
                        ?>
                        <input type="text" class="form-control" name="brand"
                            value="<?php echo htmlspecialchars($brand['brands_name']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Skin Type *</label>
                        <?php
                        // Assume $row['skin_type'] contains a comma-separated list of IDs, e.g., "1,2,3"
                        $skin_type_ids = explode(',', $row['skin_type']); // Split by comma
                        $skin_type_ids = array_map('trim', $skin_type_ids); // Trim spaces
                        $skin_type_ids_string = implode("','", $skin_type_ids); // Prepare for SQL IN clause
                
                        $sql = "SELECT skin_type_name FROM SkinTypes WHERE skin_type_id IN ('$skin_type_ids_string')";
                        $result = mysqli_query($conn, $sql);

                        // Collect skin type names
                        $skin_types_text = '';
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($skin_row = mysqli_fetch_assoc($result)) {
                                $skin_types_text .= htmlspecialchars($skin_row['skin_type_name']) . "\n";
                            }
                        } else {
                            $skin_types_text = 'No skin types found.';
                        }
                        ?>
                        <textarea class="form-control" name="skin_type" rows="3"
                            readonly><?php echo trim($skin_types_text); ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Skin Concern *</label>
                        <?php
                        // Assume $row['skin_concern'] contains a comma-separated list of IDs, e.g., "4,5,6"
                        $skin_concern_ids = explode(',', $row['skin_concern']); // Split by comma
                        $skin_concern_ids = array_map('trim', $skin_concern_ids); // Trim spaces
                        $skin_concern_ids_string = implode("','", $skin_concern_ids); // Prepare for SQL IN clause
                
                        $sql = "SELECT concern_name FROM SkinConcerns WHERE skin_concern_id IN ('$skin_concern_ids_string')";
                        $result = mysqli_query($conn, $sql);

                        // Collect skin concern names
                        $skin_concern_text = '';
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($skin_row = mysqli_fetch_assoc($result)) {
                                $skin_concern_text .= htmlspecialchars($skin_row['concern_name']) . "\n";
                            }
                        } else {
                            $skin_concern_text = 'No concerns found.';
                        }
                        ?>
                        <textarea class="form-control" name="skin_concern" rows="3"
                            readonly><?php echo trim($skin_concern_text); ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Key Ingredients *</label>
                        <textarea class="form-control" name="key_ingredients" rows="3"
                            readonly><?php echo htmlspecialchars($row['key_ingredients']); ?></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Ideal For *</label>
                        <input type="text" class="form-control" name="ideal_for"
                            value="<?php echo htmlspecialchars($row['ideal_for']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Formulation *</label>
                        <?php
                        $sql = "SELECT * FROM Formulation WHERE formulation_id = '{$row['formulation_texture']}'";
                        $result = mysqli_query($conn, $sql);
                        $formulation = mysqli_fetch_assoc($result);
                        ?>
                        <input type="text" class="form-control" name="formulation"
                            value="<?php echo htmlspecialchars($formulation['formulation_name']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Size *</label>
                        <input type="text" class="form-control" name="products_size"
                            value="<?php echo htmlspecialchars($row['size']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Shelf Life *</label>
                        <input type="text" class="form-control" name="products_shelf_life"
                            value="<?php echo htmlspecialchars($row['shelf_life']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Price *</label>
                        <input type="text" class="form-control" name="products_price"
                            value="<?php echo htmlspecialchars($row['price']) . " " . htmlspecialchars($row['currency']); ?>"
                            readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Regimen Step *</label>
                        <input type="text" class="form-control" name="products_regimen_step"
                            value="<?php echo htmlspecialchars($row['regimen_recommendation']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status *</label>
                        <input type="text" class="form-control" name="products_state"
                            value="<?php echo htmlspecialchars($row['product_status']); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Product Web Status *</label>
                        <input type="text" class="form-control" name="products_pincode"
                            value="<?php echo htmlspecialchars($row['product_web_status']); ?>" readonly>
                    </div>
                </div>
            </div>
        </form>
        <?php
    } else {
        echo '<p>No details found for the selected product.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}
?>