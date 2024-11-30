<?php
 // Assuming config.php contains the database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's orders
$query = "SELECT `order_id`, `user_id`, `total`, `status`, `created_at` FROM `orders` WHERE `user_id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();
$orders = $orders_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

    <!--/ End Header -->

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="?page=order_history">Order History</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="order-history section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Order History -->
                    <h2>Your Order History</h2>
                    <table class="table order-history-table">
                        <thead>
                            <tr class="main-heading">
                                <th>DATE</th>
                                <th class="text-center">ORDER ID</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(date('d M Y', strtotime($order['created_at']))); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars(ucfirst($order['order_id'])); ?></td>
                                    <td class="text-center">$<?php echo number_format($order['total'], 2); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars(ucfirst($order['status'])); ?></td>
                                    <td class="text-center">
                                        <a href="index.php?page=order_details&&order_id=<?php echo $order['order_id']; ?>" class="btn btn-primary" style="a:visited color: #007bff;">
                                            <i class="ti-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!--/ End Order History -->
                </div>
            </div>
        </div>
    </div>
    