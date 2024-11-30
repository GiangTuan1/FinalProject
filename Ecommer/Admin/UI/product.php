<?php

$role = $_SESSION['role'] ?? '';
if ($role !== 'Admin' && $role !== 'Staff') {
    header("Location: forbidden.php");
    exit();
}
// Query to get product data and related tables
$sql = "SELECT p.product_id, p.product_name, p.description, p.price, c.category_name
        FROM products p
        JOIN categories c ON p.category_id = c.category_id";
$resultProduct = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Product Management</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>
                                <button type="button" class="btn btn-success" onclick="openProductModal()">
                                    Add
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultProduct && $resultProduct->num_rows > 0) {
                            while ($row = $resultProduct->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["product_name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["category_name"]) . "</td>";
                                echo "<td>";
                                echo "<button style='margin-right: 10px; type='button' class='btn btn-primary' onclick='editProduct(" . $row["product_id"] . ")'>Edit</button>";
                                echo "<button type='button' class='btn btn-danger' onclick='deleteProduct(" . $row["product_id"] . ")'>Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm" enctype="multipart/form-data">
                    <input type="hidden" id="productId" name="productId">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <?php
                            // Get the list of categories from the database to fill in the select
                            $categorySql = "SELECT category_id, category_name FROM categories";
                            $categoryResult = $conn->query($categorySql);
                            while ($categoryRow = $categoryResult->fetch_assoc()) {
                                echo "<option value='" . $categoryRow["category_id"] . "'>" . htmlspecialchars($categoryRow["category_name"]) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sizes" class="form-label">Sizes and Quantities</label>
                        <div id="sizes">
                            <?php
                            // Get size list from database to fill select
                            $sizeSql = "SELECT size_id, size FROM sizes";
                            $sizeResult = $conn->query($sizeSql);
                            while ($sizeRow = $sizeResult->fetch_assoc()) {
                                echo "<div class='input-group mb-2'>";
                                echo "<span class='input-group-text'>" . htmlspecialchars($sizeRow["size"]) . "</span>";
                                echo "<input type='number' class='form-control' name='sizes[" . $sizeRow["size_id"] . "]' placeholder='Quantity'>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Product Images</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Images</label>
                        <div id="currentImages" class="d-flex flex-wrap"></div>
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
    function openProductModal() {
        // Reset form fields
        document.getElementById("productForm").reset();
        document.getElementById("productId").value = ""; // Clear hidden product ID field
        document.getElementById("currentImages").innerHTML = ""; // Clear current images
        document.getElementById("productModalLabel").textContent = "Add Product";
        var modal = new bootstrap.Modal(document.getElementById('productModal'));
        modal.show();
    }

    function deleteProduct(productId) {
        // Show confirmation dialog
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
                // If user confirms, send delete request
                fetch('../backEnd/delete_product.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({ 'id': productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Display success message and refresh page
                        Swal.fire(
                            'Deleted!',
                            'Your product has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        // Display error message
                        Swal.fire(
                            'Error!',
                            data.error || 'Failed to delete product.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Failed to delete product.',
                        'error'
                    );
                });
            }
        });
    }

    function editProduct(productId) {
        // Fetch product details from the server
        fetch(`../backEnd/get_product.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.product_id) {
                    document.getElementById("productId").value = data.product_id;
                    document.getElementById("productName").value = data.product_name;
                    document.getElementById("description").value = data.description;
                    document.getElementById("price").value = data.price;
                    document.getElementById("category").value = data.category_id;
                    data.sizes.forEach(size => {
                        document.querySelector(`input[name='sizes[${size.size_id}]']`).value = size.quantity;
                    });
                    document.getElementById("currentImages").innerHTML = data.images.map(img => `
                        <div class="position-relative m-2">
                            <img src="../../images/${img.image_url}" class="img-thumbnail" style="width: 100px; height: 100px;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="deleteImage(${img.image_id})">&times;</button>
                        </div>
                    `).join("");
                    document.getElementById("productModalLabel").textContent = "Edit Product";
                    var modal = new bootstrap.Modal(document.getElementById('productModal'));
                    modal.show();
                } else {
                    alert('Product not found.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to fetch product data.');
            });
    }

    function deleteImage(imageId) {
        // Show confirmation dialog
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
                // If user confirms, send photo deletion request
                fetch('../backEnd/delete_image.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({ 'imageId': imageId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove photo from display list
                        document.querySelector(`button[onclick='deleteImage(${imageId})']`).parentElement.remove();
                    } else {
                        // Display error message
                        Swal.fire(
                            'Error!',
                            data.error || 'Failed to delete image.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Failed to delete image.',
                        'error'
                    );
                });
            }
        });
    }

    document.getElementById("productForm").addEventListener("submit", function(event) {
        event.preventDefault();
        // Handle form submission (e.g., send data to the server)
        const formData = new FormData(this);
        fetch('../backEnd/save_product.php', { 
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal and refresh table
                    var modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
                    modal.hide();
                    location.reload();
                } else {
                    alert('Failed to save product data.');
                }
            });
    });
</script>
