<?php
session_start();
require 'config.php'; // Assuming config.php contains the database connection

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];
$username = $_POST['username'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$avatar = "";

// Handle avatar upload
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = 'images/';
    $avatar = basename($_FILES['avatar']['name']);
    $upload_file = $upload_dir . $avatar;

    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_file)) {
        die("Error uploading avatar.");
    }
}

// Update profile information
$query = "UPDATE users SET username = ?, full_name = ?, email = ?, phone_number = ? " . ($avatar ? ", avatar = ?" : "") . " WHERE user_id = ?";
$stmt = $conn->prepare($query);
if ($avatar) {
    $stmt->bind_param('sssssi', $username, $full_name, $email, $phone_number, $avatar, $user_id);
} else {
    $stmt->bind_param('ssssi', $username, $full_name, $email, $phone_number, $user_id);
}

if ($stmt->execute()) {
    echo "Profile updated successfully.";
} else {
    echo "Error updating profile.";
}

$stmt->close();
?>
