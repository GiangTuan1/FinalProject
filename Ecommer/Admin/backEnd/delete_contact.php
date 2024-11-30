<?php
header('Content-Type: application/json');

include_once("../../config.php");


$contactId = isset($_POST['contactId']) ? intval($_POST['contactId']) : 0;
$sql = "DELETE FROM contacts WHERE contact_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $contactId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
