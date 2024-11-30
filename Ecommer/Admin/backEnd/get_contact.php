<?php
header('Content-Type: application/json');

include_once("../../config.php");

// Get contact data by ID
$contactId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM contacts WHERE contact_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $contactId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $contact = $result->fetch_assoc();
    echo json_encode($contact);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
