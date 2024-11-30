<?php
include 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page or send error message
    header('Location: login.php');
    exit();
}

// Check if product_id is present in URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];

    // Check if product_id is valid (anti-SQL Injection)
    if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
        die('Invalid product ID.');
    }

    // Remove item from cart
    $sql = "DELETE FROM cart_items WHERE product_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $user_id);

    if ($stmt->execute()) {
        // Delete successful, check if AJAX request returns JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            echo json_encode(['status' => 'success', 'message' => 'Item removed successfully.']);
        } else {
            // If not AJAX, redirect back to cart page
            header('Location: index.php?page=cart');
            exit();
        }
    } else {
        // Delete failed, error message
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            echo json_encode(['status' => 'error', 'message' => 'Failed to remove item.']);
        } else {
            header('Location: index.php?page=cart&&error=remove');
            exit();
        }
    }

    $stmt->close();
} else {
    // If there is no product_id in the URL, redirect to the cart page
    header('Location: index.php?page=cart');
    exit();
}

$conn->close();
?>
