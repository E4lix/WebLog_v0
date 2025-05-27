<!-- Include des fichiers -->
<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/includes/admin/head_section.php'); ?>

<title>Admin | Dashboard</title>
</head>

<body>
	<!-- Header de la page admin -->
	<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">
				<h1>MyWebSite - Admin</h1>
			</a>
		</div>

		<!-- Vérification de la session utilisateur connecté, affichage du nom et bouton de déconnexion -->
		<?php if (isset($_SESSION['user'])) : ?>
			<div class="user-info">
				<span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp;
				<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
			</div>
		<?php endif ?>
	</div>

	<!-- Contenu de la page dashboard -->
	<div class="container dashboard">
		<h1>Welcome</h1>

		<!-- Statistiques du site web -->
		<div class="stats">
			<!-- Nombre d'utilisateurs -->
			<?php $total_users = getNumberOfUsers($conn); ?>
			<a href="users.php" class="first">
				<span><?= $total_users ?></span> <br>
				<pan>Registered users</span>
			</a>

			<!-- Nombre de postes publiés -->
			<?php $total_posts = getNumberOfPosts($conn); ?>
			<a href="posts.php">
				<span><?= $total_posts ?></span> <br>
				<span>Published posts</span>
			</a>

			<!-- Nombre de commentaires -->
			<a>
				<span>0</span> <br>
				<span>Published comments</span>
			</a>
		</div>
		<br><br><br>

		<!-- Boutons d'ajout d'utilisateurs ou de postes -->
		<div class="buttons">
			<a href="users.php">Add Users</a>
			<a href="posts.php">Add Posts</a>
		</div>
	</div>
</body>

</html>
