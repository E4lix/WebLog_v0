<?php  
// Inclusion du fichier de configuration pour établir la connexion à la base de données
include('../config.php'); 

// Inclusion des fonctions administratives pour gérer les opérations liées aux posts
include(ROOT_PATH . '/includes/admin_functions.php'); 

// Inclusion des fonctions spécifiques aux posts
include(ROOT_PATH . '/admin/post_functions.php'); 

// Inclusion de l'en-tête de la section admin pour le rendu de la page
include(ROOT_PATH . '/includes/admin/head_section.php'); 

// Récupération de tous les sujets disponibles pour les posts
$topics = getAllTopics(); // Fonction qui récupère tous les sujets de la base de données

?>

<!-- Début de la structure HTML de la page -->
<title>Admin | Create Post</title>
</head>
<body>

    <!-- Inclusion de la barre de navigation pour l'admin -->
    <?php include(ROOT_PATH . '/includes/admin/header.php') ?>

    <div class="container content">
        
        <!-- Menu latéral pour les actions administratives -->
        <?php include(ROOT_PATH . '/includes/admin/menu.php') ?>

        <!-- Formulaire central pour créer ou éditer un post -->
        <div class="action create-post-div">
            <h1 class="page-title">Create/Edit Post</h1>

            <form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_post.php'; ?>" >

                <!-- Inclusion des erreurs de validation pour le formulaire -->
                <?php include(ROOT_PATH . '/includes/public/errors.php') ?>

                <!-- Si on est en mode édition, on cache l'ID du post à éditer -->
                <?php if ($isEditingPost === true): ?>
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <?php endif ?>

                <!-- Champ pour le titre du post -->
                <input 
                    type="text"
                    name="title"
                    value="<?php echo $title; ?>" 
                    placeholder="Title">

                <!-- Champ pour télécharger une image mise en avant -->
                <label style="float: left; margin: 5px auto 5px;">Featured image</label>
                <input 
                    type="file"
                    name="featured_image"
                    >

                <!-- Champ pour le contenu du post -->
                <textarea name="body" id="body" cols="30" rows="10"><?php echo $body; ?></textarea>
                
                <!-- Sélecteur pour choisir le sujet du post -->
                <select name="topic_id">
                    <option value="" selected disabled>Choose topic</option>
                    <?php foreach ($topics as $topic): ?>
                        <option value="<?php echo $topic['id']; ?>">
                            <?php echo $topic['name']; ?>
                        </option>
                    <?php endforeach ?>
                </select>
                
                <!-- Bouton pour soumettre le formulaire, change selon le mode (création ou édition) -->
                <?php if ($isEditingPost === true): ?> 
                    <button type="submit" class="btn" name="update_post">UPDATE</button>
                <?php else: ?>
                    <button type="submit" class="btn" name="create_post">Save Post</button>
                <?php endif ?>

            </form>
        </div>
        <!-- Fin du formulaire pour créer ou éditer un post -->

    </div>

</body>
</html>

<script>
    // Initialisation de CKEditor pour le champ de texte
    CKEDITOR.replace('body');
</script>
