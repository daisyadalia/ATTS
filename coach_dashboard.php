<?php

session_start();

if(!isset($_SESSION['coach_id'])){
    header("Location: coach_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Coach Dashboard</title>

<link rel="stylesheet" href="css/style.css?v=2">

</head>

<body>

<h2>
Welcome Coach <?php echo $_SESSION['coach_name']; ?>
</h2>

<div class="dashboard">

<h1>Coach Dashboard</h1>

<a href="view_athletes.php">View Assigned Athletes</a>

<a href="monitor_progress.php">Monitor Athlete Progress</a>

<a href="coach_recommendations.php">View Injury Analysis</a>

<a href="generate_report.php">Generate Reports</a>

<a href="logout.php">Logout</a>

</div>

</body>

</html>
