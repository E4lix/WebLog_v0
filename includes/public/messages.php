<!-- Fonction qui test si un message est enregistré dans la session et l'affiche si c'est le cas -->
<?php if (isset($_SESSION['message'])) : ?>
      <div class="message" >
      	<p>
          <?php 
          	// Affiche le message stocké dans la session
          	echo $_SESSION['message']; 
          	// Supprime ensuite ce message de la session pour ne pas le réafficher
          	unset($_SESSION['message']);
          ?>
      	</p>
      </div>
<?php endif ?>
