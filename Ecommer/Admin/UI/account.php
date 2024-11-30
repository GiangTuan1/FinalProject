<?php
// Check if the user is an admin
$role = $_SESSION['role'] ?? '';
if ($role !== 'Admin') {
    header("Location: forbidden.php");
    exit();
}
// Fetch account data and roles
$sql = "SELECT users.user_id, users.username, users.full_name, users.email, users.phone_number, users.avatar, roles.role_name
        FROM users
        JOIN user_roles ON users.user_id = user_roles.user_id
        JOIN roles ON user_roles.role_id = roles.role_id";
$resultAccount = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Account Management</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>
                                <button type="button" class="btn btn-success" onclick="openAccountModal()">
                                    Add
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultAccount && $resultAccount->num_rows > 0) {
                            while ($row = $resultAccount->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["full_name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["phone_number"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["role_name"]) . "</td>";
                                echo "<td>";
                                echo "<button style='margin-right: 10px; type='button' class='btn btn-primary' onclick='editAccount(" . htmlspecialchars($row["user_id"]) . ")'>Edit</button>";
                                echo "<button type='button' class='btn btn-danger ms-2' onclick='deleteAccount(" . htmlspecialchars($row["user_id"]) . ")'>Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accountModalLabel">Account Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="accountForm" enctype="multipart/form-data">
                    <input type="hidden" id="userId" name="userId">
                    <div class="mb-3">
                        <label for="username" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Avatar</label>
                        <div class="d-flex align-items-center">
                            <img id="avatarPreview" src="" alt="Avatar Preview" class="img-thumbnail me-3" style="max-width: 150px; max-height: 150px;">
                            <input type="file" class="form-control" id="avatarFile" name="avatarFile">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <?php
                            // Fetch roles for the dropdown
                            $roleSql = "SELECT role_id, role_name FROM roles";
                            $roleResult = $conn->query($roleSql);
                            while ($roleRow = $roleResult->fetch_assoc()) {
                                echo "<option value='" . $roleRow["role_id"] . "'>" . htmlspecialchars($roleRow["role_name"]) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function openAccountModal() {
        document.getElementById("accountForm").reset();
        document.getElementById("userId").value = "";
        document.getElementById("accountModalLabel").textContent = "Add Account";
        const modal = new bootstrap.Modal(document.getElementById('accountModal'));
        modal.show();
    }

    function editAccount(userId) {
    fetch(`../backEnd/get_account.php?id=${userId}`)
    .then(response => response.json())
    .then(data => {
        if (data.user_id) {
            document.getElementById("userId").value = data.user_id;
            document.getElementById("username").value = data.username;
            document.getElementById("fullName").value = data.full_name;
            document.getElementById("email").value = data.email;
            document.getElementById("phoneNumber").value = data.phone_number;
            document.getElementById("address").value = data.address;
            document.getElementById("role").value = data.role_id;

            // Update avatar preview with full URL
            const avatarBasePath = '../../images/'; // Base path for avatars
            document.getElementById("avatarPreview").src = data.avatar ? avatarBasePath + data.avatar : avatarBasePath + 'default-avatar.png'; 

            document.getElementById("accountModalLabel").textContent = "Edit Account";
            const modal = new bootstrap.Modal(document.getElementById('accountModal'));
            modal.show();
        } else {
            alert('Account not found.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to fetch account data.');
    });
}




    document.getElementById("accountForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('../backEnd/save_account.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('accountModal'));
                    modal.hide();
                    location.reload();
                } else {
                    alert('Failed to save account data: ' + data.error);
                }
            });
    });
    
</script>

<script>
    function deleteAccount(userId) {
    Swal.fire({
        title: 'Are you sure you want to delete this account?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`../backEnd/delete_account.php`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Deleted!',
                        'Your account has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        data.error || 'Failed to delete account.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Failed to delete account.',
                    'error'
                );
            });
        }
    });
}

</script>
