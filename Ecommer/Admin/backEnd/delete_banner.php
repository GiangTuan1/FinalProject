<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $bannerId = isset($_DELETE['id']) ? (int)$_DELETE['id'] : 0;

    if ($bannerId) {
        $conn->begin_transaction();

        try {
            $checkBannerSql = "SELECT COUNT(*) FROM banners WHERE banner_id = ?";
            $stmt = $conn->prepare($checkBannerSql);
            $stmt->bind_param("i", $bannerId);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {

                $deleteBannerSql = "DELETE FROM banners WHERE banner_id = ?";
                $stmt = $conn->prepare($deleteBannerSql);
                $stmt->bind_param("i", $bannerId);
                $stmt->execute();
                $stmt->close();
                
                $conn->commit();
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Banner not found.']);
                $conn->rollback();
            }
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No banner ID provided']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
