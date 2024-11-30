<?php
// Database connection
include 'config.php';

// Get data from form
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : ''; // Đổi thành 'phone'
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Check data
if (empty($name) || empty($subject) || empty($email) || empty($message)) {
    $response = [
        'status' => 'error',
        'message' => 'Please complete all information.'
    ];
    echo json_encode($response);
    exit;
}

// Prepare SQL statement to insert data
$sql = "INSERT INTO contacts (name, subject, email, phone, message) VALUES (?, ?, ?, ?, ?)";

// Tạo prepared statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    $response = [
        'status' => 'error',
        'message' => 'Error preparing SQL statement: ' . $conn->error
    ];
    echo json_encode($response);
    exit;
}

// Bind parameters and execute statements
$stmt->bind_param("sssss", $name, $subject, $email, $phone, $message);
if ($stmt->execute()) {
    $response = [
        'status' => 'success',
        'message' => 'Your message has been sent successfully!'
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Error sending message: ' . $stmt->error
    ];
}

// Close connection
$stmt->close();
$conn->close();

echo json_encode($response);
?>
