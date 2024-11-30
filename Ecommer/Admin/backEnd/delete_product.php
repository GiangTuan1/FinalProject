<?php


include_once("../../config.php");


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $inputData = file_get_contents("php://input");
    error_log("Received input data: " . $inputData);


    parse_str($inputData, $data);
    $productId = isset($data['id']) ? $data['id'] : null;

    if ($productId) {

        $checkProductQuery = "SELECT * FROM products WHERE product_id = ?";
        if ($stmt = $conn->prepare($checkProductQuery)) {
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {

                $checkSizesQuery = "SELECT * FROM product_sizes WHERE product_id = ?";
                if ($stmt = $conn->prepare($checkSizesQuery)) {
                    $stmt->bind_param("i", $productId);
                    $stmt->execute();
                    $sizesResult = $stmt->get_result();
                    
                    if ($sizesResult->num_rows > 0) {

                        $deleteSizesQuery = "DELETE FROM product_sizes WHERE product_id = ?";
                        if ($stmt = $conn->prepare($deleteSizesQuery)) {
                            $stmt->bind_param("i", $productId);
                            $stmt->execute();
                        }
                    }

                    $checkImagesQuery = "SELECT * FROM product_images WHERE product_id = ?";
                    if ($stmt = $conn->prepare($checkImagesQuery)) {
                        $stmt->bind_param("i", $productId);
                        $stmt->execute();
                        $imagesResult = $stmt->get_result();
                        
                        if ($imagesResult->num_rows > 0) {

                            $deleteImagesQuery = "DELETE FROM product_images WHERE product_id = ?";
                            if ($stmt = $conn->prepare($deleteImagesQuery)) {
                                $stmt->bind_param("i", $productId);
                                $stmt->execute();
                            }
                        }
                    } else {

                        header("HTTP/1.1 500 Internal Server Error");
                        header('Content-Type: application/json');
                        echo json_encode(['error' => 'Failed to prepare SQL statement']);
                        exit;
                    }


                    $deleteProductQuery = "DELETE FROM products WHERE product_id = ?";
                    if ($stmt = $conn->prepare($deleteProductQuery)) {
                        $stmt->bind_param("i", $productId);
                        $stmt->execute();
                        if ($stmt->affected_rows > 0) {

                            header('Content-Type: application/json');
                            echo json_encode(['success' => true]);
                        } else {

                            header('Content-Type: application/json');
                            echo json_encode(['success' => false, 'error' => 'Product not found']);
                        }
                    } else {

                        header("HTTP/1.1 500 Internal Server Error");
                        header('Content-Type: application/json');
                        echo json_encode(['error' => 'Failed to prepare SQL statement']);
                    }
                } else {

                    header("HTTP/1.1 500 Internal Server Error");
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Failed to prepare SQL statement']);
                }

                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Product not found']);
            }
            

            $stmt->close();
        } else {

            header("HTTP/1.1 500 Internal Server Error");
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to prepare SQL statement']);
        }
    } else {

        header("HTTP/1.1 400 Bad Request");
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No product ID provided']);
    }
} else {

    header("HTTP/1.1 405 Method Not Allowed");
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method Not Allowed']);
}
