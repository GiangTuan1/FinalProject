<?php
include 'config.php';
session_start();

$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    // Ensuring safety against SQL Injection
    $search = '%' . $conn->real_escape_string($search) . '%';

    // Query the product search database
    $sql = "SELECT p.product_id, p.product_name, p.price, pi.image_url 
            FROM products p 
            JOIN product_images pi ON p.product_id = pi.product_id 
            WHERE p.product_name LIKE ? 
            GROUP BY p.product_id";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $search);
    $stmt->execute();
    $result = $stmt->get_result();

    // Show search results
    echo '<div class="search-results">';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="search-item">';
            echo '<img src="images/' . htmlspecialchars($row['image_url']) . '" alt="Product Image">';
            echo '<h3><a href="product.php?product_id=' . $row['product_id'] . '">' . htmlspecialchars($row['product_name']) . '</a></h3>';
            echo '<p>$' . number_format($row['price'], 2) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found.</p>';
    }
    echo '</div>';

    $stmt->close();
} else {
    echo '<p>Please enter a search term.</p>';
}

$conn->close();
?>
