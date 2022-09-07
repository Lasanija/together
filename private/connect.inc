<?php

/**
 * @file
 * Connect to DB.
 */

require_once 'settings.inc';

try {
    $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DB, DB_USER);
}catch (Exception){
    die('db error');
}

// Create table users
$pdo->exec('CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) UNIQUE NOT NULL, name VARCHAR(255), password VARCHAR(32) NOT NULL, reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)');

//Create table comments
$pdo->exec('CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, text VARCHAR(255) NOT NULL, user_id VARCHAR(255) NOT NULL,token VARCHAR(32) UNIQUE NOT NULL , create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)');

