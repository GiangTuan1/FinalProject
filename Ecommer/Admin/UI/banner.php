<?php
include_once("../../config.php");

// Check access rights
$role = $_SESSION['role'] ?? '';
if ($role !== 'Admin' && $role !== 'Staff') {
    header("Location: forbidden.php");
    exit();
}

// Get the banner list from the database
$sql = "SELECT banner_id, title, description, image_url, status FROM banners";
$resultBanner = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Banner Management</h5>
            <button class="btn btn-success mb-3" onclick="openBannerModal()">Add Banner</button>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultBanner && $resultBanner->num_rows > 0) {
                            while ($row = $resultBanner->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                                echo "<td><img src='../../images/" . htmlspecialchars($row["image_url"]) . "' alt='" . htmlspecialchars($row["title"]) . "' width='100'></td>";
                                echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                                echo "<td>";
                                echo "<button style='margin-right: 10px; type='button' class='btn btn-primary' onclick='openBannerModal(" . $row["banner_id"] . ")'>Edit</button>";
                                echo "<button type='button' class='btn btn-danger' onclick='deleteBanner(" . $row["banner_id"] . ")'>Delete</button>";
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
<div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bannerModalLabel">Banner Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bannerForm" enctype="multipart/form-data">
                    <input type="hidden" id="bannerId" name="bannerId">
                    <div class="mb-3">
                        <label for="bannerTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="bannerTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="bannerDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="bannerDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="bannerImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="bannerImage" name="image">
                        <img id="bannerImagePreview" src="" alt="Banner Image Preview" style="display: none; margin-top: 10px; max-width: 100%;">
                    </div>
                    <div class="mb-3">
                        <label for="bannerStatus" class="form-label">Status</label>
                        <select class="form-select" id="bannerStatus" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
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
    function openBannerModal(bannerId = '') {
        document.getElementById("bannerForm").reset();
        document.getElementById("bannerId").value = bannerId;
        document.getElementById("bannerImagePreview").style.display = 'none';
        document.getElementById("bannerModalLabel").textContent = bannerId ? "Edit Banner" : "Add Banner";

        if (bannerId) {
            fetch(`../backEnd/get_banners.php?id=${bannerId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.banner_id) {
                        document.getElementById("bannerTitle").value = data.title;
                        document.getElementById("bannerDescription").value = data.description;
                        document.getElementById("bannerStatus").value = data.status;
                        document.getElementById("bannerImagePreview").src = `../../images/${data.image_url}`;
                        document.getElementById("bannerImagePreview").style.display = 'block';
                    } else {
                        alert('Banner not found.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to fetch banner data.');
                });
        }

        var modal = new bootstrap.Modal(document.getElementById('bannerModal'));
        modal.show();
    }

    function deleteBanner(bannerId) {
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
                fetch('../backEnd/delete_banner.php', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'id': bannerId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'Your banner has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                data.error || 'Failed to delete banner.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Failed to delete banner.',
                            'error'
                        );
                    });
            }
        });
    }

    document.getElementById("bannerForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('../backEnd/save_banner.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('bannerModal'));
                    modal.hide();
                    location.reload();
                } else {
                    alert('Failed to save banner data.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save banner data.');
            });
    });

    document.getElementById("bannerImage").addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("bannerImagePreview").src = e.target.result;
                document.getElementById("bannerImagePreview").style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById("bannerImagePreview").style.display = 'none';
        }
    });
</script>