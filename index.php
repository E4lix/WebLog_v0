<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php include('config.php'); ?>
<?php include(ROOT_PATH . '/includes/public/head_section.php'); ?>
<?php include(ROOT_PATH . '/includes/public/registration_login.php'); ?>
<?php include(ROOT_PATH . '/includes/all_functions.php'); ?>
<?php include(ROOT_PATH . '/includes/public/messages.php'); ?>

<?php $posts = getPublishedPosts($conn); ?>

<title>Mon Blog | Accueil</title>

</head>

<body>

    <!-- Container -->
	<div class="container">

		<!-- Navbar -->
		<?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
		<!-- // Navbar -->

		<!-- Banner -->
		<?php include(ROOT_PATH . '/includes/public/banner.php'); ?>
		<!-- // Banner -->

		<!-- Content -->
		<div class="content">

            <!-- On parcours les postes du tableau posts et on les affiche sous format défini -->
			<?php foreach ($posts as $post): ?>
                <div class="post" style="margin: 20px; text-align: center;">
                    <!-- Image de couverture -->
                    <img src="static/images/<?= htmlspecialchars($post['image']) ?>" style="width:100%; max-height:200px; object-fit:cover;">

                    <!-- Titre -->
                    <h3>
                        <a href="single_post.php?slug=<?= urlencode($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h3>

                    <!-- Informations sur l'article -->
                    <p class="info">
                        Publié par <?= htmlspecialchars($post['username']) ?> le <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                    </p>

                    <!-- Contenu de l'article -->
                    <p><?= mb_strimwidth(strip_tags($post['body']), 0, 150, '...') ?></p>

                    <!-- Lien vers l'article -->
                    <a href="single_post.php?slug=<?= urlencode($post['slug']) ?>">
                        <?= htmlspecialchars($post['title']) ?>
                    </a>
                
                </div>
            <?php endforeach; ?>
 
            <!-- Si aucun article dans posts, on affiche un message -->
            <?php if (empty($posts)): ?>
                <p>Aucun article publié pour l’instant.</p>
            <?php endif; ?>
		</div>
		<!-- // Content -->


	</div>
	<!-- // Container -->

	<!-- Footer -->
	<?php include(ROOT_PATH . '/includes/public/footer.php'); ?>
	<!-- // Footer -->