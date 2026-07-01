<?php

session_start();

include "database/connection.php";
include "database/schema.php";
include "analysis/biomechanics.php";

if(isset($_SESSION['athlete_id'])){
    $athlete_id = $_SESSION['athlete_id'];
    $dashboard_link = "dashboard.php";
}elseif(isset($_SESSION['coach_id']) && isset($_GET['athlete'])){
    $athlete_id = $_GET['athlete'];
    $dashboard_link = "coach_dashboard.php";
}else{
    header("Location: login.php");
    exit();
}

ensureTrainingLogColumns($conn);

$sql = "SELECT * FROM training_log
        WHERE athlete_id='$athlete_id'
        ORDER BY training_date DESC
        LIMIT 1";

$result = mysqli_query($conn, $sql);

$error_message = "";
$load = "";
$risk = "";
$muscle_group = "";
$workout_type = "";
$exercise_done = "";
$training_guidance = "";
$recommendation_text = "";

if(!$result){
    $error_message = "SQL Error: " . mysqli_error($conn);
}elseif(mysqli_num_rows($result) == 0){
    $error_message = "No training records found for athlete ID: " . $athlete_id;
}else{
    $data = mysqli_fetch_assoc($result);
    $load = $data['muscle_load'];
    $risk = injuryRisk($load);
    $muscle_group = $data['muscle_group'] ?? "";
    $workout_type = $data['workout_type'] ?? "";
    $exercise_done = $data['exercise_done'] ?? "";
    $training_guidance = $data['training_guidance'] ?? "";

    if($risk == "HIGH"){
        $recommendation_text = "Reduce training intensity immediately and focus on recovery before repeating ".$muscle_group." training.";
    }elseif($risk == "MEDIUM"){
        $recommendation_text = "Monitor recovery, lower the workload, and use controlled movement during ".$muscle_group." sessions.";
    }else{
        $recommendation_text = "Continue normal training, maintain good technique, and keep following the planned ".$muscle_group." guidance.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Recommendations</title>

<link rel="stylesheet" href="css/style.css?v=2">


</head>
<body>

<h2>Injury Risk Analysis</h2>

<?php if($error_message){ ?>

<p class="message warning"><?php echo htmlspecialchars($error_message); ?></p>

<?php }else{ ?>

<p>Muscle Load: <?php echo htmlspecialchars($load); ?>%</p>

<?php if(!empty($muscle_group)){ ?>
<p>Muscle Group: <?php echo htmlspecialchars($muscle_group); ?></p>
<?php } ?>

<?php if(!empty($workout_type)){ ?>
<p>Workout Type: <?php echo htmlspecialchars($workout_type); ?></p>
<?php } ?>

<?php if(!empty($exercise_done)){ ?>
<p>Workout Done: <?php echo htmlspecialchars($exercise_done); ?></p>
<?php } ?>

<?php if(!empty($training_guidance)){ ?>
<p>Training Guidance: <?php echo htmlspecialchars($training_guidance); ?></p>
<?php } ?>

<p>Risk Level: <?php echo htmlspecialchars($risk); ?></p>

<?php

if($risk=="HIGH"){

    echo "<h3>Recommendation:</h3>";
    echo "<p class='message danger'>".htmlspecialchars($recommendation_text)."</p>";

}

elseif($risk=="MEDIUM"){

    echo "<h3>Recommendation:</h3>";
    echo "<p class='message warning'>".htmlspecialchars($recommendation_text)."</p>";

}

else{

    echo "<h3>Recommendation:</h3>";
    echo "<p class='message success'>".htmlspecialchars($recommendation_text)."</p>";

}

?>

<?php } ?>

<?php if(isset($_SESSION['coach_id'])){ ?>
<a class="back" href="coach_recommendations.php">Back to Injury Analysis</a>
<?php } ?>

<a class="back" href="<?php echo $dashboard_link; ?>">Back to Dashboard</a>

</body>
</html>
