<?php

include "database/connection.php";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sport = $_POST['sport'];

    $sql = "INSERT INTO athlete
    (full_name,email,password,sport)

    VALUES

    ('$name','$email','$password','$sport')";

    mysqli_query($conn,$sql);

    echo "Registration Successful";
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Register Athlete</title>

<link rel="stylesheet" href="css/style.css">


</head>
<body>

<h2>Register Athlete</h2>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required><br><br>

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<input type="text" name="sport" placeholder="Sport" required><br><br>

<button name="register">Register</button>

</form>

</body>
</html>