<?php
session_start();
include ('../../../includes/config.php');

// Check if doubt_id is set in the session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doubt_id = $_POST['doubt_id'];

    // Get form data
    $solution = $_POST['solution'] ?? null;
    $fileUpload = $_FILES['fileUpload']['name'] ?? null;
    $videoLink = $_POST['videoLink'] ?? null;
    $joinCode = $_POST['joinCode'] ?? null;

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
                      SET answer = COALESCE(:solution, answer),
                          " . ($uploadedFileName ? "answer_file = :fileUpload," : "") . "
                          answer_created_at = NOW(),
                          student_view = 0
                      WHERE doubt_id = :doubt_id";
    $stmt_doubt = $dbh->prepare($sql_doubt);
    $stmt_doubt->bindParam(':doubt_id', $doubt_id);
    $stmt_doubt->bindParam(':solution', $solution);
    if ($uploadedFileName) {
        $stmt_doubt->bindParam(':fileUpload', $uploadedFileName);
    }
    $stmt_doubt->execute();
if($videoLink!='null' && $joinCode!='null'){
    // Update or insert data into the video_call table
    $stmt_check = $dbh->prepare("SELECT COUNT(*) FROM video_call WHERE doubt_id = :doubt_id");
    $stmt_check->bindParam(':doubt_id', $doubt_id);
    $stmt_check->execute();
    $row_count = $stmt_check->fetchColumn();

    if ($row_count > 0) {
        // Row exists, update the existing row
        $sql_video_call = "UPDATE video_call 
                               SET videocall_link = COALESCE(:videoLink, videocall_link), 
                                   join_code = COALESCE(:joinCode, join_code)
                               WHERE doubt_id = :doubt_id";
    } else {
        // Row doesn't exist, insert a new row
        $sql_video_call = "INSERT INTO video_call (doubt_id, videocall_link, join_code)
                               VALUES (:doubt_id, :videoLink, :joinCode)";
    }

    // Prepare and execute the SQL statement for video_call table
    $stmt_video_call = $dbh->prepare($sql_video_call);
    $stmt_video_call->bindParam(':doubt_id', $doubt_id);
    $stmt_video_call->bindParam(':videoLink', $videoLink);
    $stmt_video_call->bindParam(':joinCode', $joinCode);
    $stmt_video_call->execute();
}
    // Redirect back
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    echo "Doubt ID is not set in the session.";
}
?>