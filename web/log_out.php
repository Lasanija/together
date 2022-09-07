<?php
session_start();
require_once '../src/functions.inc';

unset($_SESSION['user']);
unset($_SESSION['pass']);
session_destroy();
redirect('index.php');