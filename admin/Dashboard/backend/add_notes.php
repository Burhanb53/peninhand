<?php
session_start();
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "peninhand";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if the required fields are present
    if (isset($data['title']) && isset($data['content'])) {
        // Prepare the SQL statement to insert data into the notes table
        $stmt = $conn->prepare("INSERT INTO notes (user_id, title, content, doubt_id) VALUES (?, ?, ?, ?)");

        // Bind parameters to the prepared statement
        $stmt->bind_param("isss", $user_id, $title, $content, $doubt_id);

        // Set parameters and execute the statement
        $user_id = $_SESSION['user_id']; // Replace with the user ID from session
        $title = $data['title'];
        $content = $data['content'];
        $doubt_id = isset($data['doubt_id']) ? $data['doubt_id'] : NULL;

        // Execute the statement
        if ($stmt->execute()) {
            // Data inserted successfully
            http_response_code(200);
            echo json_encode(array("message" => "Note added successfully."));
        } else {
            // Error occurred while inserting data
            http_response_code(500);
            echo json_encode(array("message" => "Unable to add note."));
        }
    } else {
        // Required fields are missing
        http_response_code(400);
        echo json_encode(array("message" => "Missing required fields."));
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}

// Close connection
$conn->close();
?>
