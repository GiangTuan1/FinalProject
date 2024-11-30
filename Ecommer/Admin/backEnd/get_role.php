<?php
include_once("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $roleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($roleId) {
        $sql = "SELECT role_id, role_name FROM roles WHERE role_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $roleId);
        $stmt->execute();
        $result = $stmt->get_result();

        $role = $result->fetch_assoc();

        $stmt->close();
        echo json_encode($role);
    } else {
        echo json_encode(['error' => 'Role not found']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
