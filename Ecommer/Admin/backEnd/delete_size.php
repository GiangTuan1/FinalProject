<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $sizeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($sizeId) {
        // Delete size
        $sql = "DELETE FROM sizes WHERE size_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sizeId);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Size not found']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
