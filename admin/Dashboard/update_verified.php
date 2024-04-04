<?php
session_start();
error_reporting(0);
include ('includes/config.php');

// Check if the ID and status parameters are provided in the URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    // Sanitize the input
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $status = filter_var($_GET['status'], FILTER_SANITIZE_NUMBER_INT);

    // Update the 'verified' column in the database
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=peninhand', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('UPDATE teacher SET verified = :status WHERE id = :id');
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // Redirect to an error page or handle the case when parameters are missing
    header('Location: error.php');
    exit();
}
?>