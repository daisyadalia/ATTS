<?php

session_start();

if(!isset($_SESSION['coach_id'])){
    header("Location: coach_login.php");
    exit();
}

include "database/connection.php";
include "database/schema.php";

ensureTrainingLogColumns($conn);

$coach_id = $_SESSION['coach_id'];

$sql = "SELECT training_log.*, athlete.full_name AS athlete_name
        FROM training_log
        LEFT JOIN athlete ON training_log.athlete_id = athlete.athlete_id
        WHERE athlete.coach_id = '$coach_id'
        ORDER BY training_log.training_date DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>

<head>

<title>Monitor Athlete Progress</title>

<link rel="stylesheet" href="css/style.css?v=2">

</head>

<body>

<h2>Monitor Athlete Progress</h2>

<table>

<tr>

<th>Log ID</th>

<th>Athlete</th>

<th>Muscle Group</th>

<th>Workout Type</th>

<th>What Was Done</th>

<th>Duration (Minutes)</th>

<th>Muscle Load (%)</th>

<th>Training Date</th>

</tr>

<?php if($result && mysqli_num_rows($result) > 0){ ?>

<?php while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['log_id']; ?></td>

<td><?php echo htmlspecialchars($row['athlete_name'] ?? 'Athlete '.$row['athlete_id']); ?></td>

<td><?php echo htmlspecialchars($row['muscle_group'] ?? 'Not set'); ?></td>

<td><?php echo htmlspecialchars($row['workout_type'] ?? 'Not set'); ?></td>

<td><?php echo htmlspecialchars($row['exercise_done'] ?? 'Not set'); ?></td>

<td><?php echo htmlspecialchars($row['duration']); ?></td>

<td><?php echo htmlspecialchars($row['muscle_load']); ?></td>

<td><?php echo htmlspecialchars($row['training_date']); ?></td>

</tr>

<?php

} ?>

<?php }else{ ?>

<tr>
<td colspan="8">No training records found for your assigned athletes.</td>
</tr>

<?php } ?>


</table>

<a class="back" href="coach_dashboard.php">
Back to Dashboard
</a>

</body>

</html>
