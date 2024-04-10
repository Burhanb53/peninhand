<?php
session_start();
error_reporting(0);
include ('../includes/config.php');

// Check if teacher ID is provided in the URL
if (isset($_GET['id'])) {
    $teacherId = $_GET['id'];

    // Fetch teacher data from the database based on the ID
    $sql = "SELECT * FROM teacher WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $teacherId);
    $stmt->execute();
    $teacherData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if teacher data is found
    if ($teacherData) {
        // Toggle the active status onclick
        $activeStatus = $teacherData['active'] == 1 ? 0 : 1;
        $updateSql = "UPDATE teacher SET active = :active WHERE id = :id";
        $updateStmt = $dbh->prepare($updateSql);
        $updateStmt->bindParam(':active', $activeStatus);
        $updateStmt->bindParam(':id', $teacherId);
        $updateStmt->execute();

        // Redirect back to view_teacher.php after updating
        header("Location: ../manage_teacher.php?id=$teacherId");
        exit();
    } else {
        echo "Teacher not found.";
    }
} else {
    echo "Teacher ID not provided.";
}
?>
