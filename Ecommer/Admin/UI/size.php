<?php

$role = $_SESSION['role'] ?? '';
if ($role !== 'Admin' && $role !== 'Staff') {
    header("Location: forbidden.php");
    exit();
}

$sql = "SELECT size_id, size FROM sizes";
$resultSize = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Size Management</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Size Name</th>
                            <th>
                                <button type="button" class="btn btn-success" onclick="openSizeModal()">
                                    Add
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultSize && $resultSize->num_rows > 0) {
                            while ($row = $resultSize->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["size"]) . "</td>";
                                echo "<td>";
                                echo "<button style='margin-right: 10px; type='button' class='btn btn-primary' onclick='editSize(" . $row["size_id"] . ")'>Edit</button>";
                                echo "<button type='button' class='btn btn-danger' onclick='deleteSize(" . $row["size_id"] . ")'>Delete</button>";
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
<div class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sizeModalLabel">Size Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sizeForm">
                    <input type="hidden" id="sizeId" name="sizeId">
                    <div class="mb-3">
                        <label for="sizeName" class="form-label">Size Name</label>
                        <input type="text" class="form-control" id="sizeName" name="sizeName" required>
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
    function openSizeModal() {
    document.getElementById("sizeForm").reset();
    document.getElementById("sizeId").value = "";
    document.getElementById("sizeModalLabel").textContent = "Add Size";
    var modal = new bootstrap.Modal(document.getElementById('sizeModal'));
    modal.show();
}

function editSize(sizeId) {
    fetch(`../backEnd/get_size.php?id=${sizeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.size_id) {
                document.getElementById("sizeId").value = data.size_id;
                document.getElementById("sizeName").value = data.size;
                document.getElementById("sizeModalLabel").textContent = "Edit Size";
                var modal = new bootstrap.Modal(document.getElementById('sizeModal'));
                modal.show();
            } else {
                alert('Size not found.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to fetch size data.');
        });
}

function deleteSize(sizeId) {
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
            fetch(`../backEnd/delete_size.php?id=${sizeId}`, {
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
                        'Your size has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        data.error || 'Failed to delete size.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Failed to delete size.',
                    'error'
                );
            });
        }
    });
}

document.getElementById("sizeForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('../backEnd/save_size.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('sizeModal'));
                modal.hide();
                location.reload();
            } else {
                alert('Failed to save size data.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to save size data.');
        });
});

</script>
