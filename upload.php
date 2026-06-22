<?php

session_start();

include "database/connection.php";

if(!isset($_SESSION['athlete_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit'])){

    $duration = $_POST['duration'];
    $muscle_load = $_POST['muscle_load'];
    $athlete_id = $_SESSION['athlete_id'];

    $sql = "INSERT INTO training_log
    (athlete_id,duration,muscle_load)

    VALUES

    ('$athlete_id','$duration','$muscle_load')";

    mysqli_query($conn,$sql);

    echo "Training Data Saved Successfully";
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Training Data</title>

<link rel="stylesheet" href="css/style.css">


</head>

<body>

<h2>Upload Training Data</h2>

<form method="POST">

<label>Training Duration (Minutes)</label>
<br>
<input type="number"
name="duration"
required>

<br><br>

<label>Muscle Load (%)</label>
<br>
<input type="number"
name="muscle_load"
required>

<br><br>

<button name="submit">
Submit
</button>

</form>

</body>
</html>