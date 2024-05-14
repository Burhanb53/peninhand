<?php
// Check if the request is a GET request
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Retrieve the note ID from the request query parameters
    $noteId = isset($_GET["noteId"]) ? $_GET["noteId"] : null;

    // Validate the note ID
    if (!$noteId) {
        http_response_code(400); // Bad Request
        echo json_encode(array("error" => "Missing note ID."));
        exit();
    }

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "peninhand";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("error" => "Database connection failed: " . $conn->connect_error));
        exit();
    }

    // Prepare SQL statement for deletion
    $sql = "DELETE FROM notes WHERE id = ?";

    // Prepare and bind parameter
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $noteId);

    // Execute the delete statement
    if ($stmt->execute()) {
        // Deletion successful
        echo '<script>window.history.go(-1);</script>';

        exit();
    } else {
        // Deletion failed
        http_response_code(500); // Internal Server Error
        echo json_encode(array("error" => "Error deleting note: " . $stmt->error));
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Invalid request method."));
}
?>
