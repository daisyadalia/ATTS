<<<<<<< HEAD
<?php

session_start();

include "database/connection.php";

$message = "";

if(isset($_POST['admin_login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'admin'");

    if($table_check && mysqli_num_rows($table_check) > 0){

        $sql = "SELECT * FROM admin WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $admin = $result ? mysqli_fetch_assoc($result) : null;

        if($admin && password_verify($password, $admin['password'])){
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['full_name'];

            header("Location: admin_dashboard.php");
            exit();
        }else{
            $message = "Invalid admin email or password.";
        }

    }else{

        if($email == "admin@atts.com" && $password == "admin123"){
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_name'] = "System Admin";

            header("Location: admin_dashboard.php");
            exit();
        }else{
            $message = "Invalid admin login. Default admin is admin@atts.com / admin123.";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<div class="login-container admin-login-panel">

<h2>Admin Login</h2>

<?php if($message){ ?>
<p class="message danger"><?php echo htmlspecialchars($message); ?></p>
<?php } ?>

<form method="POST">

<input
type="email"
name="email"
placeholder="Admin Email"
required>

<input
type="password"
name="password"
placeholder="Admin Password"
required>

<button type="submit" name="admin_login">Login as Admin</button>

</form>

<p class="register-text">
Need an admin account?
<a href="admin_register.php">Register Admin</a>
</p>

<p class="register-text">
Return to
<a href="login.php">Athlete and Coach Login</a>
</p>

</div>

</body>
</html>
=======
<?php
session_start();
include "database/connection.php";

$message = "";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        $admin = mysqli_fetch_assoc($result);

        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['username'] = $admin['username'];

        header("Location: admin_dashboard.php");
        exit();
    }
    else
    {
        $message = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <style>
        body{
            font-family: Arial, sans-serif;
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
            border:1px solid #ccc;
            border-radius:5px;
        }

        button{
            width:100%;
            padding:10px;
            background:#1e293b;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        .error{
            color:red;
            text-align:center;
            margin-bottom:10px;
        }
    </style>
</head>
<body>

<div class="login-box">

    <h2>Admin Login</h2>

    <?php if($message != "") { ?>
        <div class="error"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST">

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

</div>

</body>
</html>
>>>>>>> b941e995365861534cccaa45ebb88522f1914584
