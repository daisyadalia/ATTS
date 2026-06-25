<?php
session_start();
include "database/connection.php";

$message = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM trainers
            WHERE email='$email'
            AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $trainer = mysqli_fetch_assoc($result);

        $_SESSION['trainer_id'] = $trainer['trainer_id'];
        $_SESSION['fullname'] = $trainer['fullname'];

        header("Location: coach_dashboard.php");
        exit();
    }
    else
    {
        $message = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Coach Login</title>

    <style>
        body{
            font-family:Arial,sans-serif;
            background:#f4f4f4;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .login-box{
            background:white;
            padding:30px;
            width:350px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:10px;
            margin:10px 0;
        }

        button{
            width:100%;
            padding:10px;
            background:#0f172a;
            color:white;
            border:none;
            cursor:pointer;
        }

        .error{
            color:red;
            text-align:center;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Coach Login</h2>

    <?php if($message != "") { ?>
        <p class="error"><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST">

        <input type="email"
               name="email"
               placeholder="Enter Email"
               required>

        <input type="password"
               name="password"
               placeholder="Enter Password"
               required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

</div>

</body>
</html>
