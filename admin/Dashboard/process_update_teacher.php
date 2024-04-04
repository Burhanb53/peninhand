<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $teacherId = $_POST['teacher_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    // Retrieve other form fields (e.g., gender, tech_stack, experience, etc.)

    // Update teacher details in the database
    $sql = "UPDATE teacher SET name = :name, email = :email, contact = :contact WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    // Bind form data to parameters
    $stmt->bindParam(':id', $teacherId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contact', $contact);
    // Bind other form fields to parameters
    // Example: $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->execute();

    // Redirect to a confirmation page or back to the teacher management page
    header("Location: manage_teacher.php");
    exit();
} else {
    // Redirect to an error page or back to the update form
    header("Location: update_teacher.php");
    exit();
}
?>