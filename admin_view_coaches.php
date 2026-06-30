<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

include "database/connection.php";

$sql = "SELECT coach.*,
            COUNT(athlete.athlete_id) AS assigned_athletes
        FROM coach
        LEFT JOIN athlete ON coach.coach_id = athlete.coach_id
        GROUP BY coach.coach_id, coach.full_name, coach.email, coach.specialization
        ORDER BY coach.coach_id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Coaches</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h2>All Coaches</h2>

<table>
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Specialization</th>
    <th>Assigned Athletes</th>
</tr>

<?php if($result && mysqli_num_rows($result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo htmlspecialchars($row['coach_id']); ?></td>
        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['specialization']); ?></td>
        <td><?php echo htmlspecialchars($row['assigned_athletes']); ?></td>
    </tr>
    <?php } ?>

<?php }else{ ?>

    <tr>
        <td colspan="5">No coaches found.</td>
    </tr>

<?php } ?>

</table>

<a class="back" href="admin_dashboard.php">Back to Dashboard</a>

</body>
</html>
