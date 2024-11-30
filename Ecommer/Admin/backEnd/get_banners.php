<?php
include_once("../../config.php");

if (isset($_GET['id'])) {
    $bannerId = (int)$_GET['id'];

    $sql = "SELECT banner_id, title, description, image_url, status FROM banners WHERE banner_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bannerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $banner = $result->fetch_assoc();
        echo json_encode($banner);
    } else {
        echo json_encode(['error' => 'Banner not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No banner ID provided']);
}
?>
