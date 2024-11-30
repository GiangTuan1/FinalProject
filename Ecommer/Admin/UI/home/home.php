<?php
// Include database connection
include '../../config.php';

// Start session and check if the user is an Admin
session_start();

// Get current year and month
$current_year = date('Y');
$current_month = date('m');

// Fetch total sales and revenue by month
$sales_query = "
SELECT 
    DATE_FORMAT(o.created_at, '%Y-%m') AS month, 
    SUM(oi.quantity) AS total_products_sold, 
    SUM(oi.price * oi.quantity) AS total_revenue
FROM orders o 
JOIN order_items oi ON o.order_id = oi.order_id 
WHERE YEAR(o.created_at) = ? AND MONTH(o.created_at) = ?
GROUP BY month
";

$sales_result = [];
if ($stmt = $conn->prepare($sales_query)) {
    $stmt->bind_param('ii', $current_year, $current_month);
    $stmt->execute();
    $sales_result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Fetch top 5 most purchased products
$top_products_query = "
SELECT 
    p.product_name, 
    SUM(oi.quantity) AS quantity_sold 
FROM order_items oi 
JOIN products p ON oi.product_id = p.product_id 
GROUP BY oi.product_id 
ORDER BY quantity_sold DESC 
LIMIT 5
";

$top_products_result = $conn->query($top_products_query);
?>

<!-- Page content -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Monthly Statistics</h5>
            <h5>Sales and Revenue for <?php echo htmlspecialchars($current_month . '-' . $current_year); ?></h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Products Sold</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sales_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($sales_result['month']); ?></td>
                                <td><?php echo htmlspecialchars($sales_result['total_products_sold']); ?></td>
                                <td>$<?php echo number_format($sales_result['total_revenue'], 2); ?></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No data available for this month.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <h5 class="mt-4">Top 5 Most Purchased Products</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-nowrap mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($top_products_result->num_rows > 0): ?>
                            <?php while ($product = $top_products_result->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['quantity_sold']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No top products data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add custom CSS for table highlighting -->
<style>
    .table {
        background-color: #fff;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .table tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    .table tbody tr:hover {
        background-color: #e9ecef;
    }

    .table th, .table td {
        text-align: center;
        padding: 12px;
    }
</style>
