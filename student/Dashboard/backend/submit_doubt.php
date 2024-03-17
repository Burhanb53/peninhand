<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../Pages/sign-in.php"); // Change to your login page
    exit();
}

require_once '../../../includes/config.php'; // Include the database configuration file
$redirectUrl = "../Pages/ask_doubt.php"; // Default redirect URL
// Prepare and bind the SQL statement
$stmt = $dbh->prepare("INSERT INTO doubt (doubt_id, user_id, doubt_category, doubt, doubt_file) VALUES (?, ?, ?, ?, ?)");
$stmt->bindParam(1, $doubt_id);
$stmt->bindParam(2, $_SESSION['user_id']);
$stmt->bindParam(3, $_POST['doubt_category']);

// Bind the doubt parameter
if (!empty($_POST['doubt'])) {
    $stmt->bindParam(4, $_POST['doubt']);
} else {
    $doubt = null;
    $stmt->bindParam(4, $doubt, PDO::PARAM_NULL);
}

// Generate a random 6-digit doubt_id
$doubt_id = mt_rand(100000, 999999);

// Initialize doubt_file variable
$doubt_file_name = null;

// File upload handling
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];

    // Define the target directory
    $target_dir = "../uploads/doubt/"; // Change to your desired directory

    // Generate a unique file name to avoid overwriting existing files
    $unique_id = uniqid();
    $target_file = $target_dir . $unique_id . '_' . basename($file_name);

    // Move uploaded file to desired directory
    if (move_uploaded_file($file_tmp, $target_file)) {
        $doubt_file_name = $unique_id . '_' . basename($file_name); // Set doubt_file_name to the uploaded file name
    }
}

// Bind the doubt_file parameter
$stmt->bindParam(5, $doubt_file_name);

// Execute the statement
if ($stmt->execute()) {
    $message = "Doubt submitted successfully.";
    $_SESSION['message'] = "Doubt submitted successfully.";
} else {
    $message = "Error occurred while submitting doubt. Please try again.";
    $_SESSION['message'] = "Error occurred while submitting doubt. Please try again.";
}

// Close statement and connection
$stmt = null;
$dbh = null;

// Redirect with error message
header("Location: $redirectUrl");
exit();
?>