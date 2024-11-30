<?php
include_once("../../config.php");
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $accountId = isset($data['id']) ? $data['id'] : null;
    if ($accountId) {

        $conn->begin_transaction();

        try {
            $checkOrdersQuery = "SELECT order_id FROM orders WHERE user_id = ?";
            $stmt = $conn->prepare($checkOrdersQuery);
            $stmt->bind_param("i", $accountId);
            $stmt->execute();
            $result = $stmt->get_result();
            $orderIds = [];

            while ($row = $result->fetch_assoc()) {
                $orderIds[] = $row['order_id'];
            }
            $stmt->close();

            if (!empty($orderIds)) {
                $deleteOrderItemsQuery = "DELETE FROM order_items WHERE order_id IN (" . implode(',', array_fill(0, count($orderIds), '?')) . ")";
                $stmt = $conn->prepare($deleteOrderItemsQuery);
                $stmt->bind_param(str_repeat("i", count($orderIds)), ...$orderIds);
                $stmt->execute();
                $stmt->close();


                $deleteOrdersQuery = "DELETE FROM orders WHERE user_id = ?";
                $stmt = $conn->prepare($deleteOrdersQuery);
                $stmt->bind_param("i", $accountId);
                $stmt->execute();
                $stmt->close();
            }

            $deleteCartItemsQuery = "DELETE FROM cart_items WHERE user_id = ?";
            $stmt = $conn->prepare($deleteCartItemsQuery);
            $stmt->bind_param("i", $accountId);
            $stmt->execute();
            $stmt->close();


            $deleteRolesQuery = "DELETE FROM user_roles WHERE user_id = ?";
            $stmt = $conn->prepare($deleteRolesQuery);
            $stmt->bind_param("i", $accountId);
            $stmt->execute();
            $stmt->close();


            $deleteAccountQuery = "DELETE FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($deleteAccountQuery);
            $stmt->bind_param("i", $accountId);

            if ($stmt->execute()) {

                $conn->commit();
                echo json_encode(['success' => true]);
            } else {

                $conn->rollback();
                echo json_encode(['success' => false, 'error' => $stmt->error]);
            }

            $stmt->close();
        } catch (Exception $e) {

            $conn->rollback();
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {

        echo json_encode(['success' => false, 'error' => 'Account ID is missing']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
