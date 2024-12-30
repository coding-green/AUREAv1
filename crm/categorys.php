<?php
include 'header.php';
?>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Categories</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <?php
                // Array of categories
                $categories = [
                    [
                        "title" => "1. Product Type",
                        "class" => "product-type",
                        "endpoint" => "category/insert/insert_product_type.php",
                        "viewEndpoint" => "category/view/get_product_types.php",
                        "updateEndpoint" => "category/update/update_product_type.php",
                        "deleteEndpoint" => "category/delete/delete_product_type.php"
                    ],
                    [
                        "title" => "2. Skin Types",
                        "class" => "skin-type",
                        "endpoint" => "category/insert/insert_skin_type.php",
                        "viewEndpoint" => "category/view/get_skin_types.php",
                        "updateEndpoint" => "category/update/update_skin_type.php",
                        "deleteEndpoint" => "category/delete/delete_skin_type.php"
                    ],
                    [
                        "title" => "3. Skin Concerns",
                        "class" => "skin-concern",
                        "endpoint" => "category/insert/insert_skin_concerns.php",
                        "viewEndpoint" => "category/view/get_skin_concerns.php",
                        "updateEndpoint" => "category/update/update_skin_concerns.php",
                        "deleteEndpoint" => "category/delete/delete_skin_concerns.php"
                    ],
                    [
                        "title" => "4. Aurea Collection",
                        "class" => "aurea-collection",
                        "endpoint" => "category/insert/insert_aurea_collection.php",
                        "viewEndpoint" => "category/view/get_aurea_collection.php",
                        "updateEndpoint" => "category/update/update_aurea_collection.php",
                        "deleteEndpoint" => "category/delete/delete_aurea_collection.php"
                    ],
                    [
                        "title" => "5. Formulation",
                        "class" => "formulation",
                        "endpoint" => "category/insert/insert_formulation.php",
                        "viewEndpoint" => "category/view/get_formulation.php",
                        "updateEndpoint" => "category/update/update_formulation.php",
                        "deleteEndp int" => "category/delete/delete_formulation.php"
                    ],
                    [
                        "title" => "6. Brands",
                        "class" => "brand",
                        "endpoint" => "category/insert/insert_brands.php",
                        "viewEndpoint" => "category/view/get_brands.php",
                        "updateEndpoint" => "category/update/update_brands.php",
                        "deleteEndpoint" => "category/delete/delete_brands.php"
                    ],
                    [
                        "title" => "7. Size",
                        "class" => "size",
                        "endpoint" => "category/insert/insert_size.php",
                        "viewEndpoint" => "category/view/get_size.php",
                        "updateEndpoint" => "category/update/update_size.php",
                        "deleteEndpoint" => "category/delete/delete_size.php"
                    ],
                    [
                        "title" => "8. Currency",
                        "class" => "currency",
                        "endpoint" => "category/insert/insert_currency.php",
                        "viewEndpoint" => "category/view/get_currency.php",
                        "updateEndpoint" => "category/update/update_currency.php",
                        "deleteEndpoint" => "category/delete/delete_currency.php"
                    ]
                ];
                ?>
                <div class="row">
                    <?php foreach ($categories as $category): ?>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <p class="message"></p> <!-- Placeholder for success or error message -->
                                    <h4 class="card-title"><?php echo $category['title']; ?></h4>
                                    <div class="text-center">
                                    <a href="#" class="btn btn-primary view-all"
                                        data-view-endpoint="<?php echo $category['viewEndpoint'] ?? ''; ?>"><i
                                            class="fa fa-eye"></i></a>
                                    <a href="#" class="btn btn-success open-modal"
                                        data-title="<?php echo $category['title']; ?>"
                                        data-category="<?php echo $category['class']; ?>"
                                        data-endpoint="<?php echo isset($category['endpoint']) ? $category['endpoint'] : ''; ?>">
                                        <i class="fa fa-plus"></i></a>
                                    <a href="#" class="btn btn-secondary export-btn"
                                        data-category="<?php echo $category['class']; ?>">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
                <!-- Add New Modal Template -->
                <div id="categoryFormModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle">Add New Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="categoryForm">
                                    <div class="form-group">
                                        <label for="categoryName">Category Name</label>
                                        <input type="text" class="form-control" id="categoryName" name="categoryName"
                                            required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View All Modal Template -->
                <div id="viewAllModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">View All</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width:59%;">Category Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamic data rows go here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Modal Template -->
                <div id="updateFormModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalTitle">Update Product Type</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="updateForm">
                                    <div class="form-group">
                                        <label for="updateCategoryName">Category Name</label>
                                        <input type="text" class="form-control" id="updateCategoryName" required>
                                        <input type="hidden" id="updateCategoryId">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.querySelectorAll('.export-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            const category = button.getAttribute('data-category');
                            window.location.href = 'category/export/export_categories.php?category=' + category;
                        });
                    });
                    // Display View All modal with data and action buttons
                    document.querySelectorAll('.view-all').forEach(button => {
                        button.addEventListener('click', function (event) {
                            event.preventDefault();

                            const viewEndpoint = button.getAttribute('data-view-endpoint');
                            const modal = document.getElementById('viewAllModal');
                            const dataTableBody = document.querySelector('#dataTable tbody');
                            dataTableBody.innerHTML = '';

                            if (viewEndpoint) {
                                fetch(viewEndpoint)
                                    .then(response => response.json())
                                    .then(data => {
                                        data.forEach(item => {
                                            const row = document.createElement('tr');
                                            row.innerHTML = `
                                                <td>${item.product_type_name || item.skin_type_name || item.concern_name || item.aurea_collection_name || item.formulation_name || item.brands_name || item.size_name || item.currency_name}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm update-btn" data-id="${item.product_type_id || item.skin_type_id || item.skin_concern_id || item.aurea_collection_id || item.formulation_id || item.brands_id || item.size_id || item.currency_id}" data-name="${item.product_type_name || item.skin_type_name || item.concern_name || item.aurea_collection_name || item.formulation_name || item.brands_name || item.size_name || item.currency_name}">Update</button>
                                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${item.product_type_id || item.skin_type_id || item.skin_concern_id || item.aurea_collection_id || item.formulation_id || item.brands_id || item.size_id || item.currency_id}">Delete</button>
                                                </td>`;
                                            dataTableBody.appendChild(row);
                                        });
                                        $(modal).modal('show');

                                        // Attach event listeners for Update and Delete buttons
                                        document.querySelectorAll('.update-btn').forEach(updateBtn => {
                                            updateBtn.addEventListener('click', openUpdateModal);
                                        });
                                        document.querySelectorAll('.delete-btn').forEach(deleteBtn => {
                                            deleteBtn.addEventListener('click', deleteRecord);
                                        });
                                    })
                                    .catch(error => console.error('Error:', error));
                            }
                        });
                    });

                    // Function to open Update Modal
                    function openUpdateModal() {
                        const id = this.getAttribute('data-id');
                        const name = this.getAttribute('data-name');

                        document.getElementById('updateCategoryId').value = id;
                        document.getElementById('updateCategoryName').value = name;

                        $('#updateFormModal').modal('show');
                    }

                    // Handle Update form submission
                    document.getElementById('updateForm').addEventListener('submit', function (event) {
                        event.preventDefault();

                        const id = document.getElementById('updateCategoryId').value;
                        const name = document.getElementById('updateCategoryName').value;

                        fetch('category/update/update_category.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: id, name: name })
                        })
                            .then(response => response.json())
                            .then(data => {
                                $('#updateFormModal').modal('hide');
                                alert(data.message);
                                location.reload();
                            })
                            .catch(error => console.error('Error:', error));
                    });

                    // Function to delete a record
                    function deleteRecord() {
                        const id = this.getAttribute('data-id'); // Get the specific ID of the product type to delete

                        const endpoint = 'category/delete/delete_category.php'; // Ensure this points to your delete PHP file

                        // Confirm deletion with the category ID
                        if (confirm(`Are you sure you want to delete this category? ID: ${id}`)) {
                            fetch(endpoint, {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ id: id }) // Send only the selected ID
                            })
                                .then(response => response.json()) // Parse the JSON response
                                .then(data => {
                                    alert(data.message); // Show the response message
                                    if (data.status === 'success') {
                                        location.reload(); // Reload the page on successful delete
                                    } else {
                                        alert('Failed to delete the category. Please try again.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('An error occurred while trying to delete the category. Please try again.');
                                });
                        }
                    }


                    // Open Add New modal
                    document.querySelectorAll('.open-modal').forEach(button => {
                        button.addEventListener('click', function (event) {
                            event.preventDefault();

                            const modalTitle = button.getAttribute('data-title');
                            const endpoint = button.getAttribute('data-endpoint');
                            document.getElementById('modalTitle').innerText = `Add New ${modalTitle}`;

                            const modal = document.getElementById('categoryFormModal');
                            $(modal).modal('show');

                            const messageElement = button.closest('.card-body').querySelector('.message');
                            messageElement.innerText = '';
                            messageElement.classList.remove('text-success', 'text-danger');

                            document.getElementById('categoryForm').onsubmit = function (e) {
                                e.preventDefault();

                                const categoryName = document.getElementById('categoryName').value;

                                if (endpoint) {
                                    fetch(endpoint, {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json' },
                                        body: JSON.stringify({ categoryName: categoryName })
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            $(modal).modal('hide');
                                            document.getElementById('categoryForm').reset();

                                            if (data.status === "success") {
                                                messageElement.innerText = data.message;
                                                messageElement.classList.add('text-success');
                                            } else {
                                                messageElement.innerText = data.message || 'Failed to add category.';
                                                messageElement.classList.add('text-danger');
                                            }
                                        })
                                        .catch((error) => {
                                            console.error('Error:', error);
                                            messageElement.innerText = 'An error occurred. Please try again.';
                                            messageElement.classList.add('text-danger');
                                        });
                                }
                            };
                        });
                    });
                </script>
            </div>
        </div>
        <!-- Page end  -->
    </div>
</div>

<?php
include 'footer.php';
?>