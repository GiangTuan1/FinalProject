<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($categoryId) {

        $sql = "DELETE FROM categories WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Category not found']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
