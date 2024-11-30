<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $productId = (int)$_GET['id'];

    $productSql = "SELECT p.product_id, p.product_name, p.description, p.price, p.category_id
                   FROM products p
                   WHERE p.product_id = ?";
    $stmt = $conn->prepare($productSql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $productResult = $stmt->get_result();
    $productData = $productResult->fetch_assoc();
    $stmt->close();

    if ($productData) {
        $sizesSql = "SELECT size_id, quantity FROM product_sizes WHERE product_id = ?";
        $stmt = $conn->prepare($sizesSql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $sizesResult = $stmt->get_result();
        $sizesData = [];
        while ($sizeRow = $sizesResult->fetch_assoc()) {
            $sizesData[] = $sizeRow;
        }
        $stmt->close();

        $imagesSql = "SELECT image_id, image_url FROM product_images WHERE product_id = ?";
        $stmt = $conn->prepare($imagesSql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $imagesResult = $stmt->get_result();
        $imagesData = [];
        while ($imageRow = $imagesResult->fetch_assoc()) {
            $imagesData[] = $imageRow;
        }
        $stmt->close();

        $productData['sizes'] = $sizesData;
        $productData['images'] = $imagesData;

        echo json_encode($productData);
    } else {
        echo json_encode([]);
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['error' => 'Invalid request']);
}
?>
