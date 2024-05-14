<?php
// Include database connection file
$host = '127.0.0.1';
$dbname = 'peninhand';
$username = 'root';
$password = '';

// Attempt to connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function getCountByRole($pdo, $role)
{
    $sql = "SELECT COUNT(*) as count FROM user WHERE role = :role";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':role', $role, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getCountResolvedDoubts($pdo)
{
    $sql = "SELECT COUNT(*) as count FROM doubt WHERE feedback = 1";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getDoubtCount($pdo)
{
    $sql = "SELECT COUNT(*) as count FROM doubt";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getRecentDoubts($pdo)
{
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

function fetchDataForDoubts($dbh)
{
    $query = "SELECT DATE_FORMAT(doubt_created_at, '%Y-%m') AS doubt_month, COUNT(*) AS doubt_count
              FROM doubt
              GROUP BY DATE_FORMAT(doubt_created_at, '%Y-%m')
              ORDER BY doubt_month";

    $stmt = $dbh->prepare($query);
    $stmt->execute();

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[$row['doubt_month']] = $row['doubt_count'];
    }

    return $data;
}

function fetchDataForAnswers($dbh)
{
    $query = "SELECT DATE_FORMAT(answer_created_at, '%Y-%m') AS answer_month, COUNT(*) AS answer_count
              FROM doubt
              WHERE answer_created_at IS NOT NULL
              GROUP BY DATE_FORMAT(answer_created_at, '%Y-%m')
              ORDER BY answer_month";

    $stmt = $dbh->prepare($query);
    $stmt->execute();

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[$row['answer_month']] = $row['answer_count'];
    }

    return $data;
}

function generateChartData($data_doubts, $data_answers)
{
    $combined_data = array();
    foreach ($data_doubts as $month => $doubt_count) {
        $combined_data[$month]['doubt_count'] = $doubt_count;
        $combined_data[$month]['answer_count'] = isset($data_answers[$month]) ? $data_answers[$month] : 0;
    }

    return json_encode($combined_data);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include any necessary CSS styles -->
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Doubt Statistics Section -->
    <div>
        <h2>Doubt Statistics</h2>
        <p>Total Doubts: <?php echo number_format($doubtStats['totalDoubts']); ?></p>
        <p>Resolved Doubts: <?php echo number_format($doubtStats['resolvedDoubts']); ?></p>
        <p>Unresolved Doubts: <?php echo number_format($doubtStats['unresolvedDoubts']); ?></p>
    </div>

    <!-- User Statistics Section -->
    <div>
        <h2>User Statistics</h2>
        <p>Total Users: <?php echo number_format($userStats['totalUsers']); ?></p>
        <p>Active Users: <?php echo number_format($userStats['activeUsers']); ?></p>
        <p>Inactive Users: <?php echo number_format($userStats['inactiveUsers']); ?></p>
    </div>

    <!-- Subscription Statistics Section -->
    <div>
        <h2>Subscription Statistics</h2>
        <p>Total Subscriptions: <?php echo number_format($subscriptionStats['totalSubscriptions']); ?></p>
        <p>Active Subscriptions: <?php echo number_format($subscriptionStats['activeSubscriptions']); ?></p>
        <p>Expired Subscriptions: <?php echo number_format($subscriptionStats['expiredSubscriptions']); ?></p>
    </div>

    <!-- Add more sections for other statistics -->

</body>
</html>
