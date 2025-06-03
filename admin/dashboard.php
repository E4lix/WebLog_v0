<!-- Inclusion des fichiers nécessaires -->
<?php include('../config.php'); ?> <!-- Inclusion du fichier de configuration pour la connexion à la base de données -->
<?php include(ROOT_PATH . '/includes/admin_functions.php'); ?> <!-- Inclusion des fonctions administratives -->
<?php include(ROOT_PATH . '/includes/admin/head_section.php'); ?> <!-- Inclusion de l'en-tête de la section admin -->

<title>Admin | Dashboard</title> <!-- Titre de la page -->
</head>

<body>
    <!-- En-tête de la page admin -->
    <div class="header">
        <div class="logo">
            <a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">
                <h1>MyWebSite - Admin</h1> <!-- Titre du site dans l'en-tête -->
            </a>
        </div>

        <!-- Vérification de la session utilisateur connecté, affichage du nom et bouton de déconnexion -->
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="user-info">
                <span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp; <!-- Affichage du nom d'utilisateur -->
                <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a> <!-- Lien de déconnexion -->
            </div>
        <?php endif ?>
    </div>

    <!-- Contenu de la page dashboard -->
    <div class="container dashboard">
        <h1>Welcome</h1> <!-- Message de bienvenue -->

        <!-- Statistiques du site web -->
        <div class="stats">
            <!-- Nombre d'utilisateurs -->
            <?php $total_users = getNumberOfUsers($conn); ?> <!-- Récupération du nombre total d'utilisateurs -->
            <a href="users.php" class="first">
                <span><?= $total_users ?></span> <br> <!-- Affichage du nombre d'utilisateurs -->
                <pan>Registered users</span> <!-- Légende pour le nombre d'utilisateurs -->
            </a>

            <!-- Nombre de postes publiés -->
            <?php $total_posts = getNumberOfPosts($conn); ?> <!-- Récupération du nombre total de posts -->
            <a href="posts.php">
                <span><?= $total_posts ?></span> <br> <!-- Affichage du nombre de posts -->
                <span>Published posts</span> <!-- Légende pour le nombre de posts -->
            </a>

            <!-- Nombre de commentaires -->
            <a>
                <span>0</span> <br> <!-- Affichage du nombre de commentaires (actuellement fixé à 0) -->
                <span>Published comments</span> <!-- Légende pour le nombre de commentaires -->
            </a>
        </div>
        <br><br><br>

        <!-- Boutons d'ajout d'utilisateurs ou de postes -->
        <div class="buttons">
            <a href="users.php">Add Users</a> <!-- Lien pour ajouter des utilisateurs -->
            <a href="posts.php">Add Posts</a> <!-- Lien pour ajouter des posts -->
        </div>
    </div>
</body>

</html>
