<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roleId = isset($_POST['roleId']) ? (int)$_POST['roleId'] : 0;
    $roleName = isset($_POST['roleName']) ? $_POST['roleName'] : '';

    if ($roleId) {
        // Update role
        $sql = "UPDATE roles SET role_name = ? WHERE role_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $roleName, $roleId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new role
        $sql = "INSERT INTO roles (role_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $roleName);
        $stmt->execute();
        $stmt->close();
    }

    echo json_encode(['success' => true]);
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
