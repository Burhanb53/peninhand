<?php
// Include config.php or establish database connection if not already included
include('../includes/config.php');

try {
    // SQL query to fetch teachers from the database
    $sql = "SELECT name, email FROM teacher";

    // Prepare and execute the query
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // Fetch all rows as associative arrays
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert the fetched data to JSON format
    echo json_encode($teachers);
} catch (PDOException $e) {
    // Handle database errors
    http_response_code(500);
    echo json_encode(array('error' => 'Database error: ' . $e->getMessage()));
} finally {
    // Close the database connection
    $dbh = null;
}
?>