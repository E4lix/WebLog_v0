<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- Include des fichiers et fonctions pour la page -->
<?php include_once('config.php'); ?>
<?php include_once('includes/public/head_section.php'); ?>
<?php include_once('includes/all_functions.php') ?>

<?php
// Requête SQL pour récupérer tous les posts publiés, classés du plus récent au plus ancien
$stmt = $conn->prepare("SELECT id, user_id, title, body,  slug, image, created_at FROM posts WHERE published = 1 ORDER BY created_at DESC");
$stmt->execute();
$stmt->bind_result($id, $user_id, $body, $title, $slug, $image, $created_at);

// Tableau "posts" vides qui accueillera les élements des postes
$posts = [];

// Récupération dans le tableau "posts" des éléments de chacun des postes 
while ($stmt->fetch()) {
    $posts[] = [
        'id' => $id,
        'user_id' => $user_id,
        'title' => $title,
        'slug' => $slug,
        'created_at' => $created_at,
        'image' => $image,
        'body' => $body,
    ];
}
?>

<title>Mon Blog | Actualités</title>
</head>

<body>
    <div class="container">
        <!-- Navbar -->
        <?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
        <!-- // Navbar -->

        <h2 style="text-align: center; margin: 20px;">Actualités récentes</h2>

        <div class="content">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post" style="margin: 20px; text-align: center;">
                        <!-- <?= var_dump(value: $post) ?> -->
                        <img src="../../static/images/<?= htmlspecialchars($post['image'] ?? '') ?>" style="width:100%; max-height:200px; object-fit:cover;">
                        <h3>
                            <a href="single_post.php?slug=<?= urlencode($post['slug']) ?>">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </h3>
                        <?php $author = getUsernameById($conn, $post['user_id']); ?>
                        <p class="info">
                            Publié par <?= htmlspecialchars($author) ?> le <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                        </p>
                        <p><?= mb_strimwidth(strip_tags($post['body']), 0, 150, '...') ?></p>
                        <a href="single_post.php?slug=<?= urlencode($post['slug']) ?>">Lire la suite</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center;">Aucun article publié pour l’instant.</p>
            <?php endif; ?>
        </div>
    </div>
<!-- Footer -->
<?php include(ROOT_PATH . '/includes/public/footer.php'); ?>
<!-- // Footer -->