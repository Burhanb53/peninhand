<?php
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','peninhand');

try {
    // Establish database connection using PDO
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    // Set PDO to throw exceptions for error handling
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch data for doubts created each month
    $query_doubts = "SELECT DATE_FORMAT(doubt_created_at, '%Y-%m') AS doubt_month, COUNT(*) AS doubt_count
                     FROM doubt
                     GROUP BY DATE_FORMAT(doubt_created_at, '%Y-%m')
                     ORDER BY doubt_month";

    $stmt_doubts = $dbh->prepare($query_doubts);
    $stmt_doubts->execute();

    // Fetch data for doubts into an associative array
    $data_doubts = array();
    while ($row = $stmt_doubts->fetch(PDO::FETCH_ASSOC)) {
        $data_doubts[$row['doubt_month']] = $row['doubt_count'];
    }

    // SQL query to fetch data for answers created each month
    $query_answers = "SELECT DATE_FORMAT(answer_created_at, '%Y-%m') AS answer_month, COUNT(*) AS answer_count
                      FROM doubt
                      WHERE answer_created_at IS NOT NULL
                      GROUP BY DATE_FORMAT(answer_created_at, '%Y-%m')
                      ORDER BY answer_month";

    $stmt_answers = $dbh->prepare($query_answers);
    $stmt_answers->execute();

    // Fetch data for answers into an associative array
    $data_answers = array();
    while ($row = $stmt_answers->fetch(PDO::FETCH_ASSOC)) {
        $data_answers[$row['answer_month']] = $row['answer_count'];
    }

    // Combine doubts and answers data into a single dataset
    $combined_data = array();
    foreach ($data_doubts as $month => $doubt_count) {
        $combined_data[$month]['doubt_count'] = $doubt_count;
        $combined_data[$month]['answer_count'] = isset($data_answers[$month]) ? $data_answers[$month] : 0;
    }

    // JSON encode the combined data for JavaScript
    $json_data = json_encode($combined_data);

    // Close the database connection
    $dbh = null;
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doubts and Answers Created by Month</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="doubtAnswerChart" width="800" height="400"></canvas>
    <script>
        var ctx = document.getElementById('doubtAnswerChart').getContext('2d');
        var data = <?php echo $json_data; ?>;

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'Doubts Created',
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: Object.values(data).map(item => item.doubt_count),
                }, {
                    label: 'Answers Created',
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    data: Object.values(data).map(item => item.answer_count),
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
