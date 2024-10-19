<?php
require_once('database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($db->query($sql)) {
        $_SESSION['registration_success'] = true;
        header('Location: login.php');
    } else {
        $_SESSION['registration_success'] = false;
        header('Location: index.php');
    }

    $db->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth_body">
    <form class="auth-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <h3>Please Register</h3>

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required placeholder="Enter your name">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required placeholder="Enter your password">
        </div>

        <input type="submit" value="Sign Up" class="auth-submit">

        <div class="auth-directory">
            <p>Already have an account?</p>
            <a href="login.php">Log in now</a>
        </div>
    </form>

</body>

</html>