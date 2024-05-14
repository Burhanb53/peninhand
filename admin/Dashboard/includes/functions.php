<?php
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

function getDoubtCount($pdo) {
    $sql = "SELECT COUNT(*) as count FROM doubt";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

// Function to fetch the most recent doubts or answers
function getRecentDoubts($pdo) {
    $sql = "SELECT id, doubt_id, user_id, teacher_id, doubt_category, doubt, doubt_file, 
                  doubt_created_at, answer, answer_file, answer_created_at, 
                  student_view, teacher_view, admin_view, accepted, doubt_submit, feedback
            FROM doubt 
            ORDER BY IFNULL(answer_created_at, doubt_created_at) DESC 
            LIMIT 5";
    $stmt = $pdo->query($sql);
    $doubts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $doubts;
}

// Fetch counts from the database
$doubt_count = getCountResolvedDoubts($pdo); // Count of resolved doubts
$total_doubt_count = getDoubtCount($pdo); // Total count of doubts

// Fetch counts for teachers and students from the database
$teacher_count = getCountByRole($pdo, 2); // Assuming role 2 is for teachers
$student_count = getCountByRole($pdo, 1); // Assuming role 1 is for students

// Get recent doubts
$recent_doubts = getRecentDoubts($pdo);

// Close the connection
$pdo = null;
