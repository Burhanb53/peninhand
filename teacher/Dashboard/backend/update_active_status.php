<?php
session_start();
$teacher_id = $_SESSION['user_id'];

// Include your database connection file
include('../../../includes/config.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new active status from the request body
    $newActive = $_POST['toggle'];

    // Validate and sanitize the input if necessary

    // Perform the update query
    $stmt = $dbh->prepare(" UPDATE teacher SET active = :active WHERE teacher_id = :teacher_id ");
    $stmt->bindParam(':active', $newActive);
    $stmt->bindParam(':teacher_id', $teacher_id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        // Return success response
        echo json_encode(['status' => 'success']);
        exit;
    } else {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => 'Failed to update active status']);
        exit;
    }
} else {
    // Return error response if request method is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}
?>
