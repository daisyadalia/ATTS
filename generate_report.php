<?php

session_start();

if(!isset($_SESSION['coach_id']) && !isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include "database/connection.php";
include "analysis/biomechanics.php";

$is_admin = isset($_SESSION['admin_id']);
$dashboard_link = $is_admin ? "admin_dashboard.php" : "coach_dashboard.php";
$report_title = $is_admin ? "System Training Report" : "Coach Training Report";
$where_clause = "";

if(!$is_admin){
    $coach_id = $_SESSION['coach_id'];
    $where_clause = "WHERE athlete.coach_id = '$coach_id'";
}

$summary_sql = "SELECT
                    COUNT(DISTINCT athlete.athlete_id) AS total_athletes,
                    COUNT(training_log.log_id) AS total_sessions,
                    ROUND(AVG(training_log.duration), 1) AS avg_duration,
                    ROUND(AVG(training_log.muscle_load), 1) AS avg_muscle_load
                FROM athlete
                LEFT JOIN training_log
                    ON athlete.athlete_id = training_log.athlete_id
                $where_clause";

$report_sql = "SELECT
                    athlete.athlete_id,
                    athlete.full_name,
                    athlete.sport,
                    COUNT(training_log.log_id) AS total_sessions,
                    ROUND(AVG(training_log.duration), 1) AS avg_duration,
                    ROUND(AVG(training_log.muscle_load), 1) AS avg_muscle_load,
                    MAX(training_log.training_date) AS latest_training
                FROM athlete
                LEFT JOIN training_log
                    ON athlete.athlete_id = training_log.athlete_id
                $where_clause
                GROUP BY athlete.athlete_id, athlete.full_name, athlete.sport
                ORDER BY latest_training DESC";

$summary_result = mysqli_query($conn, $summary_sql);
$report_result = mysqli_query($conn, $report_sql);
$summary = $summary_result ? mysqli_fetch_assoc($summary_result) : null;

?>

<!DOCTYPE html>
<html>
<head>
<title>Generate Report</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h2><?php echo $report_title; ?></h2>

<div class="dashboard report-summary">
    <h3>Report Summary</h3>

    <p>Total Athletes: <?php echo htmlspecialchars($summary['total_athletes'] ?? 0); ?></p>
    <p>Total Training Sessions: <?php echo htmlspecialchars($summary['total_sessions'] ?? 0); ?></p>
    <p>Average Duration: <?php echo !empty($summary['avg_duration']) ? htmlspecialchars($summary['avg_duration'])." min" : "No data"; ?></p>
    <p>Average Muscle Load: <?php echo !empty($summary['avg_muscle_load']) ? htmlspecialchars($summary['avg_muscle_load'])."%" : "No data"; ?></p>
</div>

<table>
<tr>
    <th>Athlete</th>
    <th>Sport</th>
    <th>Sessions</th>
    <th>Avg Duration</th>
    <th>Avg Muscle Load</th>
    <th>Risk Level</th>
    <th>Latest Training</th>
</tr>

<?php if($report_result && mysqli_num_rows($report_result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($report_result)){ ?>
        <?php
            $average_load = $row['avg_muscle_load'];
            $risk = $average_load ? injuryRisk($average_load) : "No data";
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['sport']); ?></td>
            <td><?php echo htmlspecialchars($row['total_sessions']); ?></td>
            <td><?php echo $row['avg_duration'] ? htmlspecialchars($row['avg_duration'])." min" : "No data"; ?></td>
            <td><?php echo $average_load ? htmlspecialchars($average_load)."%" : "No data"; ?></td>
            <td><?php echo htmlspecialchars($risk); ?></td>
            <td><?php echo $row['latest_training'] ? htmlspecialchars($row['latest_training']) : "No data"; ?></td>
        </tr>
    <?php } ?>

<?php }else{ ?>

    <tr>
        <td colspan="7">No report data available.</td>
    </tr>

<?php } ?>

</table>

<a class="back" href="<?php echo $dashboard_link; ?>">Back to Dashboard</a>

</body>
</html>
