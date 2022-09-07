<?php

/**
 * @file
 * Receive comment update data by ajax.
 */
require_once '../private/connect.inc';
require_once '../src/CommentDbRepository.php';
require_once '../src/Comment.php';

$data = (array)json_decode(file_get_contents("php://input"));
/** @var PDO $pdo */
$repository = new CommentDbRepository($pdo);
$comment = new Comment($repository);
$comment->update($data['token'], $data['text']);

echo json_encode($data);
