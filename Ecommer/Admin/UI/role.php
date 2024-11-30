<?php

$role = $_SESSION['role'] ?? '';
if ($role !== 'Admin') {
    header("Location: forbidden.php");
    exit();
}

$sql = "SELECT role_id, role_name FROM roles";
$resultRole = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Role Management</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>
                                <button type="button" class="btn btn-success" onclick="openRoleModal()">
                                    Add
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultRole && $resultRole->num_rows > 0) {
                            while ($row = $resultRole->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["role_name"]) . "</td>";
                                echo "<td>";
                                echo "<button style='margin-right: 10px; type='button' class='btn btn-primary' onclick='editRole(" . $row["role_id"] . ")'>Edit</button>";
                                echo "<button type='button' class='btn btn-danger' onclick='deleteRole(" . $row["role_id"] . ")'>Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Role Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    <input type="hidden" id="roleId" name="roleId">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Role</label>
                        <select class="form-select" id="roleName" name="roleName" required>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                            <option value="Staff">Staff</option>
                            <option value="Sale">Sale</option>
                        </select>
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
    function openRoleModal() {
        document.getElementById("roleForm").reset();
        document.getElementById("roleId").value = "";
        document.getElementById("roleName").selectedIndex = 0; // Reset select to default value
        document.getElementById("roleModalLabel").textContent = "Add Role";
        var modal = new bootstrap.Modal(document.getElementById('roleModal'));
        modal.show();
    }

    function editRole(roleId) {
        fetch(`../backEnd/get_role.php?id=${roleId}`)
            .then(response => response.json())
            .then(data => {
                if (data.role_id) {
                    document.getElementById("roleId").value = data.role_id;
                    const roleNameSelect = document.getElementById("roleName");

                    // Set the value of select to match the received role_name
                    let found = false;
                    for (let i = 0; i < roleNameSelect.options.length; i++) {
                        if (roleNameSelect.options[i].text === data.role_name) {
                            roleNameSelect.selectedIndex = i;
                            found = true;
                            break;
                        }
                    }
                    
                    // If no matching value is found, an error message or appropriate handling may be reported
                    if (!found) {
                        console.error('Role name not found in select options:', data.role_name);
                    }

                    document.getElementById("roleModalLabel").textContent = "Edit Role";
                    var modal = new bootstrap.Modal(document.getElementById('roleModal'));
                    modal.show();
                } else {
                    alert('Role not found.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to fetch role data.');
            });
    }

    function deleteRole(roleId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`../backEnd/delete_role.php?id=${roleId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'Your role has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                data.error || 'Failed to delete role.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Failed to delete role.',
                            'error'
                        );
                    });
            }
        });
    }

    document.getElementById("roleForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('../backEnd/save_role.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('roleModal'));
                    modal.hide();
                    location.reload();
                } else {
                    alert('Failed to save role data.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save role data.');
            });
    });
</script>

