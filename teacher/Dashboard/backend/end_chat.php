<?php
session_start();
include ('../../../includes/config.php');

// Check if doubt_id is provided in the request
if(isset($_GET['doubt_id'])) {
    // Get the doubt_id from the request
    $doubt_id = $_GET['doubt_id'];


    try {
        // Prepare the SQL statement to update doubt_submit to 1
        $sql = "UPDATE doubt SET doubt_submit = 1 , student_view = 0 WHERE doubt_id = :doubt_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':doubt_id', $doubt_id);
        
        // Execute the update query
        $stmt->execute();

        // Redirect back to the previous page using JavaScript
        echo '<script>window.history.back();</script>';
        exit();
    } catch(PDOException $e) {
        // Handle any errors that occur during the update process
        echo "Error updating doubt submit: " . $e->getMessage();
    }
} else {
    // If doubt_id is not provided in the request, display an error message or redirect to an error page
    echo "Error: doubt_id not provided";
}
?>
