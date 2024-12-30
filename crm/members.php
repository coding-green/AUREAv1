<?php
include 'header.php';
?>

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <!-- Home Reels -->
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Members</h4>
                    </div>
                </div>
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                <th>#</th>
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Postal Code</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            <?php
                            $sql = "SELECT * FROM members_login";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="badge badge-danger mr-2" style="border: none; background: none;" data-toggle="modal"
                                                data-target="#deleteModal"
                                                onclick="setDeleteUserId('<?php echo $row['user_id']; ?>')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td><a href="javascript:void(0);" data-toggle="modal" data-target="#viewModal"
                                            onclick="viewMember('<?php echo $row['user_id']; ?>')">
                                            <?php echo $row['user_id']; ?>
                                        </a></td>
                                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone_number']; ?></td>
                                    <td><?php echo $row['city']; ?></td>
                                    <td><?php echo $row['postal_code']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['registration_date'])); ?></td>
                                    <td>
                                        <?php
                                        if ($row['is_active'] == 1) {
                                            echo '<span class="badge badge-success">Active</span>';
                                        } else {
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


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this member?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="user_id" id="deleteUserId">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteMember()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Response</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="messageModalBody">
                <!-- Dynamic Response Message -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Set User ID for deletion
    function setDeleteUserId(userId) {
        document.getElementById('deleteUserId').value = userId;
    }

    // Delete Member Function
    function deleteMember() {
        const userId = document.getElementById('deleteUserId').value;

        // AJAX Request
        fetch('delete_member.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `user_id=${encodeURIComponent(userId)}`,
        })
            .then(response => response.json())
            .then(data => {
                // Update Message Modal
                const messageModalBody = document.getElementById('messageModalBody');
                const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));

                if (data.status === 'success') {
                    messageModalBody.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                } else {
                    messageModalBody.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }

                // Close Delete Modal
                $('#deleteModal').modal('hide');

                // Show Message Modal
                messageModal.show();

                // Reload Data
                setTimeout(() => {
                    location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                const messageModalBody = document.getElementById('messageModalBody');
                messageModalBody.innerHTML = `<div class="alert alert-danger">An unexpected error occurred.</div>`;
                const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
                messageModal.show();
            });
    }
</script>



<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Member Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <!-- Member Details will be dynamically updated here -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="viewUserId"><strong>User ID:</strong></label>
                            <p id="viewUserId"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewFullName"><strong>Full Name:</strong></label>
                            <p id="viewFullName"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewEmail"><strong>Email:</strong></label>
                            <p id="viewEmail"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewPhoneNumber"><strong>Phone Number:</strong></label>
                            <p id="viewPhoneNumber"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="viewCity"><strong>City:</strong></label>
                            <p id="viewCity"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewPostalCode"><strong>Postal Code:</strong></label>
                            <p id="viewPostalCode"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewRegistrationDate"><strong>Registration Date:</strong></label>
                            <p id="viewRegistrationDate"></p>
                        </div>
                        <div class="form-group">
                            <label for="viewStatus"><strong>Status:</strong></label>
                            <p id="viewStatus"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // View Member Details
    function viewMember(userId) {
        // Fetch member details via AJAX
        fetch('view_member.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `user_id=${encodeURIComponent(userId)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Populate the modal with member data
                    document.getElementById('viewUserId').innerText = data.member.user_id;
                    document.getElementById('viewFullName').innerText = data.member.first_name + ' ' + data.member.last_name;
                    document.getElementById('viewEmail').innerText = data.member.email;
                    document.getElementById('viewPhoneNumber').innerText = data.member.phone_number;
                    document.getElementById('viewCity').innerText = data.member.city;
                    document.getElementById('viewPostalCode').innerText = data.member.postal_code;
                    document.getElementById('viewRegistrationDate').innerText = data.member.registration_date;
                    document.getElementById('viewStatus').innerText = data.member.is_active == 1 ? 'Active' : 'Inactive';
                } else {
                    // Handle error
                    console.error('Error fetching member details');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>




<?php
include 'footer.php';
?>