<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if plan ID is provided
    if (isset($_POST["planId"])) {
        $planId = $_POST["planId"];

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

        // Prepare SQL statement to delete the plan
        $sql = "DELETE FROM subscription_plan WHERE id = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $planId);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo json_encode(["success" => true, "message" => "Plan deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete plan."]);
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Missing plan ID."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
