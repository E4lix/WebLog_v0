<div class="navbar">
	<div class="logo_div">
		<h1>MyWebSite</h1>
	</div>
	<ul>
	  <li><a class="active" href="index.php">Home</a></li>
	  <li><a class="active" href="#news">News</a></li>
	  <li><a href="#contact">Contact</a></li>
	  <li><a href="#about">About</a></li>
	  <!-- Vérification de l'existence des caractéristiques du user + si il est admin ou pas -->
	  <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'Admin'): ?>
    	<li><a href="#admin">Administration</a></li>
	  <?php endif; ?>

	</ul>
</div>