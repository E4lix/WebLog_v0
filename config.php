<?php
// Create session per user, if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');

// Ajout des informations de l'utilisateurs créé pour l'utilisation de mysql sur la bdd du site
define('DB_NAME', 'WebLog');
define('DB_USER', 'weblog_user');
define('DB_PASS', '');

// Connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Define some constants:
define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost:8000/');

?>