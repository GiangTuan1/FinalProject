<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['productId']) ? (int)$_POST['productId'] : 0;
    $productName = isset($_POST['productName']) ? $_POST['productName'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $categoryId = isset($_POST['category']) ? (int)$_POST['category'] : 0;
    $sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];

    $conn->begin_transaction();

    try {
        if ($productId) {
            $updateProductSql = "
                UPDATE products 
                SET product_name = ?, description = ?, price = ?, category_id = ?
                WHERE product_id = ?";
            $stmt = $conn->prepare($updateProductSql);
            $stmt->bind_param("ssdis", $productName, $description, $price, $categoryId, $productId);
            $stmt->execute();
            $stmt->close();
        } else {
            $insertProductSql = "
                INSERT INTO products (product_name, description, price, category_id)
                VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertProductSql);
            $stmt->bind_param("ssdi", $productName, $description, $price, $categoryId);
            $stmt->execute();
            $productId = $stmt->insert_id;
            $stmt->close();
        }

        $deleteProductSizesSql = "DELETE FROM product_sizes WHERE product_id = ?";
        $stmt = $conn->prepare($deleteProductSizesSql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();

        $insertProductSizesSql = "INSERT INTO product_sizes (product_id, size_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertProductSizesSql);

        foreach ($sizes as $sizeId => $quantity) {
            $stmt->bind_param("iii", $productId, $sizeId, $quantity);
            $stmt->execute();
        }
        $stmt->close();

        if (isset($_FILES['images'])) {
            $imageDir = '../../images/';
            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                $fileName = basename($_FILES['images']['name'][$key]);
                $filePath =  $imageDir . $fileName;
                if (move_uploaded_file($tmpName, $filePath)) {
                    $insertImageSql = "INSERT INTO product_images (product_id, image_url) VALUES (?, ?)";
                    $stmt = $conn->prepare($insertImageSql);
                    $stmt->bind_param("is", $productId, $fileName);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
