<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- Include des fichiers et fonctions pour la page -->
<?php include_once('config.php'); ?>
<?php include_once('includes/public/head_section.php'); ?>
<?php include_once('includes/all_functions.php') ?>

<title>Mon Blog | À Propos</title>
</head>

<body>
    <div class="container">
        <!-- Navbar -->
        <?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
        <!-- // Navbar -->
    </div>

<!-- Footer -->
<?php include(ROOT_PATH . '/includes/public/footer.php'); ?>
<!-- // Footer -->