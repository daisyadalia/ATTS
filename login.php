<?php

session_start();

include "database/connection.php";

$athlete_message = "";
$coach_message = "";

if(isset($_POST['athlete_login'])){

    $email = $_POST['athlete_email'];
    $password = $_POST['athlete_password'];

    $sql = "SELECT * FROM athlete WHERE email='$email'";

    $result = mysqli_query($conn,$sql);

    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password,$user['password'])){

        $_SESSION['athlete_id'] = $user['athlete_id'];
        $_SESSION['name'] = $user['full_name'];

        header("Location: dashboard.php");
        exit();

    } else {

        $athlete_message = "Invalid athlete email or password.";

    }
}

if(isset($_POST['coach_login'])){

    $email = $_POST['coach_email'];
    $password = $_POST['coach_password'];

    $sql = "SELECT * FROM coach WHERE email='$email'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $coach = mysqli_fetch_assoc($result);

        if(password_verify($password, $coach['password'])){

            $_SESSION['coach_id'] = $coach['coach_id'];
            $_SESSION['coach_name'] = $coach['full_name'];

            header("Location: coach_dashboard.php");
            exit();

        }else{

            $coach_message = "Incorrect coach password.";

        }

    }else{

        $coach_message = "Coach account not found.";

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>ATTS Login</title>

<link rel="stylesheet" href="css/style.css?v=2">

</head>

<body>

<div class="auth-page">

<h2>Athlete Training Target System</h2>

<div class="login-container">

<h3>Athlete Login</h3>

<?php if($athlete_message){ ?>
<p class="message danger"><?php echo $athlete_message; ?></p>
<?php } ?>

<form method="POST">

<input
type="email"
name="athlete_email"
placeholder="Enter Email"
required>

<input
type="password"
name="athlete_password"
placeholder="Enter Password"
required>

<button type="submit" name="athlete_login">
Athlete Login
</button>

</form>

<p class="register-text">
Don't have an account?
<a href="register.php">Register Here</a>
</p>

</div>

<div class="login-container coach-login-panel">

<h3>Coach Login</h3>

<?php if($coach_message){ ?>
<p class="message danger"><?php echo $coach_message; ?></p>
<?php } ?>

<form method="POST">

<input
type="email"
name="coach_email"
placeholder="Enter Coach Email"
required>

<input
type="password"
name="coach_password"
placeholder="Enter Coach Password"
required>

<button type="submit" name="coach_login">
Coach Login
</button>

</form>

<p class="register-text">
Don't have a coach account?
<a href="coach_register.php">Register Here</a>
</p>

</div>

<p class="register-text">
Admin user?
<a href="admin_login.php">Login Here</a>
</p>

</div>

</body>

</html>
