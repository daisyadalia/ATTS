<?php

session_start();

include "database/connection.php";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM athlete WHERE email='$email'";

    $result = mysqli_query($conn,$sql);

    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password,$user['password'])){

        $_SESSION['athlete_id'] = $user['athlete_id'];
        $_SESSION['name'] = $user['full_name'];

        header("Location: dashboard.php");
        exit();

    } else {

        echo "Invalid Email or Password";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>ATTS Login</title>

<link rel="stylesheet" href="css/style.css">

</head>
<body>

<h2>Login</h2>

<form method="POST">

<input type="email"
name="email"
placeholder="Email"
required>

<br><br>

<input type="password"
name="password"
placeholder="Password"
required>

<br><br>

<button name="login">
Login
</button>

</form>

</body>
</html>