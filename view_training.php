<?php

session_start();

include "database/connection.php";

if(!isset($_SESSION['athlete_id'])){
    header("Location: login.php");
    exit();
}

$athlete_id = $_SESSION['athlete_id'];

$sql = "SELECT * FROM training_log
        WHERE athlete_id='$athlete_id'
        ORDER BY training_date DESC";

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Training Records</title>

<link rel="stylesheet" href="css/style.css">


</head>

<body>

<h2>My Training Records</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Duration</th>
    <th>Muscle Load</th>
    <th>Date</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result)){

echo "<tr>";

echo "<td>".$row['log_id']."</td>";
echo "<td>".$row['duration']."</td>";
echo "<td>".$row['muscle_load']."</td>";
echo "<td>".$row['training_date']."</td>";

echo "</tr>";

}

?>

</table>

<br>

<a href='dashboard.php'>Back to Dashboard</a>

</body>
</html>