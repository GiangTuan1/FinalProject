<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $roleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($roleId) {
        // Delete role
        $sql = "DELETE FROM roles WHERE role_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $roleId);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Role not found']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
