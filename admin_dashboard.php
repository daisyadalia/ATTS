<?php
session_start();

include "database/connection.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}

include("config.php");

// Statistics
$athletes = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM athletes"));
$trainers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trainers"));
$programs = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM training_programs"));
$injuries = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM injury_reports"));
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
        "SELECT * FROM athletes ORDER BY athlete_id DESC LIMIT 5");

        while($row = mysqli_fetch_assoc($result)){
        ?>

        <tr>
            <td><?php echo $row['athlete_id']; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['sport']; ?></td>
            <td><?php echo $row['email']; ?></td>
        </tr>

        <?php } ?>
    </table>

</div>

</body>
</html>
