<?php

session_start();

if (!isset($_SESSION['coach_id'])) {
    header("Location: coach_login.php");
    exit();
}

include "database/connection.php";

$coach_id = $_SESSION['coach_id'];

$sql = "SELECT * FROM athlete WHERE coach_id = '$coach_id'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>View Assigned Athletes</title>

    <link rel="stylesheet" href="css/style.css?v=2">

</head>

<body>

<h2>My Assigned Athletes</h2>

<table>

<tr>
    <th>Athlete ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Sport</th>
    <th>Fitness Level</th>
</tr>

<?php

if(mysqli_num_rows($result) > 0){

    while($row = mysqli_fetch_assoc($result)){

?>

<tr>

    <td><?php echo $row['athlete_id']; ?></td>

    <td><?php echo $row['full_name']; ?></td>

    <td><?php echo $row['email']; ?></td>

    <td><?php echo $row['sport']; ?></td>

    <td>
        <?php
        if(empty($row['fitness_level'])){
            echo "Not Available";
        }else{
            echo $row['fitness_level'];
        }
        ?>
    </td>

</tr>

<?php

    }

}else{

?>

<tr>

    <td colspan="5">No athletes have been assigned to you.</td>

</tr>

<?php

}

?>

</table>

<a href="coach_dashboard.php" class="btn">
Back to Dashboard
</a>

</body>

</html>
