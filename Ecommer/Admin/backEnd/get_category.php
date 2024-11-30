<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($categoryId) {
        $sql = "SELECT category_id, category_name FROM categories WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        $category = $result->fetch_assoc();

        $stmt->close();
        echo json_encode($category);
    } else {
        echo json_encode(['error' => 'Category not found']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
