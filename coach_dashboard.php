<?php
session_start();

include "database/connection.php";

/*
if(!isset($_SESSION['trainer_id'])){
    header("Location: trainer_login.php");
    exit();
}
*/

// Statistics
$athletes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM athlete"));

$programs = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM training_programs")
);

$injuries = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM injury_reports")
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Coach Dashboard</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif;
        }

        body{
            display:flex;
            background:#f4f4f4;
        }

        .sidebar{
            width:250px;
            height:100vh;
            background:#0f172a;
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

        .sidebar li{
            margin:15px 0;
        }

        .sidebar a{
            color:white;
            text-decoration:none;
        }

        .main{
            flex:1;
            padding:30px;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:20px;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:10px;
            text-align:center;
            box-shadow:0 2px 5px rgba(0,0,0,0.2);
        }

        .card h3{
            margin-bottom:10px;
        }

        .card p{
            font-size:30px;
            font-weight:bold;
        }

        table{
            width:100%;
            margin-top:30px;
            border-collapse:collapse;
            background:white;
        }

        th, td{
            border:1px solid #ddd;
            padding:10px;
        }

        th{
            background:#0f172a;
            color:white;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>Coach Panel</h2>

    <ul>
        <li><a href="coach_dashboard.php">Dashboard</a></li>
        <li><a href="manage_athletes.php">Athletes</a></li>
        <li><a href="training_programs.php">Programs</a></li>
        <li><a href="injury_reports.php">Injury Reports</a></li>
        <li><a href="exercises.php">Exercises</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="main">

    <h1>Coach Dashboard</h1>
    <br>

    <div class="cards">

        <div class="card">
            <h3>Total Athletes</h3>
            <p><?php echo $athletes; ?></p>
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

    <h2 style="margin-top:30px;">Recent Athletes</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Sport</th>
        </tr>

        <?php

        $result = mysqli_query(
            $conn,
            "SELECT * FROM athlete ORDER BY athlete_id DESC LIMIT 5"
        );

        while($row = mysqli_fetch_assoc($result))
        {
        ?>

        <tr>
            <td><?php echo $row['athlete_id']; ?></td>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['sport']; ?></td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
