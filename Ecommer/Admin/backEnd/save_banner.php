<?php
include_once("../../config.php");

// Check if the user has access rights

$bannerId = $_POST['bannerId'] ?? null;
$title = $_POST['title'];
$description = $_POST['description'];
$status = $_POST['status'];
$image = $_FILES['image'] ?? null;
$imageUrl = '';

if ($image && $image['error'] === 0) {
    $imagePath = '../../images/';
    $imageName = basename($image['name']);
    $imageUrl = $imagePath . $imageName;

    if (!move_uploaded_file($image['tmp_name'], $imageUrl)) {
        echo json_encode(['success' => false, 'error' => 'Failed to upload image']);
        exit();
    }
}

// If status is active, set all other banners to inactive
if ($status === 'active') {
    $sqlUpdateAll = "UPDATE banners SET status = 'inactive' WHERE status = 'active'";
    if (!$conn->query($sqlUpdateAll)) {
        echo json_encode(['success' => false, 'error' => 'Failed to update banners']);
        exit();
    }
}

if ($bannerId) {
    // Update existing banner
    $sql = "UPDATE banners SET title = ?, description = ?, status = ?";
    if ($imageUrl) {
        $sql .= ", image_url = ?";
    }
    $sql .= " WHERE banner_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        if ($imageUrl) {
            $stmt->bind_param('ssssi', $title, $description, $status, $imageName, $bannerId);
        } else {
            $stmt->bind_param('sssi', $title, $description, $status, $bannerId);
        }
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update banner']);
    }
} else {
    // Add new banner
    $sql = "INSERT INTO banners (title, description, status, image_url) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssss', $title, $description, $status, $imageName);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to add banner']);
    }
}
?>
