<?php
require_once '../src/UserDbRepository.php';
require '../private/connect.inc';
require_once '../src/User.php';
require_once '../src/functions.inc';

session_start();


if (!isset($_POST['email']) || !isset($_POST['password'])) {
    redirect(REGISTER_PAGE);
}

$email = $_POST['email'];
$pass = $_POST['password'];
$name = $_POST['name'];

try {
    /** @var PDO $pdo */
    $repository = new UserDbRepository($pdo);
    $newUser = new User($repository);
    $newUser->add($email, $pass, $name);

} catch (Exception $e) {
    $_SESSION['messages']['error'][] = $e->getMessage();
    redirect(REGISTER_PAGE);
}