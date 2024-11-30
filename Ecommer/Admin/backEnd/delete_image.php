<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageId = isset($_POST['imageId']) ? (int)$_POST['imageId'] : 0;

    if ($imageId) {
        $deleteImageSql = "DELETE FROM product_images WHERE image_id = ?";
        $stmt = $conn->prepare($deleteImageSql);
        $stmt->bind_param("i", $imageId);
        if ($stmt->execute()) {
            $stmt->close();
            echo json_encode(['success' => true]);
        } else {
            $stmt->close();
            echo json_encode(['success' => false, 'error' => 'Failed to delete image']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid image ID']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
