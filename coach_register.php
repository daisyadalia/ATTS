<?php

include "database/connection.php";

$message = "";
$message_type = "success";

if(isset($_POST['register'])){

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $specialization = $_POST['specialization'];

    $sql = "INSERT INTO coach (full_name, email, password, specialization)
            VALUES ('$full_name', '$email', '$password', '$specialization')";

    if(mysqli_query($conn, $sql)){
        $message = "Coach registered successfully. You can now login.";
    } else {
        $message = "Registration failed. Please try again.";
        $message_type = "danger";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Coach Registration</title>

    <link rel="stylesheet" href="css/style.css?v=2">

</head>

<body>

<div class="container">

    <h2>Coach Registration</h2>

    <?php if($message){ ?>
        <p class="message <?php echo $message_type; ?>"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST">

        <label>Full Name</label><br>
        <input type="text" name="full_name" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <label>Specialization</label><br>
        <input type="text" name="specialization" required><br><br>

        <button type="submit" name="register">Register Coach</button>

    </form>

    <br>

    <a href="coach_login.php">Already have an account? Login</a>

</div>

</body>

</html>
