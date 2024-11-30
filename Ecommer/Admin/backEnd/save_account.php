<?php
// Include database connection
require_once '../../config.php';

// Initialize response array
$response = ['success' => false, 'error' => ''];

// Handle file upload for avatar
$avatar = '';
if (isset($_FILES['avatarFile']) && $_FILES['avatarFile']['error'] === UPLOAD_ERR_OK) {
    $avatarTmpName = $_FILES['avatarFile']['tmp_name'];
    $avatarName = basename($_FILES['avatarFile']['name']);
    $avatarPath = '../../images/' . $avatarName;

    if (move_uploaded_file($avatarTmpName, $avatarPath)) {
        // File uploaded successfully
        $avatar = $avatarName;
    } else {
        // Handle error
        $avatar = ''; // Set default avatar or empty if upload fails
    }
}

// Fetch form data
$userId = $_POST['userId'] ?? '';
$username = $_POST['username'] ?? '';
$fullName = $_POST['fullName'] ?? '';
$email = $_POST['email'] ?? '';
$phoneNumber = $_POST['phoneNumber'] ?? '';
$address = $_POST['address'] ?? '';
$roleId = $_POST['role'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Validate input
if ($password !== $confirmPassword) {
    $response['error'] = 'Passwords do not match';
    echo json_encode($response);
    exit();
}

// Check if role exists
$roleSql = "SELECT role_id FROM roles WHERE role_id = ?";
$stmtRoleCheck = $conn->prepare($roleSql);
$stmtRoleCheck->bind_param('i', $roleId);
$stmtRoleCheck->execute();
$stmtRoleCheck->store_result();

if ($stmtRoleCheck->num_rows === 0) {
    $response['error'] = 'Invalid role ID';
    $stmtRoleCheck->close();
    echo json_encode($response);
    exit();
}
$stmtRoleCheck->close();

// Check if user exists
if (!empty($userId)) {
    // Update existing user
    $sql = "UPDATE users SET username = ?, full_name = ?, email = ?, phone_number = ?, address = ?, avatar = ?" . 
           (!empty($password) ? ", password = ?" : "") . " WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!empty($password)) {
        // Hash password if provided
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param('sssssssi', $username, $fullName, $email, $phoneNumber, $address, $avatar, $hashedPassword, $userId);
    } else {
        $stmt->bind_param('ssssssi', $username, $fullName, $email, $phoneNumber, $address, $avatar, $userId);
    }
    
    if ($stmt->execute()) {
        // Delete existing role in user_roles
        $stmtDeleteRole = $conn->prepare("DELETE FROM user_roles WHERE user_id = ?");
        $stmtDeleteRole->bind_param('i', $userId);
        if ($stmtDeleteRole->execute()) {
            // Insert new role into user_roles
            $stmtRole = $conn->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
            $stmtRole->bind_param('ii', $userId, $roleId);
            if ($stmtRole->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = 'Failed to insert user role: ' . $stmtRole->error;
            }
            $stmtRole->close();
        } else {
            $response['error'] = 'Failed to delete old user role: ' . $stmtDeleteRole->error;
        }
        $stmtDeleteRole->close();
    } else {
        $response['error'] = 'Failed to update user: ' . $stmt->error;
    }
    $stmt->close();
} else {
    // Insert new user
    $sql = "INSERT INTO users (username, full_name, email, phone_number, address, avatar, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Hash password if provided
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bind_param('sssssss', $username, $fullName, $email, $phoneNumber, $address, $avatar, $hashedPassword);
    
    if ($stmt->execute()) {
        $newUserId = $stmt->insert_id;
        // Insert role into user_roles
        $stmtRole = $conn->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
        $stmtRole->bind_param('ii', $newUserId, $roleId);
        if ($stmtRole->execute()) {
            $response['success'] = true;
        } else {
            $response['error'] = 'Failed to insert user role: ' . $stmtRole->error;
        }
        $stmtRole->close();
    } else {
        $response['error'] = 'Failed to save new user: ' . $stmt->error;
    }
    $stmt->close();
}

// Close connection
$conn->close();

// Return JSON response
echo json_encode($response);
?>
