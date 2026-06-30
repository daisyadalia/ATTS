<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

include "database/connection.php";

$athlete_count = 0;
$coach_count = 0;
$training_count = 0;
$avg_load = 0;

$athlete_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM athlete");
$coach_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM coach");
$training_result = mysqli_query($conn, "SELECT COUNT(*) AS total, ROUND(AVG(muscle_load), 1) AS avg_load FROM training_log");

if($athlete_result){
    $athlete_count = mysqli_fetch_assoc($athlete_result)['total'];
}

if($coach_result){
    $coach_count = mysqli_fetch_assoc($coach_result)['total'];
}

if($training_result){
    $training_summary = mysqli_fetch_assoc($training_result);
    $training_count = $training_summary['total'];
    $avg_load = $training_summary['avg_load'];
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h2>Welcome <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h2>

<div class="dashboard admin-dashboard">

<h1>Admin Dashboard</h1>

<div class="stats-grid">
    <div class="stat-box">
        <strong><?php echo htmlspecialchars($athlete_count); ?></strong>
        <span>Athletes</span>
    </div>
    <div class="stat-box">
        <strong><?php echo htmlspecialchars($coach_count); ?></strong>
        <span>Coaches</span>
    </div>
    <div class="stat-box">
        <strong><?php echo htmlspecialchars($training_count); ?></strong>
        <span>Training Records</span>
    </div>
    <div class="stat-box">
        <strong><?php echo $avg_load ? htmlspecialchars($avg_load)."%" : "0%"; ?></strong>
        <span>Average Load</span>
    </div>
</div>

<a href="admin_view_athletes.php">View Athletes</a>

<a href="admin_view_coaches.php">View Coaches</a>

<a href="admin_assign_coaches.php">Assign Coaches by Sport</a>

<a href="admin_view_training.php">View Training Records</a>

<a href="generate_report.php">View Coach Reports</a>

<a href="admin_register.php">Register Admin</a>

<a href="logout.php">Logout</a>

</div>

</body>
</html>
