<?php

session_start();

include "database/connection.php";

if(!isset($_SESSION['athlete_id'])){
    header("Location: login.php");
    exit();
}

$athlete_id = $_SESSION['athlete_id'];

mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN muscle_group VARCHAR(50) NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN workout_type VARCHAR(100) NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN exercise_done TEXT NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN training_guidance TEXT NULL");

$sql = "SELECT * FROM training_log
        WHERE athlete_id='$athlete_id'
        ORDER BY training_date DESC";

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Training Records</title>

<link rel="stylesheet" href="css/style.css?v=2">


</head>

<body>

<h2>My Training Records</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Muscle Group</th>
    <th>Workout Type</th>
    <th>What Was Done</th>
    <th>How to Train</th>
    <th>Duration</th>
    <th>Muscle Load</th>
    <th>Date</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result)){

echo "<tr>";

echo "<td>".$row['log_id']."</td>";
echo "<td>".htmlspecialchars($row['muscle_group'] ?? 'Not set')."</td>";
echo "<td>".htmlspecialchars($row['workout_type'] ?? 'Not set')."</td>";
echo "<td>".htmlspecialchars($row['exercise_done'] ?? 'Not set')."</td>";
echo "<td>".htmlspecialchars($row['training_guidance'] ?? 'Not set')."</td>";
echo "<td>".htmlspecialchars($row['duration'])." min</td>";
echo "<td>".htmlspecialchars($row['muscle_load'])."%</td>";
echo "<td>".htmlspecialchars($row['training_date'])."</td>";

echo "</tr>";

}

?>

</table>

<br>

<a class="back" href="dashboard.php">Back to Dashboard</a>

</body>
</html>
