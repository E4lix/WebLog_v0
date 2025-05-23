<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php include('../../config.php'); ?>
<?php include(ROOT_PATH . '/includes/public/head_section.php'); ?>
<?php include(ROOT_PATH . '/includes/public/registration_login.php'); ?>
<?php include(ROOT_PATH . '/includes/public/messages.php'); ?>

<?php
// Requête SQL pour récupérer tous les posts publiés, classés du plus récent au plus ancien
$stmt = $conn->prepare("SELECT id, title,  slug, image, created_at FROM posts WHERE published = 1 ORDER BY created_at DESC");
$stmt->execute();
$stmt->bind_result($id, $title, $slug, $image, $created_at);

$posts = [];

while ($stmt->fetch()) {
    $posts[] = [
        'id' => $id,
        'title' => $title,
        'slug' => $slug,
        'created_at' => $created_at,
        'image' => $image,
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
                    <!-- <?= var_dump($post) ?> -->
                    <img src="../../static/images/<?= htmlspecialchars($post['image'] ?? '') ?>" style="width:100%; max-height:200px; object-fit:cover;">
                    <h3>
                        <a href="single_post.php?slug=<?= urlencode($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h3>
                    <p class="info">
                        Publié par <?= htmlspecialchars($post['username']) ?> le <?= date('d/m/Y', strtotime($post['created_at'])) ?>
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