<?php
require_once('database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $db->query($sql);
    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {

        if ($row['password'] == $password) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['authenticate_success'] = true;
            header('Location: dashboard.php');
        } else {
            $_SESSION['authenticate_success'] = false;
            header('Location: login.php');
        }
    } else {
        $_SESSION['authenticate_success'] = false;
        header('Location: login.php');
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
    <title>Log in</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth_body">
    <form class="auth-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <h3>Please Login</h3>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required placeholder="Enter your password">
        </div>

        <input type="submit" value="Log in" class="auth-submit">

        <div class="auth-directory">
            <p>Don't have an account yet?</p>
            <a href="index.php">Register now</a>
        </div>
    </form>

</body>

</html>