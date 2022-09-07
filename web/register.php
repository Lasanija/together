<?php
session_start();

if (isset($_SESSION['user'])) {
    require_once '../src/functions.inc';
    redirect('LOGIN_PAGE');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Sing up</title>
    <style>
        .errors > div {
            border: 1px solid red;
            color: red;
        }
    </style>
</head>
<body>
<?php
if (isset($_SESSION['messages']['error'])) {
    print '<div class="errors">';

    foreach ($_SESSION['messages']['error'] as $error) {
        print "<div>$error</div>";
    }

    print '</div>';

    unset($_SESSION['messages']['error']);
}
?>
<section class="log-in">
    <a href="index.php"><img src="assets/logo.svg" title="Go to main page"></a>
    <h1>Register now!</h1>
    <form action="sing_up.php" method="post">
        <input type="text" name="name" placeholder="Enter your name">
        <input type="text" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <input type="submit" value="Register me" class="btn">
    </form>
    <div>Have an account? <a href="log_in.html">Log in</a></div>
</section>
</body>
</html>

