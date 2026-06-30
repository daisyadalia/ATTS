<?php

session_start();

include "database/connection.php";

$message = "";
$message_type = "success";
$can_register = true;

$create_table_sql = "CREATE TABLE IF NOT EXISTS admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

mysqli_query($conn, $create_table_sql);

$admin_count_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM admin");
$admin_count = $admin_count_result ? mysqli_fetch_assoc($admin_count_result)['total'] : 0;

if($admin_count > 0 && !isset($_SESSION['admin_id'])){
    $can_register = false;
    $message = "Admin registration is locked. Please login as an admin to add another admin.";
    $message_type = "warning";
}

if($can_register && isset($_POST['register_admin'])){

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (full_name, email, password)
            VALUES ('$full_name', '$email', '$password')";

    if(mysqli_query($conn, $sql)){
        $message = "Admin registered successfully. You can now login.";
        $message_type = "success";
    }else{
        $message = "Registration failed. The email may already be registered.";
        $message_type = "danger";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Registration</title>
<link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>

<div class="container admin-login-panel">

<h2>Admin Registration</h2>

<?php if($message){ ?>
<p class="message <?php echo $message_type; ?>"><?php echo htmlspecialchars($message); ?></p>
<?php } ?>

<?php if($can_register){ ?>

<form method="POST">

<input
type="text"
name="full_name"
placeholder="Full Name"
required>

<input
type="email"
name="email"
placeholder="Admin Email"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit" name="register_admin">Register Admin</button>

</form>

<?php } ?>

<p class="register-text">
Already have an admin account?
<a href="admin_login.php">Login Here</a>
</p>

<?php if(isset($_SESSION['admin_id'])){ ?>
<a class="back" href="admin_dashboard.php">Back to Dashboard</a>
<?php } ?>

</div>

</body>
</html>
