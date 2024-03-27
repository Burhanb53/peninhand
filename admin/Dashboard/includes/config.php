<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = ''; // Your database password
$dbname = 'peninhand';

// Create a PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect. " . $e->getMessage());
}

// Function to fetch and return count from the database based on role
function getCountByRole($pdo, $role) {
    $sql = "SELECT COUNT(*) as count FROM user WHERE role = :role";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':role', $role, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getCountResolvedDoubts($pdo) {
    $sql = "SELECT COUNT(*) as count FROM doubt WHERE feedback = 1";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

// Fetch counts from the database
$doubt_count = getCountResolvedDoubts($pdo); // Count of resolved doubts

// Fetch counts for teachers and students from the database
$teacher_count = getCountByRole($pdo, 2); // Assuming role 2 is for teachers
$student_count = getCountByRole($pdo, 1); // Assuming role 1 is for students

// Close the connection
$pdo = null;
?>
