<?php

session_start();

if(!isset($_SESSION['athlete_id'])){
    header("Location: login.php");
    exit();
}

include "database/connection.php";

$athlete_id = $_SESSION['athlete_id'];

$create_table_sql = "CREATE TABLE IF NOT EXISTS coach_advice (
    advice_id INT AUTO_INCREMENT PRIMARY KEY,
    athlete_id INT NOT NULL,
    coach_id INT NOT NULL,
    recommendation TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

mysqli_query($conn, $create_table_sql);

$sql = "SELECT coach_advice.*, coach.full_name AS coach_name
        FROM coach_advice
        LEFT JOIN coach ON coach_advice.coach_id = coach.coach_id
        WHERE coach_advice.athlete_id = '$athlete_id'
        ORDER BY coach_advice.created_at DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Coach Recommendations</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h2>Coach Recommendations</h2>

<table>
<tr>
    <th>Coach</th>
    <th>Recommendation</th>
    <th>Date</th>
</tr>

<?php if($result && mysqli_num_rows($result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo !empty($row['coach_name']) ? htmlspecialchars($row['coach_name']) : "Coach"; ?></td>
        <td><?php echo htmlspecialchars($row['recommendation']); ?></td>
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
    </tr>
    <?php } ?>

<?php }else{ ?>

    <tr>
        <td colspan="3">No coach recommendations available yet.</td>
    </tr>

<?php } ?>

</table>

<a class="back" href="dashboard.php">Back to Dashboard</a>

</body>
</html>
