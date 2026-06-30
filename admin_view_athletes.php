<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

include "database/connection.php";

$sql = "SELECT athlete.*, coach.full_name AS coach_name
        FROM athlete
        LEFT JOIN coach ON athlete.coach_id = coach.coach_id
        ORDER BY athlete.athlete_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Athletes</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h2>All Athletes</h2>

<table>
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Sport</th>
    <th>Fitness Level</th>
    <th>Coach</th>
</tr>

<?php if($result && mysqli_num_rows($result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo htmlspecialchars($row['athlete_id']); ?></td>
        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['sport']); ?></td>
        <td><?php echo !empty($row['fitness_level']) ? htmlspecialchars($row['fitness_level']) : "Not Available"; ?></td>
        <td><?php echo !empty($row['coach_name']) ? htmlspecialchars($row['coach_name']) : "Not Assigned"; ?></td>
    </tr>
    <?php } ?>

<?php }else{ ?>

    <tr>
        <td colspan="6">No athletes found.</td>
    </tr>

<?php } ?>

</table>

<a class="back" href="admin_dashboard.php">Back to Dashboard</a>

</body>
</html>
