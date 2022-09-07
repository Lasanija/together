<?php
require_once '../private/connect.inc';
require_once '../src/UserDbRepository.php';
require_once '../src/User.php';
require_once '../src/functions.inc';

session_start();

if (!isset($_POST['email']) || !isset($_POST['password'])) {
  redirect(LOGIN_PAGE);
}

$email = $_POST['email'];
$pass = $_POST['password'];

try {
    /** @var PDO $pdo */
    $repository = new UserDbRepository($pdo);
    $user = new User($repository);

  if ($user->canLogin($email,$pass)) {
    $_SESSION['user'] = $user->getMultiple(['email'=>$email],['id','email','name']);
      $_SESSION['user'] = reset( $_SESSION['user']);
    redirect(LOGIN_PAGE);
  }
  else {
    echo "<div>User don't find <a href='register.php'> Sing up</a></div>";
    echo "<div>Password is not correct! <a href='reset_password.php'>Forgot the password</a></div>";
  }
}
catch (Exception $e) {
  $_SESSION['messages']['error'][] = $e->getMessage();
  redirect(LOGIN_PAGE);
}
