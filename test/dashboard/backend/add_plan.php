<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = ""; // Update with your database password if applicable
    $dbname = "peninhand";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $planName = $_POST["planName"];
    $description = $_POST["description"];
    $duration = $_POST["duration"];
    $price = $_POST["price"];

    // Generate a unique 3-digit subscription ID
    $subscriptionId = mt_rand(100, 999); // Generate a random number between 100 and 999

    // Prepare SQL statement to insert data into subscription_plan table
    $sql = "INSERT INTO subscription_plan (subscription_id, plan_name, description, duration, price) VALUES (?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $subscriptionId, $planName, $description, $duration, $price);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo json_encode(["success" => true, "message" => "Plan added successfully.", "subscriptionId" => $subscriptionId]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add plan."]);
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If the request method is not POST, return an error message
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
