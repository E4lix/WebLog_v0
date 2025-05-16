<?php
//Create session per user:
session_start();

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');


define('DB_NAME', 'WebLog');
define('DB_USER', 'weblog_user');
define('DB_PASS', '');

// connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//define some constants:
define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost:8000/');

?>