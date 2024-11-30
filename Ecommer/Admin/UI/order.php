<?php

$role = $_SESSION['role'] ?? '';
if ($role !== 'Admin' && $role !== 'Staff') {
    header("Location: forbidden.php");
    exit();
}
// Query to get order data and related tables
$sql = "SELECT o.order_id, o.user_id, u.username, o.total, o.status, o.created_at
        FROM orders o
        JOIN users u ON o.user_id = u.user_id";
$resultOrder = $conn->query($sql);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Order Management</h5>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultOrder && $resultOrder->num_rows > 0) {
                            while ($row = $resultOrder->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["order_id"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["total"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                                echo "<td>";
                                echo "<button style='margin-right: 10px; type='button' class='btn btn-primary' onclick='viewOrderItems(" . $row["order_id"] . ")'>View</button>";
                                echo "<button type='button' class='btn btn-secondary' onclick='editOrderStatus(" . $row["order_id"] . ")'>Edit Status</button>";
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

<!-- Modal for Order Items -->
<div class="modal fade" id="orderItemsModal" tabindex="-1" aria-labelledby="orderItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderItemsModalLabel">Order Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="orderItemsContainer"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Order Status -->
<div class="modal fade" id="editOrderStatusModal" tabindex="-1" aria-labelledby="editOrderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderStatusModalLabel">Edit Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOrderStatusForm">
                    <input type="hidden" id="editOrderId" name="orderId">
                    <div class="mb-3">
                        <label for="orderStatus" class="form-label">Status</label>
                        <select class="form-select" id="orderStatus" name="status" required>
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
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
    function viewOrderItems(orderId) {
        fetch(`../backEnd/get_order_items.php?id=${orderId}`)
            .then(response => response.json())
            .then(data => {
                let itemsHtml = '<table class="table">';
                itemsHtml += '<thead><tr><th>Product ID</th><th>Size ID</th><th>Quantity</th><th>Price</th></tr></thead><tbody>';
                data.forEach(item => {
                    itemsHtml += `<tr>
                                    <td>${item.product_name}</td>
                                    <td>${item.size}</td>
                                    <td>${item.quantity}</td>
                                    <td>${item.price}</td>
                                  </tr>`;
                });
                itemsHtml += '</tbody></table>';
                document.getElementById("orderItemsContainer").innerHTML = itemsHtml;
                var modal = new bootstrap.Modal(document.getElementById('orderItemsModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to fetch order items.');
            });
    }

    function editOrderStatus(orderId) {
    // Fetch order details including status from the server
    fetch(`../backEnd/get_order.php?id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.order_id) {
                document.getElementById("editOrderId").value = data.order_id;
                document.getElementById("orderStatus").value = data.status;
                var modal = new bootstrap.Modal(document.getElementById('editOrderStatusModal'));
                modal.show();
            } else {
                alert('Order not found.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to fetch order data.');
        });
}

    document.getElementById("editOrderStatusForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('../backEnd/save_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('editOrderStatusModal'));
                    modal.hide();
                    location.reload();
                } else {
                    alert('Failed to save order status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save order status.');
            });
    });
</script>
