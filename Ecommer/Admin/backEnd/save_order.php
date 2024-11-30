<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = isset($_POST['orderId']) ? (int)$_POST['orderId'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    
    if ($orderId && $status) {
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $orderId);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update order status']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid order ID or status']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
