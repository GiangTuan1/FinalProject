<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sizeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($sizeId) {
        $sql = "SELECT size_id, size FROM sizes WHERE size_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sizeId);
        $stmt->execute();
        $result = $stmt->get_result();

        $size = $result->fetch_assoc();

        $stmt->close();
        echo json_encode($size);
    } else {
        echo json_encode(['error' => 'Size not found']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
