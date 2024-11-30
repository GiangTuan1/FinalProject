<?php
session_start();
require 'config.php'; // Assuming config.php contains the database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    if (empty($username) || empty($full_name) || empty($email) || empty($phone_number) || empty($address)) {
        echo "All fields are required.";
        exit();
    }

    // Fetch user data to check for changes
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Update user data if there are changes
    if ($user['username'] != $username || $user['full_name'] != $full_name || $user['email'] != $email || $user['phone_number'] != $phone_number || $user['address'] != $address) {
        $query = "UPDATE users SET username = ?, full_name = ?, email = ?, phone_number = ?, address = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssi', $username, $full_name, $email, $phone_number, $address, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    // Fetch cart items
    $query = "SELECT ci.*, p.product_name, p.price, ps.size_id, ps.quantity as stock_quantity
              FROM cart_items ci
              JOIN products p ON ci.product_id = p.product_id
              JOIN product_sizes ps ON ci.product_id = ps.product_id AND ci.size_id = ps.size_id
              WHERE ci.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();
    $cart_items = $cart_result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Calculate total
    $subtotal = 0;
    foreach ($cart_items as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $total = $subtotal;

    // Insert order
    $query = "INSERT INTO orders (user_id, total, status, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $status = 'pending';
    $stmt->bind_param('ids', $user_id, $total, $status);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Insert order items and update product sizes
    foreach ($cart_items as $item) {
        $query = "INSERT INTO order_items (order_id, product_id, size_id, quantity, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiidi', $order_id, $item['product_id'], $item['size_id'], $item['quantity'], $item['price']);
        $stmt->execute();
        $stmt->close();

        // Check current stock quantity
        $query = "SELECT quantity FROM product_sizes WHERE product_id = ? AND size_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $item['product_id'], $item['size_id']);
        $stmt->execute();
        $stmt->bind_result($current_quantity);
        $stmt->fetch();
        $stmt->close();

        // Calculate new quantity
        $new_quantity = $current_quantity - $item['quantity'];

        // Delete or update product size based on new quantity
        if ($new_quantity <= 0) {
            $query = "DELETE FROM product_sizes WHERE product_id = ? AND size_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $item['product_id'], $item['size_id']);
            $stmt->execute();
            $stmt->close();
        } else {
            $query = "UPDATE product_sizes SET quantity = ? WHERE product_id = ? AND size_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('iii', $new_quantity, $item['product_id'], $item['size_id']);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Clear cart
    $query = "DELETE FROM cart_items WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to order confirmation page
    header('Location: index.php?page=order_details&&order_id=' . $order_id);
    exit();
} else {
    header('Location: index.php?page=checkout');
    exit();
}
?>
