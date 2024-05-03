<?php
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the JSON data from the request body
    $postData = json_decode(file_get_contents("php://input"));

    // Check if the required fields are present
    if (!isset($postData->noteId) || !isset($postData->updatedTitle) || !isset($postData->updatedContent)) {
        http_response_code(400); // Bad Request
        echo json_encode(array("error" => "Missing required fields."));
        exit();
    }

    // Extract data from the request
    $noteId = $postData->noteId;
    $updatedTitle = $postData->updatedTitle;
    $updatedContent = $postData->updatedContent;

    // Perform any necessary validation on the data

    // Assuming you have a database connection established
    // Update the note in the database
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

    // Prepare SQL statement
    $sql = "UPDATE notes SET title=?, content=? WHERE id=?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $updatedTitle, $updatedContent, $noteId);

    // Execute the update statement
    if ($stmt->execute()) {
        http_response_code(200); // OK
        echo json_encode(array("message" => "Note updated successfully."));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("error" => "Error updating note: " . $stmt->error));
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
