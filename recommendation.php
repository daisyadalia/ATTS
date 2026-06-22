<?php

session_start();

include "database/connection.php";
include "analysis/biomechanics.php";

$athlete_id = $_SESSION['athlete_id'];

$sql = "SELECT * FROM training_log
        WHERE athlete_id='$athlete_id'
        ORDER BY training_date DESC
        LIMIT 1";

$result = mysqli_query($conn,$sql);

$data = mysqli_fetch_assoc($result);

$load = $data['muscle_load'];

$risk = injuryRisk($load);

?>

<!DOCTYPE html>
<html>
<head>
<title>Recommendations</title>

<link rel="stylesheet" href="css/style.css">


</head>
<body>

<h2>Injury Risk Analysis</h2>

<p>Muscle Load: <?php echo $load; ?>%</p>

<p>Risk Level: <?php echo $risk; ?></p>

<?php

if($risk=="HIGH"){

    echo "<h3>Recommendation:</h3>";
    echo "Reduce training intensity immediately.";

}

elseif($risk=="MEDIUM"){

    echo "<h3>Recommendation:</h3>";
    echo "Monitor recovery and reduce workload.";

}

else{

    echo "<h3>Recommendation:</h3>";
    echo "Continue normal training.";

}

?>

<br><br>

<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>