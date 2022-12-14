<?php
// @todo Check for $_POST['token']
require_once '../private/connect.inc';
require_once '../src/CommentDbRepository.php';
require_once '../src/Comment.php';

$a = $_POST['token'] ?? NULL;
$token = json_decode(file_get_contents("php://input"));
/** @var PDO $pdo */
$repository = new CommentDbRepository($pdo);
$comment = new Comment($repository);
$comment->delete($token);

echo json_encode($token);
