<?php

session_start();

if(!isset($_SESSION['coach_id'])){
    header("Location: coach_login.php");
    exit();
}

include "database/connection.php";

$coach_id = $_SESSION['coach_id'];

$sql = "SELECT
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
        WHERE athlete.coach_id = '$coach_id'
        GROUP BY athlete.athlete_id, athlete.full_name, athlete.sport
        ORDER BY latest_training DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Coach Reports</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h2>Coach Training Reports</h2>

<table>
<tr>
    <th>Athlete</th>
    <th>Sport</th>
    <th>Total Sessions</th>
    <th>Average Duration</th>
    <th>Average Muscle Load</th>
    <th>Latest Training</th>
</tr>

<?php if($result && mysqli_num_rows($result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
        <td><?php echo htmlspecialchars($row['sport']); ?></td>
        <td><?php echo htmlspecialchars($row['total_sessions']); ?></td>
        <td><?php echo $row['avg_duration'] ? htmlspecialchars($row['avg_duration'])." min" : "No data"; ?></td>
        <td><?php echo $row['avg_muscle_load'] ? htmlspecialchars($row['avg_muscle_load'])."%" : "No data"; ?></td>
        <td><?php echo $row['latest_training'] ? htmlspecialchars($row['latest_training']) : "No data"; ?></td>
    </tr>
    <?php } ?>

<?php }else{ ?>

    <tr>
        <td colspan="6">No report data available.</td>
    </tr>

<?php } ?>

</table>

<a class="back" href="coach_dashboard.php">Back to Dashboard</a>

</body>
</html>
