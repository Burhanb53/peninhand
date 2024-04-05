<?php
session_start();
error_reporting(0);
include ('includes/config.php');

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user data from the database based on the ID
    $sql = "SELECT * FROM  subscription_user WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user data is found
    if ($userData) {
        // Toggle the active status onclick
        $activeStatus = $userData['active'] == 1 ? 0 : 1;
        $updateSql = "UPDATE user SET active = :active WHERE id = :id";
        $updateStmt = $dbh->prepare($updateSql);
        $updateStmt->bindParam(':active', $activeStatus);
        $updateStmt->bindParam(':id', $userId);
        $updateStmt->execute();

        // Redirect back to view_user.php after updating
        header("Location: manage_student.php?id=$userId");
        exit();
    } else {
        echo "user not found.";
    }
} else {
    echo "user ID not provided.";
}
?>
