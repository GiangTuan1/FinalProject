<?php
session_start();
require 'config.php'; // Assuming config.php contains the database connection

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    die("New passwords do not match.");
}

$query = "SELECT password FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!password_verify($current_password, $user['password'])) {
    die("Current password is incorrect.");
}

$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
$query = "UPDATE users SET password = ? WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $new_password_hash, $user_id);

if ($stmt->execute()) {
    echo "Password changed successfully.";
} else {
    echo "Error changing password.";
}

$stmt->close();
?>
