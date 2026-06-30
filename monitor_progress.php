<?php

session_start();

if(!isset($_SESSION['coach_id'])){
    header("Location: coach_login.php");
    exit();
}

include "database/connection.php";

mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN muscle_group VARCHAR(50) NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN workout_type VARCHAR(100) NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN exercise_done TEXT NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN training_guidance TEXT NULL");

$sql = "SELECT * FROM training_log ORDER BY training_date DESC";

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

<th>Athlete ID</th>

<th>Muscle Group</th>

<th>Workout Type</th>

<th>Duration (Minutes)</th>

<th>Muscle Load (%)</th>

<th>Training Date</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['log_id']; ?></td>

<td><?php echo $row['athlete_id']; ?></td>

<td><?php echo htmlspecialchars($row['muscle_group'] ?? 'Not set'); ?></td>

<td><?php echo htmlspecialchars($row['workout_type'] ?? 'Not set'); ?></td>

<td><?php echo $row['duration']; ?></td>

<td><?php echo $row['muscle_load']; ?></td>

<td><?php echo $row['training_date']; ?></td>

</tr>

<?php

}

?>

</table>

<a class="back" href="coach_dashboard.php">
Back to Dashboard
</a>

</body>

</html>
