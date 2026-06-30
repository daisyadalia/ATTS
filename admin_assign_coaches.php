<?php

session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

include "database/connection.php";

$message = "";
$message_type = "success";

if(isset($_POST['assign_coach'])){
    $athlete_id = mysqli_real_escape_string($conn, $_POST['athlete_id']);
    $coach_id = mysqli_real_escape_string($conn, $_POST['coach_id']);

    $sql = "UPDATE athlete SET coach_id = '$coach_id' WHERE athlete_id = '$athlete_id'";

    if(mysqli_query($conn, $sql)){
        $message = "Coach assigned successfully.";
    }else{
        $message = "Coach could not be assigned. Please try again.";
        $message_type = "danger";
    }
}

if(isset($_POST['auto_assign'])){
    $sql = "UPDATE athlete
            JOIN coach
                ON LOWER(TRIM(athlete.sport)) = LOWER(TRIM(coach.specialization))
            SET athlete.coach_id = coach.coach_id
            WHERE athlete.coach_id IS NULL OR athlete.coach_id = ''";

    if(mysqli_query($conn, $sql)){
        $message = "Matching coaches assigned to athletes by sport.";
    }else{
        $message = "Auto assignment failed. Please try again.";
        $message_type = "danger";
    }
}

$athletes_sql = "SELECT athlete.*, coach.full_name AS coach_name
                 FROM athlete
                 LEFT JOIN coach ON athlete.coach_id = coach.coach_id
                 ORDER BY athlete.sport ASC, athlete.full_name ASC";

$athletes_result = mysqli_query($conn, $athletes_sql);
$coaches_result = mysqli_query($conn, "SELECT * FROM coach ORDER BY specialization ASC, full_name ASC");

$coaches = [];

if($coaches_result){
    while($coach = mysqli_fetch_assoc($coaches_result)){
        $coaches[] = $coach;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Assign Coaches</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<h2>Assign Coaches by Sport</h2>

<?php if($message){ ?>
<p class="message <?php echo $message_type; ?>"><?php echo htmlspecialchars($message); ?></p>
<?php } ?>

<form method="POST">
    <button type="submit" name="auto_assign">Auto Assign Matching Coaches</button>
</form>

<table>
<tr>
    <th>Athlete</th>
    <th>Sport</th>
    <th>Current Coach</th>
    <th>Assign Matching Coach</th>
</tr>

<?php if($athletes_result && mysqli_num_rows($athletes_result) > 0){ ?>

    <?php while($athlete = mysqli_fetch_assoc($athletes_result)){ ?>
    <tr>
        <td><?php echo htmlspecialchars($athlete['full_name']); ?></td>
        <td><?php echo htmlspecialchars($athlete['sport']); ?></td>
        <td><?php echo !empty($athlete['coach_name']) ? htmlspecialchars($athlete['coach_name']) : "Not Assigned"; ?></td>
        <td>
            <form class="inline-form" method="POST">
                <input type="hidden" name="athlete_id" value="<?php echo htmlspecialchars($athlete['athlete_id']); ?>">

                <select name="coach_id" required>
                    <option value="">Choose coach</option>
                    <?php foreach($coaches as $coach){ ?>
                        <?php
                            $sport_match = strtolower(trim($coach['specialization'])) == strtolower(trim($athlete['sport']));
                        ?>
                        <option
                            value="<?php echo htmlspecialchars($coach['coach_id']); ?>"
                            <?php echo $sport_match ? "" : "disabled"; ?>
                        >
                            <?php echo htmlspecialchars($coach['full_name']." - ".$coach['specialization']); ?>
                        </option>
                    <?php } ?>
                </select>

                <button type="submit" name="assign_coach">Assign</button>
            </form>
        </td>
    </tr>
    <?php } ?>

<?php }else{ ?>

    <tr>
        <td colspan="4">No athletes found.</td>
    </tr>

<?php } ?>

</table>

<a class="back" href="admin_dashboard.php">Back to Dashboard</a>

</body>
</html>
