<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sizeId = isset($_POST['sizeId']) ? (int)$_POST['sizeId'] : 0;
    $sizeName = isset($_POST['sizeName']) ? $_POST['sizeName'] : '';

    if ($sizeId) {
        // Update size
        $sql = "UPDATE sizes SET size = ? WHERE size_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $sizeName, $sizeId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new size
        $sql = "INSERT INTO sizes (size) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $sizeName);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['success' => true]);
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
