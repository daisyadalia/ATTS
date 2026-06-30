<?php

session_start();

include "database/connection.php";

$message = "";
$message_type = "success";

if(!isset($_SESSION['athlete_id'])){
    header("Location: login.php");
    exit();
}

mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN muscle_group VARCHAR(50) NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN workout_type VARCHAR(100) NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN exercise_done TEXT NULL");
mysqli_query($conn, "ALTER TABLE training_log ADD COLUMN training_guidance TEXT NULL");

if(isset($_POST['submit'])){

    $muscle_group = mysqli_real_escape_string($conn, $_POST['muscle_group']);
    $workout_type = mysqli_real_escape_string($conn, $_POST['workout_type']);
    $exercise_done = mysqli_real_escape_string($conn, $_POST['exercise_done']);
    $training_guidance = mysqli_real_escape_string($conn, $_POST['training_guidance']);
    $duration = $_POST['duration'];
    $muscle_load = $_POST['muscle_load'];
    $athlete_id = $_SESSION['athlete_id'];

    $sql = "INSERT INTO training_log
    (athlete_id,muscle_group,workout_type,exercise_done,training_guidance,duration,muscle_load)

    VALUES

    ('$athlete_id','$muscle_group','$workout_type','$exercise_done','$training_guidance','$duration','$muscle_load')";

    if(mysqli_query($conn,$sql)){
        $message = "Training data saved successfully.";
    }else{
        $message = "Training data could not be saved. Please try again.";
        $message_type = "danger";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Training Data</title>

<link rel="stylesheet" href="css/style.css?v=2">


</head>

<body>

<h2>Upload Training Data</h2>

<?php if($message){ ?>
<p class="message <?php echo $message_type; ?>"><?php echo $message; ?></p>
<?php } ?>

<form method="POST">

<label>Muscle Group Trained</label>
<select name="muscle_group" required>
    <option value="">Choose muscle group</option>
    <option value="Legs">Legs</option>
    <option value="Arms">Arms</option>
    <option value="Chest">Chest</option>
    <option value="Back">Back</option>
    <option value="Core">Core</option>
    <option value="Shoulders">Shoulders</option>
    <option value="Full Body">Full Body</option>
</select>

<label>Workout Type</label>
<select name="workout_type" required>
    <option value="">Choose workout type</option>
    <option value="Strength Training">Strength Training</option>
    <option value="Endurance Training">Endurance Training</option>
    <option value="Speed Training">Speed Training</option>
    <option value="Flexibility and Mobility">Flexibility and Mobility</option>
    <option value="Recovery Session">Recovery Session</option>
</select>

<label>What Did You Do?</label>
<textarea
name="exercise_done"
rows="4"
placeholder="Example: Squats, lunges, leg press, calf raises"
required></textarea>

<label>How Should This Area Be Trained?</label>
<textarea
name="training_guidance"
rows="4"
placeholder="Example: Train legs twice a week, start with warm-up, use controlled movement, rest between sets"
required></textarea>

<label>Training Duration (Minutes)</label>
<input type="number"
name="duration"
min="1"
required>

<label>Muscle Load (%)</label>
<input type="number"
name="muscle_load"
min="0"
max="100"
required>

<button name="submit">
Submit
</button>

</form>

<a class="back" href="dashboard.php">Back to Dashboard</a>

</body>
</html>
