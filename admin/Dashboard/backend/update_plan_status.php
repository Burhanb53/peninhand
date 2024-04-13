<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required parameters are provided
    if (isset($_POST["action"]) && isset($_POST["planId"])) {
        $action = $_POST["action"];
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

        // Prepare SQL statement based on the action
        if ($action == "activate") {
            $sql = "UPDATE subscription_plan SET active = 1 WHERE id = ?";
        } elseif ($action == "deactivate") {
            $sql = "UPDATE subscription_plan SET active = 0 WHERE id = ?";
        } else {
            echo json_encode(["success" => false, "message" => "Invalid action."]);
            exit;
        }

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $planId);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo json_encode(["success" => true, "message" => "Plan $action successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to $action plan."]);
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
