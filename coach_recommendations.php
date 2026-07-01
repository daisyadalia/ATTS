<?php

session_start();

if(!isset($_SESSION['coach_id'])){
    header("Location: coach_login.php");
    exit();
}

include "database/connection.php";
include "database/schema.php";

$message = "";
$message_type = "success";
$coach_id = $_SESSION['coach_id'];

ensureTrainingLogColumns($conn);

$create_table_sql = "CREATE TABLE IF NOT EXISTS coach_advice (
    advice_id INT AUTO_INCREMENT PRIMARY KEY,
    athlete_id INT NOT NULL,
    coach_id INT NOT NULL,
    recommendation TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

mysqli_query($conn, $create_table_sql);

if(isset($_POST['send_recommendation'])){
    $athlete_id = mysqli_real_escape_string($conn, $_POST['athlete_id']);
    $recommendation = mysqli_real_escape_string($conn, $_POST['recommendation']);

    $insert_sql = "INSERT INTO coach_advice (athlete_id, coach_id, recommendation)
                   VALUES ('$athlete_id', '$coach_id', '$recommendation')";

    if(mysqli_query($conn, $insert_sql)){
        $message = "Coach recommendation sent successfully.";
    }else{
        $message = "Recommendation could not be sent. Please try again.";
        $message_type = "danger";
    }
}

$athletes_result = mysqli_query($conn, "SELECT athlete_id, full_name FROM athlete WHERE coach_id = '$coach_id' ORDER BY full_name ASC");

$result=mysqli_query($conn,"SELECT training_log.*, athlete.full_name AS athlete_name
                            FROM training_log
                            LEFT JOIN athlete ON training_log.athlete_id = athlete.athlete_id
                            WHERE athlete.coach_id = '$coach_id'
                            ORDER BY training_log.training_date DESC");

?>

<!DOCTYPE html>

<html>

<head>

<title>Injury Analysis</title>

<link rel="stylesheet" href="css/style.css?v=2">

</head>

<body>

<h2>Athlete Injury Analysis</h2>

<?php if($message){ ?>
<p class="message <?php echo $message_type; ?>"><?php echo htmlspecialchars($message); ?></p>
<?php } ?>

<form method="POST">
<h3>Send Coach Recommendation</h3>

<label>Select Athlete</label>
<select name="athlete_id" required>
    <option value="">Choose athlete</option>
    <?php if($athletes_result && mysqli_num_rows($athletes_result) > 0){ ?>
        <?php while($athlete = mysqli_fetch_assoc($athletes_result)){ ?>
            <option value="<?php echo htmlspecialchars($athlete['athlete_id']); ?>">
                <?php echo htmlspecialchars($athlete['full_name']); ?>
            </option>
        <?php } ?>
    <?php } ?>
</select>

<label>Recommendation</label>
<textarea name="recommendation" rows="4" placeholder="Write a recommendation for the athlete" required></textarea>

<button type="submit" name="send_recommendation">Send Recommendation</button>
</form>

<table>

<tr>

<th>Athlete</th>

<th>Muscle Group</th>

<th>Workout Type</th>

<th>Training Date</th>

<th>Recommendation</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result)){

echo "<tr>";

echo "<td>".htmlspecialchars($row['athlete_name'] ?? 'Athlete '.$row['athlete_id'])."</td>";

echo "<td>".htmlspecialchars($row['muscle_group'] ?? 'Not set')."</td>";

echo "<td>".htmlspecialchars($row['workout_type'] ?? 'Not set')."</td>";

echo "<td>".htmlspecialchars($row['training_date'])."</td>";

echo "<td><a href='recommendation.php?athlete=".$row['athlete_id']."'>View Analysis</a></td>";

echo "</tr>";

}

?>

</table>

<a class="back" href="coach_dashboard.php">Back to Dashboard</a>

</body>

</html>
