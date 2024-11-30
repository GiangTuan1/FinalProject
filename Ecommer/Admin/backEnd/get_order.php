<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($orderId) {
        $sql = "SELECT order_id, status FROM orders WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        $order = $result->fetch_assoc();

        $stmt->close();
        echo json_encode($order);
    } else {
        echo json_encode(['error' => 'Order not found']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
