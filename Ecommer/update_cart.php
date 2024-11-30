<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartItemId = $_POST['cart_item_id'];
    $quantity = $_POST['quantity'];

    $query = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $quantity, $cartItemId, $userId);

    if ($stmt->execute()) {
        $response['success'] = true;
		$response['message'] = 'Item updated successfully';
    } else {
        $response['message'] = 'Failed to update cart item';
    }

    $stmt->close();
    $conn->close();
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
