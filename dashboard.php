<?php

session_start();

if(!isset($_SESSION['athlete_id'])){

    header("Location: login.php");
    exit();

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Athlete Dashboard</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h1>Welcome <?php echo $_SESSION['name']; ?></h1>

<div class="dashboard-content">

    <h2>Athlete Dashboard</h2>

    <a href="upload.php">Upload Training Data</a>

    <a href="view_training.php">View Training Records</a>

    <a href="recommendation.php">View Injury Analysis</a>

    <a href="athlete_coach_recommendations.php">Coach Recommendations</a>

    <a href="logout.php">Logout</a>

</div>

</body>
</html>
