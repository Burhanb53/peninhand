<?php
session_start();
error_reporting(0);

// Database connection parameters
$host = 'localhost';
$dbname = 'peninhand';
$username = 'root';
$password = '';

try {
    // Create a new PDO instance for database connection with username and password
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO attributes if needed
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if doubt_id and teacher_id are provided in the URL
    if (isset($_GET['doubt_id']) && isset($_GET['teacher_id'])) {
        // Sanitize and store the parameters
        $doubt_id = htmlspecialchars($_GET['doubt_id']);
        $teacher_id = htmlspecialchars($_GET['teacher_id']);

        // Prepare and execute the SQL query to update the teacher_id for the specified doubt_id
        $stmt = $pdo->prepare("UPDATE doubt SET teacher_id = :teacher_id WHERE id = :doubt_id");
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(':doubt_id', $doubt_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect back to the previous page or a success page
        header('Location: assign.php');
        exit();
    } else {
        // Redirect to an error page if doubt_id or teacher_id is not provided
        header('Location: error_page.php');
        exit();
    }
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo "Error: " . $e->getMessage();
    die();
}
?>
