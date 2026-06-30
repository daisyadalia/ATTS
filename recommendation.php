<?php

session_start();

include "database/connection.php";
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

$sql = "SELECT * FROM training_log
        WHERE athlete_id='$athlete_id'
        ORDER BY training_date DESC
        LIMIT 1";

$result = mysqli_query($conn, $sql);

$error_message = "";
$load = "";
$risk = "";

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

<p>Risk Level: <?php echo htmlspecialchars($risk); ?></p>

<?php

if($risk=="HIGH"){

    echo "<h3>Recommendation:</h3>";
    echo "<p class='message danger'>Reduce training intensity immediately.</p>";

}

elseif($risk=="MEDIUM"){

    echo "<h3>Recommendation:</h3>";
    echo "<p class='message warning'>Monitor recovery and reduce workload.</p>";

}

else{

    echo "<h3>Recommendation:</h3>";
    echo "<p class='message success'>Continue normal training.</p>";

}

?>

<?php } ?>

<?php if(isset($_SESSION['coach_id'])){ ?>
<a class="back" href="coach_recommendations.php">Back to Injury Analysis</a>
<?php } ?>

<a class="back" href="<?php echo $dashboard_link; ?>">Back to Dashboard</a>

</body>
</html>
