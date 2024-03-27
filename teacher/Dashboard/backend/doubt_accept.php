<?php
session_start();
include('../../../includes/config.php');
// Assuming $dbh is your PDO database connection object
if(isset($_GET['doubt_id'])){
    $doubt_id = $_GET['doubt_id'];

    $sql = "UPDATE doubt SET accepted = 1 WHERE doubt_id = :doubt_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':doubt_id', $doubt_id);

    if ($stmt->execute()) {
        // Redirect to a success page or perform any other action
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit(); // Stop further execution
    } else {
        // Redirect to an error page or perform any other action
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit(); // Stop further execution
    }
}
?>
