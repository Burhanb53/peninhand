<?php
// Include your database connection file or establish a database connection here
// Include config.php or establish database connection if not already included
include('includes/config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user_id is set in the POST data
    if (isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];

        // Update the 'verified' column in the database for the specified user_id
        $sql = "UPDATE  subscription_user SET verified = 1 WHERE id = :userId";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Execute the update query
        if ($stmt->execute()) {
            // Verification successful, redirect back to the user list page
            header("Location: manage_student.php");
            exit();
        } else {
            // Error occurred during the update
            echo "Error updating verification status.";
        }
    } else {
        // user_id not set in the POST data
        echo "Invalid request. Missing user_id.";
    }
} else {
    // Redirect to an error page or handle unauthorized access
    header("Location: error.php");
    exit();
}
?>
