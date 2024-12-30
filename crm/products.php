<?php
include 'header.php';


?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Product List</h4>
                    </div>
                    <a href="#" class="btn btn-primary add-list" data-toggle="modal" data-target="#addProductModal">
                        <i class="las la-plus mr-3"></i>Add Product
                    </a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Brand</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM Products";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="updateproduct.php?productid=<?php echo base64_encode($row['product_id']); ?>"
                                                class="badge badge-success mr-2" data-id="<?php echo $row['product_id']; ?>"
                                                style="color:green;">
                                                <i class="ri-pencil-line mr-0"></i>
                                            </a>
                                            <a href="copyproduct.php?productid=<?php echo base64_encode($row['product_id']); ?>"
                                                class="badge badge-primary mr-2" data-id="<?php echo $row['product_id']; ?>"
                                                style="color:green;">
                                                <i class="ri-file-copy-2-line mr-0"></i>
                                            </a>
                                            <form id="deleteForm" method="post">
                                                <input type="hidden" name="id" value="<?php echo $row['product_id']; ?>">
                                                <button type="button" class="badge badge-danger mr-2"
                                                    style="border: none; background: none;" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="delete"
                                                    onclick="deleteProduct('<?php echo $row['product_id']; ?>')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            <!-- Trigger Button -->
                                            <!-- Trigger for Modal -->
                                            <a href="#" class="badge badge-secondary mr-2" data-toggle="modal1"
                                                data-id="<?php echo $row['product_id']; ?>" data-target="#uploadImageModal"
                                                title="Upload Images">
                                                <i class="fa fa-upload"></i>
                                            </a>
                                            

                                            <!-- Modal for Uploading Image -->
                                            <div id="uploadImageModal" class="modal fade" tabindex="-1" role="dialog"
                                                aria-labelledby="uploadImageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="uploadImageModalLabel">Upload Images
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="imageUploadForm" action="upload_images.php"
                                                                method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" id="product_id" name="product_id">

                                                                <!-- Main Image Upload -->
                                                                <div class="form-group">
                                                                    <label for="mainImage">Main Image</label>
                                                                    <input type="file" class="form-control" id="mainImage"
                                                                        name="mainImage" accept="image/*">
                                                                    <div id="mainImagePreview" class="mt-3"></div>
                                                                    <button type="button" id="removeMainImageBtn"
                                                                        class="btn btn-danger" style="display:none;">Remove
                                                                        Main Image</button>
                                                                </div>

                                                                <!-- Bulk Image Upload -->
                                                                <div class="form-group">
                                                                    <label for="bulkImages">Other Images (Bulk
                                                                        Upload)</label>
                                                                    <input type="file" class="form-control" id="bulkImages"
                                                                        name="bulkImages[]" accept="image/*" multiple>
                                                                    <div id="bulkImagesPreview" class="mt-3"></div>
                                                                </div>

                                                                <button type="submit"
                                                                    class="btn btn-primary">Upload</button>
                                                            </form>
                                                            <div id="uploadStatus" class="mt-3"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    var isSubmitting = false;

                                                    // Trigger modal open on button click
                                                    $('[data-toggle="modal1"]').click(function () {
                                                        var product_id = $(this).data('id');
                                                        $('#product_id').val(product_id);  // Set product_id in the hidden input field
                                                        $('#uploadImageModal').modal('show');  // Show the modal

                                                        // Fetch current images from the server via AJAX
                                                        $.ajax({
                                                            url: 'fetch_current_images.php',  // PHP file to fetch current image paths
                                                            type: 'POST',
                                                            data: { product_id: product_id },
                                                            success: function (response) {
                                                                var result = JSON.parse(response);
                                                                if (result.status === 'success') {
                                                                    // Display current main image
                                                                    if (result.mainImage) {
                                                                        $('#mainImagePreview').html('<img src="' + result.mainImage + '" style="max-width: 100%; margin-top: 10px;"> <button class="removeImageBtn" data-type="main" data-path="' + result.mainImage + '">Remove</button>');
                                                                        $('#mainImage').hide(); // Hide the input for main image
                                                                    } else {
                                                                        $('#mainImage').show(); // Show the input for main image if not already uploaded
                                                                    }

                                                                    // Display current bulk images
                                                                    if (result.bulkImages && result.bulkImages.length > 0) {
                                                                        var preview = $('#bulkImagesPreview');
                                                                        preview.empty();
                                                                        result.bulkImages.forEach(function (imagePath) {
                                                                            preview.append('<img src="' + imagePath + '" style="max-width: 100px; margin-top: 10px; margin-right: 10px;"> <button class="removeImageBtn" data-type="bulk" data-path="' + imagePath + '">Remove</button>');
                                                                        });
                                                                    }
                                                                } else {
                                                                    $('#uploadStatus').html('<div class="alert alert-danger">' + result.message + '</div>');
                                                                }
                                                            },
                                                            error: function (xhr, status, error) {
                                                                $('#uploadStatus').html('<div class="alert alert-danger">An error occurred while fetching images.</div>');
                                                                console.error(error);
                                                            }
                                                        });
                                                    });

                                                    // Preview the main image
                                                    $('#mainImage').on('change', function (event) {
                                                        const file = event.target.files[0];
                                                        const preview = $('#mainImagePreview');
                                                        preview.empty();  // Clear the preview content properly

                                                        if (file) {
                                                            const reader = new FileReader();
                                                            reader.onload = function (e) {
                                                                preview.html('<img src="' + e.target.result + '" style="max-width: 100%; margin-top: 10px;">');
                                                                $('#mainImage').hide();  // Hide the main image input after uploading
                                                            };
                                                            reader.readAsDataURL(file);
                                                        }
                                                    });

                                                    $('#bulkImages').off('change').on('change', function (event) {
                                                        const files = event.target.files;
                                                        const preview = $('#bulkImagesPreview');
                                                        preview.empty(); // Clear the preview area to avoid duplicates

                                                        if (files.length) {
                                                            Array.from(files).forEach((file) => {
                                                                const reader = new FileReader();
                                                                reader.onload = function (e) {
                                                                    // Append the preview for each image with a remove button
                                                                    preview.append(`
                                <div style="position: relative; display: inline-block; margin-right: 10px;">
                                    <img src="${e.target.result}" style="max-width: 100px; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                    <button class="removeImageBtn" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; cursor: pointer;">&times;</button>
                                </div>
                            `);
                                                                };
                                                                reader.readAsDataURL(file); // Read the file to generate a data URL
                                                            });
                                                        }
                                                    });


                                                    // Handle image removal
                                                    $(document).on('click', '.removeImageBtn', function () {
                                                        var imageType = $(this).data('type');
                                                        var imagePath = $(this).data('path');

                                                        if (confirm("Are you sure you want to remove this image?")) {
                                                            // Send AJAX request to remove the image
                                                            $.ajax({
                                                                url: 'remove_image.php',
                                                                type: 'POST',
                                                                data: { product_id: $('#product_id').val(), imagePath: imagePath, imageType: imageType },
                                                                success: function (response) {
                                                                    var result = JSON.parse(response);
                                                                    if (result.status === 'success') {
                                                                        // Remove the image preview from the UI
                                                                        $(this).prev('img').remove();  // Remove the image element
                                                                        $(this).remove();  // Remove the remove button
                                                                        if (imageType === 'main') {
                                                                            $('#mainImage').show(); // Show the input for main image if removed
                                                                        }
                                                                    } else {
                                                                        alert(result.message);
                                                                    }
                                                                },
                                                                error: function (xhr, status, error) {
                                                                    alert('An error occurred while removing the image.');
                                                                }
                                                            });
                                                        }
                                                    });

                                                    // Prevent multiple form submissions
                                                    $('#imageUploadForm').submit(function (event) {
                                                        event.preventDefault();

                                                        if (isSubmitting) {
                                                            return;
                                                        }

                                                        isSubmitting = true;
                                                        $('button[type="submit"]').attr('disabled', true);

                                                        const formData = new FormData(this);
                                                        $.ajax({
                                                            url: $(this).attr('action'),
                                                            type: 'POST',
                                                            data: formData,
                                                            contentType: false,
                                                            processData: false,
                                                            success: function (response) {
                                                                var result = JSON.parse(response);
                                                                if (result.status === 'success') {
                                                                    $('#uploadStatus').html('<div class="alert alert-success">' + result.message + '</div>');
                                                                    $('#uploadImageModal').modal('hide');
                                                                    location.reload();
                                                                } else {
                                                                    $('#uploadStatus').html('<div class="alert alert-danger">' + result.message + '</div>');
                                                                }
                                                            },
                                                            error: function (xhr, status, error) {
                                                                $('#uploadStatus').html('<div class="alert alert-danger">An error occurred while uploading the images.</div>');
                                                            },
                                                            complete: function () {
                                                                isSubmitting = false;
                                                                $('button[type="submit"]').attr('disabled', false);
                                                            }
                                                        });
                                                    });
                                                });

                                            </script>

                                            <style></style>


                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="view-product-details" data-id="<?php echo $row['product_id']; ?>"
                                            data-toggle="modal" data-target="#productDetailsModal" style="color:green;">
                                            <?php echo $row['product_id']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row['product_name']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $sqlprotype = "SELECT * FROM ProductType WHERE product_type_id = '{$row['product_type']}'";
                                        $resultprotype = mysqli_query($conn, $sqlprotype);
                                        $product_type = mysqli_fetch_assoc($resultprotype);
                                        echo $product_type['product_type_name'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $sqlbrnd = "SELECT * FROM Brands WHERE brands_id = '{$row['brand']}'";
                                        $resultbrnd = mysqli_query($conn, $sqlbrnd);
                                        $brand = mysqli_fetch_assoc($resultbrnd);
                                        echo $brand['brands_name'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $row['size']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['quantity']; ?>
                                        100
                                        <a class="badge badge-primary mr-2" data-toggle="tooltip" data-placement="top"
                                            title="" data-original-title="add"
                                            href="add-inward-serial.php?id=<?php echo base64_encode($row['product_id']); ?>"><i
                                                class="fa fa-plus"></i></a>
                                    </td>
                                    <td>
                                        <?php echo $row['price'] . ' ' . $row['currency']; ?>

                                    </td>
                                    <td>
                                        <?php echo $row['product_status']; ?>
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


<!-- product Details Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailsLabel">Product Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="productDetailsContent">
                    <!-- Details will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Event listener for clicking on product_id
        $('.view-product-details').click(function () {
            var productId = $(this).data('id');

            // Clear previous content
            $('#productDetailsContent').html('<p>Loading...</p>');

            // Fetch product details
            $.ajax({
                url: 'products/view.php',
                type: 'POST',
                data: { id: productId },
                success: function (response) {
                    $('#productDetailsContent').html(response);

                },
                error: function (xhr, status, error) {
                    $('#productDetailsContent').html('<p>An error occurred while loading the details.</p>');
                }
            });
        });
    });
</script>




<script>
    function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            // Send AJAX request
            $.ajax({
                url: 'products/delete_product.php', // Path to your PHP script
                type: 'POST',
                data: { id: productId },
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        window.location.href = 'products.php'; // Redirect on success
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred while deleting the product.');
                    console.error(error);
                }
            });
        }
    }

</script>
<?php

include 'products/addproduct.php';
include 'footer.php';
?>