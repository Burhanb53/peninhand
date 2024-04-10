<?php
// Include your database connection file or establish a database connection here
// Include config.php or establish database connection if not already included
include('../includes/config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the teacher_id is set in the POST data
    if (isset($_POST['teacher_id'])) {
        $teacherId = $_POST['teacher_id'];

        // Update the 'verified' column in the database for the specified teacher_id
        $sql = "UPDATE teacher SET verified = 1 WHERE id = :teacherId";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);

        // Execute the update query
        if ($stmt->execute()) {
            // Verification successful, redirect back to the teacher list page
            header("Location: ../manage_teacher.php");
            exit();
        } else {
            // Error occurred during the update
            echo "Error updating verification status.";
        }
    } else {
        // teacher_id not set in the POST data
        echo "Invalid request. Missing teacher_id.";
    }
} else {
    // Redirect to an error page or handle unauthorized access
    header("Location: error.php");
    exit();
}
?>
