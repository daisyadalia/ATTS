<<<<<<< HEAD
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
=======
<?php
session_start();

include "database/connection.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

// Statistics
$result = mysqli_query($conn, "SELECT * FROM athlete");
$athletes = mysqli_num_rows($result);

$trainers = 0;
$programs = 0;
$injuries = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>ATTS Admin Dashboard</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial;
        }

        body{
            display:flex;
            background:#f4f4f4;
        }

        .sidebar{
            width:250px;
            height:100vh;
            background:#1e293b;
            color:white;
            padding:20px;
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:30px;
        }

        .sidebar ul{
            list-style:none;
        }

        .sidebar ul li{
            margin:15px 0;
        }

        .sidebar ul li a{
            color:white;
            text-decoration:none;
        }

        .main{
            flex:1;
            padding:30px;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:10px;
            text-align:center;
            box-shadow:0 2px 5px rgba(0,0,0,0.2);
        }

        .card h3{
            color:#555;
        }

        .card p{
            font-size:30px;
            font-weight:bold;
            margin-top:10px;
        }

        table{
            width:100%;
            margin-top:30px;
            border-collapse:collapse;
            background:white;
        }

        table th,
        table td{
            border:1px solid #ddd;
            padding:10px;
            text-align:left;
        }

        table th{
            background:#1e293b;
            color:white;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>ATTS Admin</h2>

    <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="manage_athletes.php">Athletes</a></li>
        <li><a href="manage_trainers.php">Trainers</a></li>
        <li><a href="manage_exercises.php">Exercises</a></li>
        <li><a href="manage_programs.php">Programs</a></li>
        <li><a href="injury_reports.php">Injury Reports</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="main">

    <h1>Admin Dashboard</h1>
    <br>

    <div class="cards">

        <div class="card">
            <h3>Total Athletes</h3>
            <p><?php echo $athletes; ?></p>
        </div>

        <div class="card">
            <h3>Total Trainers</h3>
            <p><?php echo $trainers; ?></p>
        </div>

        <div class="card">
            <h3>Training Programs</h3>
            <p><?php echo $programs; ?></p>
        </div>

        <div class="card">
            <h3>Injury Reports</h3>
            <p><?php echo $injuries; ?></p>
        </div>

    </div>

    <h2 style="margin-top:40px;">Recent Athletes</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Sport</th>
            <th>Email</th>
        </tr>

        <?php
       $result = mysqli_query($conn,
"SELECT * FROM athlete LIMIT 5");

        while($row = mysqli_fetch_assoc($result)){
        ?>

        <tr>
            <td><?php echo $row['athlete_id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['sport']; ?></td>
            <td><?php echo $row['email']; ?></td>
        </tr>

        <?php } ?>
    </table>

</div>

</body>
</html>
>>>>>>> b941e995365861534cccaa45ebb88522f1914584
