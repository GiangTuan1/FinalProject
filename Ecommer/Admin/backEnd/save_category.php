<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = isset($_POST['categoryId']) ? (int)$_POST['categoryId'] : 0;
    $categoryName = isset($_POST['categoryName']) ? $_POST['categoryName'] : '';

    if ($categoryId) {
        // Update category
        $sql = "UPDATE categories SET category_name = ? WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $categoryName, $categoryId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new category
        $sql = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['success' => true]);
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
