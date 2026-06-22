<?php

session_start();

if(!isset($_SESSION['athlete_id'])){

    header("Location: login.php");
    exit();

}

?>

<link rel="stylesheet" href="css/style.css">

<!DOCTYPE html>
<html>
<head>
<title>Athlete Dashboard</title>
</head>
<body>

<link rel="stylesheet" href="css/style.css">

<h1>Welcome <?php echo $_SESSION['name']; ?></h1>

<div class="dashboard-content">

    <h2>Athlete Dashboard</h2>

    <a href="upload.php">Upload Training Data</a>

    <br><br>

    <a href="view_training.php">View Training Records</a>

    <br><br>

    <a href="recommendation.php">View Injury Analysis</a>

    <br><br>

    <a href="logout.php">Logout</a>

</div>