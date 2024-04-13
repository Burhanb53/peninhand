<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required parameters are provided
    if (isset($_POST["planId"]) && isset($_POST["planName"]) && isset($_POST["description"]) && isset($_POST["duration"]) && isset($_POST["price"])) {
        $planId = $_POST["planId"];
        $planName = $_POST["planName"];
        $description = $_POST["description"];
        $duration = $_POST["duration"];
        $price = $_POST["price"];

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

        // Prepare SQL statement to update the plan
        $sql = "UPDATE subscription_plan SET plan_name=?, description=?, duration=?, price=? WHERE id=?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdi", $planName, $description, $duration, $price, $planId);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo json_encode(["success" => true, "message" => "Plan updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update plan."]);
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Missing parameters."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
