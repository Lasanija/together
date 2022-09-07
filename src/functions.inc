<?php

use JetBrains\PhpStorm\NoReturn;

const LOGIN_PAGE = 'index.php';
const REGISTER_PAGE = 'register.php';
const DB_COMMENTS_CSV_PATH = '../database/comments.csv';

#[NoReturn] function redirect(string $url): void
{
    header("Location: $url");
    exit();
}