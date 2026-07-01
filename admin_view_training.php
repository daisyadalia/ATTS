<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

include "database/connection.php";
include "database/schema.php";
include "analysis/biomechanics.php";

ensureTrainingLogColumns($conn);

$sql = "SELECT training_log.*, athlete.full_name AS athlete_name
        FROM training_log
        LEFT JOIN athlete ON training_log.athlete_id = athlete.athlete_id
        ORDER BY training_log.training_date DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Training Records</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h2>All Training Records</h2>

<table>
<tr>
    <th>Log ID</th>
    <th>Athlete</th>
    <th>Muscle Group</th>
    <th>Workout Type</th>
    <th>What Was Done</th>
    <th>Duration</th>
    <th>Muscle Load</th>
    <th>Risk Level</th>
    <th>Date</th>
</tr>

<?php if($result && mysqli_num_rows($result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo htmlspecialchars($row['log_id']); ?></td>
        <td><?php echo !empty($row['athlete_name']) ? htmlspecialchars($row['athlete_name']) : "Athlete ".$row['athlete_id']; ?></td>
        <td><?php echo htmlspecialchars($row['muscle_group'] ?? 'Not set'); ?></td>
        <td><?php echo htmlspecialchars($row['workout_type'] ?? 'Not set'); ?></td>
        <td><?php echo htmlspecialchars($row['exercise_done'] ?? 'Not set'); ?></td>
        <td><?php echo htmlspecialchars($row['duration']); ?> min</td>
        <td><?php echo htmlspecialchars($row['muscle_load']); ?>%</td>
        <td><?php echo htmlspecialchars(injuryRisk($row['muscle_load'])); ?></td>
        <td><?php echo htmlspecialchars($row['training_date']); ?></td>
    </tr>
    <?php } ?>

<?php }else{ ?>

    <tr>
        <td colspan="9">No training records found.</td>
    </tr>

<?php } ?>

</table>

<a class="back" href="admin_dashboard.php">Back to Dashboard</a>

</body>
</html>
