<?php
session_start();
include ('../../../includes/config.php');

// Check if doubt_id is set in the session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doubt_id = $_POST['doubt_id'];

    // Get form data
    $doubt = $_POST['doubt'] ?? null;
    $fileUpload = $_FILES['fileUpload']['name'] ?? null;
 

    // Handle file upload
    $uploadedFileName = null;
    if (!empty ($fileUpload)) {
        // Generate a unique filename
        $uniqueFilename = uniqid() . '_' . $fileUpload;
        // Move the uploaded file to the desired directory
        move_uploaded_file($_FILES['fileUpload']['tmp_name'], '../uploads/doubt/' . $uniqueFilename);
        // Store the unique filename in the database
        $uploadedFileName = $uniqueFilename;
    }

    // Update or insert data into the doubt table
    $sql_doubt = "UPDATE doubt 
                      SET doubt = COALESCE(:doubt, doubt),
                          " . ($uploadedFileName ? "doubt_file = :fileUpload," : "") . "
                          doubt_created_at = NOW(),
                          teacher_view = 0
                      WHERE doubt_id = :doubt_id";
    $stmt_doubt = $dbh->prepare($sql_doubt);
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->bindParam(':doubt', $doubt);
    if ($uploadedFileName) {
        $stmt_doubt->bindParam(':fileUpload', $uploadedFileName);
    }
    $stmt_doubt->execute();

    
    // Redirect back
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    echo "Doubt ID is not set in the session.";
}
?>