<?php
include_once("../../config.php");

$role = $_SESSION['role'] ?? '';
if ($role !== 'Admin') {
    header("Location: forbidden.php");
    exit();
}

$sql = "SELECT category_id, category_name FROM categories";
$resultCategory = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Category Management</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>
                                <button type="button" class="btn btn-success" onclick="openCategoryModal()">
                                    Add
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultCategory && $resultCategory->num_rows > 0) {
                            while ($row = $resultCategory->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["category_name"]) . "</td>";
                                echo "<td>";
                                echo "<button style='margin-right: 10px; type='button' class='btn btn-primary' onclick='editCategory(" . $row["category_id"] . ")'>Edit</button>";
                                echo "<button type='button' class='btn btn-danger' onclick='deleteCategory(" . $row["category_id"] . ")'>Delete</button>";
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
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Category Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm">
                    <input type="hidden" id="categoryId" name="categoryId">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" required>
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
    function openCategoryModal() {
    document.getElementById("categoryForm").reset();
    document.getElementById("categoryId").value = "";
    document.getElementById("categoryModalLabel").textContent = "Add Category";
    var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
}

function editCategory(categoryId) {
    fetch(`../backEnd/get_category.php?id=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            if (data.category_id) {
                document.getElementById("categoryId").value = data.category_id;
                document.getElementById("categoryName").value = data.category_name;
                document.getElementById("categoryModalLabel").textContent = "Edit Category";
                var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
                modal.show();
            } else {
                alert('Category not found.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to fetch category data.');
        });
}

function deleteCategory(categoryId) {
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
            fetch(`../backEnd/delete_category.php?id=${categoryId}`, {
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
                        'Your category has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        data.error || 'Failed to delete category.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Failed to delete category.',
                    'error'
                );
            });
        }
    });
}

document.getElementById("categoryForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('../backEnd/save_category.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var modal = bootstrap.Modal.getInstance(document.getElementById('categoryModal'));
                modal.hide();
                location.reload();
            } else {
                alert('Failed to save category data.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to save category data.');
        });
});

</script>
