<?php
 // Assuming config.php contains the database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Fetch order details
$query = "
SELECT o.order_id, o.created_at, o.total, o.status, 
       oi.order_item_id, oi.product_id, oi.size_id, oi.quantity, oi.price, 
       p.product_name, pi.image_url, s.size 
FROM orders o 
JOIN order_items oi ON o.order_id = oi.order_id 
JOIN products p ON oi.product_id = p.product_id 
LEFT JOIN (
    SELECT product_id, MIN(image_url) AS image_url
    FROM product_images
    GROUP BY product_id
) pi ON p.product_id = pi.product_id 
LEFT JOIN sizes s ON oi.size_id = s.size_id 
WHERE o.order_id = ? AND o.user_id = ?
";


if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('ii', $order_id, $user_id);
    $stmt->execute();
    $order_details_result = $stmt->get_result();
    $order_details = $order_details_result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    // Output the error if prepare fails
    echo "Error preparing statement: " . $conn->error;
}
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
                            <li class="active"><a href="?pgae=order_detail">Order Details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .shopping-cart.section {
    padding: 50px 0;
}

h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.table.shopping-summery {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
}

.table.shopping-summery thead {
    background-color: #f3f3f3;
}

.table.shopping-summery thead th {
    padding: 15px;
    font-size: 16px;
    font-weight: 600;
    color: #000;
    border: 1px solid #ddd;
}

.table.shopping-summery tbody td {
    padding: 15px;
    font-size: 14px;
    border: 1px solid #ddd;
    vertical-align: middle;
}

.table.shopping-summery tbody td.image img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.total-amount {
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
}

.total-amount .right {
    text-align: right;
}

.total-amount .right h3 {
    font-size: 20px;
    color: #333;
    margin-bottom: 20px;
}

.total-amount .right ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.total-amount .right ul li {
    font-size: 16px;
    color: #666;
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}

.total-amount .right ul li:last-child {
    border-bottom: none;
    font-weight: 600;
}

.total-amount .right ul li span {
    color: #333;
}
    </style>
    <div class="shopping-cart section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Order Details -->
                <h2>Order Details</h2>
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-heading">
                            <th style="color: #000000">PRODUCT</th>
                            <th style="color: #000000">NAME</th>
                            <th class="text-center" style="color: #000000">SIZE</th>
                            <th class="text-center" style="color: #000000">QUANTITY</th>
                            <th class="text-center" style="color: #000000">UNIT PRICE</th>
                            <th class="text-center" style="color: #000000">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_details as $item) : ?>
                            <tr>
                                <td class="image"><img src="<?php echo htmlspecialchars($item['image_url'] ? 'images/' . $item['image_url'] : 'https://via.placeholder.com/100x100'); ?>" alt="#"></td>
                                <td class="product-des"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($item['size'] ? $item['size'] : 'N/A'); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td class="text-center">$<?php echo number_format($item['price'], 2); ?></td>
                                <td class="text-center">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!--/ End Order Details -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Total Amount -->
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12"></div>
                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <h3>Order Summary</h3>
                                <ul>
                                    <li>Total: $<?php echo number_format($order_details[0]['total'], 2); ?></li>
                                    <li>Status: <?php echo htmlspecialchars(ucfirst($order_details[0]['status'])); ?></li>
                                    <li>Date: <?php echo htmlspecialchars(date('d M Y', strtotime($order_details[0]['created_at']))); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total Amount -->
            </div>
        </div>
    </div>
</div>
    