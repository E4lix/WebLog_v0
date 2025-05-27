<?php
// Crée une session pour chaque utilisateur, si elle n'a pas déjà été démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Démarre une nouvelle session ou reprend une session existante
}

// Définit le type de base de données à utiliser (ici, MySQL)
define('DB_TYPE', 'mysql');
// Définit l'hôte de la base de données (ici, 'localhost' signifie que la base de données est sur le même serveur)
define('DB_HOST', 'localhost');
// Définit le port utilisé pour se connecter à la base de données (3306 est le port par défaut pour MySQL)
define('DB_PORT', '3306');

// Ajoute les informations nécessaires pour se connecter à la base de données
define('DB_NAME', 'WebLog'); // Nom de la base de données
define('DB_USER', 'weblog_user'); // Nom d'utilisateur pour se connecter à la base de données
define('DB_PASS', ''); // Mot de passe pour l'utilisateur (ici, il est vide)

// Se connecte à la base de données en utilisant les informations définies ci-dessus
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Définit quelques constantes supplémentaires :
define('ROOT_PATH', realpath(dirname(__FILE__))); // Définit le chemin absolu du dossier contenant ce fichier
define('BASE_URL', 'http://localhost:8000'); // Définit l'URL de base du site web
?>
