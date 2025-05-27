<div class="navbar">
	<div class="logo_div">
		<h1>Mon site web</h1>
	</div>
	<ul>
	  <li><a class="active" href="index.php">Home</a></li>
	  <li><a class="active" href="news.php">News</a></li>
	  <li><a class="active" href="contact.php">Contact</a></li>
	  <li><a class="active" href="about.php">About</a></li>

	  <!-- Onglet supplémentaire pour les administrateurs (vérification par requête php) -->
	  <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Admin'): ?>
    	<li><a href="<?= BASE_URL ?>/admin/dashboard.php">Administration</a></li>
	  <?php endif; ?>
	</ul>
</div>