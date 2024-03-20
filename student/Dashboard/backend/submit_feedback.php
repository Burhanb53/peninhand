<?php
// Include database connection
session_start();
include ('../../../includes/config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $doubt_id = $_POST['doubt_id'];
    $teacher_id = $_POST['teacher_id'];
    $satisfaction_level = $_POST['satisfied'];
    $feedback_text = $_POST['feedback'];

    // Prepare and execute SQL query to insert feedback into the database
    $sql_feedback = "INSERT INTO feedback (doubt_id, teacher_id, satisfaction_level, feedback_text) VALUES (:doubt_id, :teacher_id, :satisfaction_level, :feedback_text)";
    $stmt_feedback = $dbh->prepare($sql_feedback);
    $stmt_feedback->bindParam(':doubt_id', $doubt_id);
    $stmt_feedback->bindParam(':teacher_id', $teacher_id);
    $stmt_feedback->bindParam(':satisfaction_level', $satisfaction_level);
    $stmt_feedback->bindParam(':feedback_text', $feedback_text);
    $stmt_feedback->execute();
    

    // Prepare and execute SQL query to update the doubt table
    $sql_doubt = "UPDATE doubt SET teacher_view = 2, student_view = 2, feedback = 1 WHERE doubt_id = :doubt_id";
    $stmt_doubt = $dbh->prepare($sql_doubt);
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->execute();
    
    
    // Redirect to previous page using JavaScript
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>
