<?php 
include('../config.php'); 
include(ROOT_PATH . '/includes/admin_functions.php'); 
include(ROOT_PATH . '/includes/admin/head_section.php'); 
include(ROOT_PATH . '/admin/post_functions.php'); 

// Affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification de la session utilisateur
if (!isset($_SESSION['user'])) {
    header('Location: ' . ROOT_PATH . '/login.php');
    exit();
}

// Initialisation des variables
$title = "";
$slug = "";
$body = "";
$image = "";
$published = false;
$post_id = 0;
$isEditingPost = false;

$posts = getAllPosts($conn); // Fonction à implémenter pour récupérer les posts

// Création d'un post
if (isset($_POST['create_post'])) {
    $title = trim($_POST['title']);
    $slug = trim($_POST['slug']);
    $body = trim($_POST['body']);
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';
    $published = isset($_POST['published']) ? 1 : 0;
    $user_id = $_SESSION['user']['id'];

    if (empty($title) || empty($slug) || empty($body)) {
        $_SESSION['message'] = "Tous les champs requis doivent être remplis.";
        header('Location: posts.php');
        exit();
    }

    createPost($conn, $user_id, $title, $slug, $body, $image,$published); // À implémenter
    $_SESSION['message'] = "Post créé avec succès.";
    header('Location: posts.php');
    exit();
}

// Édition d'un post
if (isset($_GET['edit-post'])) {
    $post_id = $_GET['edit-post'];
    $post = getPostById($conn, $post_id); // À implémenter
    if ($post) {
        $title = $post['title'];
        $slug = $post['slug'];
        $body = $post['body'];
        $published = $post['published'];
        $isEditingPost = true;
    }
}

// Mise à jour du post
if (isset($_POST['update_post'])) {
    $post_id = $_POST['post_id'];
    $title = trim($_POST['title']);
    $slug = trim($_POST['slug']);
    $body = trim($_POST['body']);
    $image = isset($_POST['image']) ? trim($_POST['image']) : '';
    $published = isset($_POST['published']) ? 1 : 0;

    updatePost($conn, $post_id, $title, $slug, $body, $image, $published); // À implémenter
    $_SESSION['message'] = "Post mis à jour avec succès.";
    header('Location: posts.php');
    exit();
}

// Suppression d'un post
if (isset($_GET['delete-post'])) {
    $post_id = $_GET['delete-post'];
    deletePost($conn, $post_id); // À implémenter
    $_SESSION['message'] = "Post supprimé avec succès.";
    header('Location: posts.php');
    exit();
}
?>

<title>Admin | Manage Posts</title>
</head>
<body>
<div class="header">
    <div class="logo">
        <a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">
            <h1>MyWebSite - Admin</h1>
        </a>
    </div>
    <?php if (isset($_SESSION['user'])) : ?>
        <div class="user-info">
            <span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp;
            <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
        </div>
    <?php endif ?>
</div>

<div class="container content">
    <?php include(ROOT_PATH . '/includes/admin/menu.php') ?>

    <div class="action">
        <h1 class="page-title">Create/Edit Post</h1>
        <?php include(ROOT_PATH . '/includes/public/errors.php') ?>
        <form method="post" action="<?php echo BASE_URL . 'admin/posts.php'; ?>">
            <?php if ($isEditingPost) : ?>
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <?php endif ?>

            <input type="text" name="title" value="<?php echo $title; ?>" placeholder="Title" required>
            <input type="text" name="slug" value="<?php echo $slug; ?>" placeholder="Slug" required>
            <textarea name="body" placeholder="Body" required><?php echo $body; ?></textarea>
            <label for="image">Choisir une image</label>
            <select name="image" id="image">
                <option value="">-- Sélectionner une image --</option>
                <?php
                $image_dir = ROOT_PATH . '/static/images';
                $image_url = BASE_URL . 'static/images/';
                $files = array_diff(scandir($image_dir), ['.', '..']);

                foreach ($files as $file) {
                    $selected = ($image == $file) ? 'selected' : '';
                    echo "<option value=\"$file\" $selected>$file</option>";
                }
                ?>
            </select>

            <label>
                <input type="checkbox" name="published" <?php echo ($published) ? 'checked' : ''; ?>> Publier
            </label>

            <?php if ($isEditingPost) : ?>
                <button type="submit" class="btn" name="update_post">UPDATE</button>
            <?php else : ?>
                <button type="submit" class="btn" name="create_post">Save Post</button>
            <?php endif ?>
        </form>
    </div>

    <div class="table-div">
        <?php include(ROOT_PATH . '/includes/public/messages.php') ?>

        <?php if (empty($posts)) : ?>
            <h1>No posts in the database.</h1>
        <?php else : ?>
            <table class="table">
                <thead>
                    <th>N</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Author</th>
                    <th>Published</th>
                    <th colspan="2">Action</th>
                </thead>
                <tbody>
                    <?php foreach ($posts as $key => $post) : ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $post['title']; ?></td>
                            <td><?php echo $post['slug']; ?></td>
                            <td><?php echo $post['user_id']; ?></td>
                            <td><?php echo $post['published'] ? 'Yes' : 'No'; ?></td>
                            <td><a class="fa fa-pencil btn edit" href="posts.php?edit-post=<?php echo $post['id'] ?>"></a></td>
                            <td><a class="fa fa-trash btn delete" href="posts.php?delete-post=<?php echo $post['id'] ?>"></a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>

<?php include(ROOT_PATH . '/includes/public/footer.php'); ?>

