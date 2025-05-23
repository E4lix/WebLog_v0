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

<title>Mon Blog | Home </title>

</head>

<body>

	<div class="container">

		<!-- Navbar -->
		<?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
		<!-- // Navbar -->

		<!-- Banner -->
		<?php include(ROOT_PATH . '/includes/public/banner.php'); ?>
		<!-- // Banner -->

		<!-- content -->
		<div class="content">
			<?php foreach ($posts as $post): ?>
                <div class="post" style="margin: 20px; text-align: center;">
                    <img src="static/images/<?= htmlspecialchars($post['image']) ?>" style="width:100%; max-height:200px; object-fit:cover;">
                    <h3>
                        <a href="single_post.php?slug=<?= urlencode($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h3>
                    <p class="info">
                        Publié par <?= htmlspecialchars($post['username']) ?> le <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                    </p>
                    <p><?= mb_strimwidth(strip_tags($post['body']), 0, 150, '...') ?></p>
                    <a href="single_post.php?slug=<?= urlencode($post['slug']) ?>">
                        <?= htmlspecialchars($post['title']) ?>
                    </a>
                
                </div>
            <?php endforeach; ?>
 
            <?php if (empty($posts)): ?>
                <p>Aucun article publié pour l’instant.</p>
            <?php endif; ?>
		</div>
		<!-- // content -->


	</div>
	<!-- // container -->


	<!-- Footer -->
	<?php include(ROOT_PATH . '/includes/public/footer.php'); ?>
	<!-- // Footer -->