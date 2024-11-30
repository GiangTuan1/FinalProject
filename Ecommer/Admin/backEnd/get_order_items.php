<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($orderId) {
        $sql = "
            SELECT oi.order_item_id, oi.order_id, oi.product_id, p.product_name, oi.size_id, s.size, oi.quantity, oi.price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.product_id
            JOIN sizes s ON oi.size_id = s.size_id
            WHERE oi.order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orderItems = [];
        while ($row = $result->fetch_assoc()) {
            $orderItems[] = [
                'order_item_id' => $row['order_item_id'],
                'order_id' => $row['order_id'],
                'product_id' => $row['product_id'],
                'product_name' => $row['product_name'],
                'size_id' => $row['size_id'],
                'size' => $row['size'],
                'quantity' => $row['quantity'],
                'price' => $row['price']
            ];
        }
        
        $stmt->close();
        echo json_encode($orderItems);
    } else {
        echo json_encode(['error' => 'Order not found']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
