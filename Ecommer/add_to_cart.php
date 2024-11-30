<?php
session_start();
include 'config.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
// Assuming user ID is 1 for demonstration. Replace with actual user ID from session or authentication.

    // Validate and sanitize inputs
    $product_id = intval($product_id);
    $quantity = intval($quantity);
    $size = $conn->real_escape_string($size);

    // Check if the item already exists in the cart
    $sql_check = "SELECT * FROM cart_items WHERE user_id = ? AND product_id = ? AND size_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("iii", $user_id, $product_id, $size);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Update quantity if item already exists
        $sql_update = "UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ? AND size_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("iiii", $quantity, $user_id, $product_id, $size);
        $stmt_update->execute();
    } else {
        // Insert new item into cart
        $sql_product = "SELECT price FROM products WHERE product_id = ?";
        $stmt_product = $conn->prepare($sql_product);
        $stmt_product->bind_param("i", $product_id);
        $stmt_product->execute();
        $result_product = $stmt_product->get_result();
        $product = $result_product->fetch_assoc();
        $price = $product['price'];

        $sql_insert = "INSERT INTO cart_items (user_id, product_id, size_id, quantity, price) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iiids", $user_id, $product_id, $size, $quantity, $price);
        $stmt_insert->execute();
    }

    echo json_encode(['status' => 'success']);
}
?>
