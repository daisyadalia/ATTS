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
