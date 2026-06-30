<?php

include "database/connection.php";

$message = "";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sport = $_POST['sport'];
    $coach_id = "NULL";

    $coach_sql = "SELECT coach_id FROM coach
                  WHERE LOWER(TRIM(specialization)) = LOWER(TRIM('$sport'))
                  ORDER BY coach_id ASC
                  LIMIT 1";

    $coach_result = mysqli_query($conn, $coach_sql);

    if($coach_result && mysqli_num_rows($coach_result) > 0){
        $coach = mysqli_fetch_assoc($coach_result);
        $coach_id = $coach['coach_id'];
    }

    $sql = "INSERT INTO athlete
    (full_name,email,password,sport,coach_id)

    VALUES

    ('$name','$email','$password','$sport',$coach_id)";

    if(mysqli_query($conn,$sql)){
        $message = "Registration successful. You can now login.";
    }else{
        $message = "Registration failed. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Register Athlete</title>

    <link rel="stylesheet" href="css/style.css?v=2">


</head>
<body>

<h2>Register Athlete</h2>

<?php if($message){ ?>
<p class="message success"><?php echo $message; ?></p>
<?php } ?>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required><br><br>

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<input type="text" name="sport" placeholder="Sport" required><br><br>

<button name="register">Register</button>

</form>

<a href="login.php">Already have an account? Login</a>

</body>
</html>
