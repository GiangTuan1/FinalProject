<?php
// Connect to database
include_once("../../config.php");

// Check if request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Lấy ID tài khoản từ tham số truy vấn
    $accountId = isset($_GET['id']) ? $_GET['id'] : null;

// Initialize the account array
    $account = [];

    if ($accountId) {
// Query the database to get account information by ID
        $getAccountQuery = "
            SELECT users.user_id, users.username, users.full_name, users.email, users.phone_number, users.address, users.avatar, roles.role_id 
            FROM users 
            JOIN user_roles ON users.user_id = user_roles.user_id 
            JOIN roles ON user_roles.role_id = roles.role_id 
            WHERE users.user_id = ?";
        
        if ($stmt = $conn->prepare($getAccountQuery)) {
            $stmt->bind_param("i", $accountId);
            $stmt->execute();
            $result = $stmt->get_result();
            $account = $result->fetch_assoc();
            $stmt->close();
        } else {
// If the SQL statement cannot be prepared, return an error
            header("HTTP/1.1 500 Internal Server Error");
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to prepare SQL statement']);
            exit();
        }
    }

// Return result as JSON
    header('Content-Type: application/json');
    echo json_encode($account);
} else {
// If the requested method is invalid, return an error
    header("HTTP/1.1 405 Method Not Allowed");
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>
