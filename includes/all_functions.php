<?php include_once(ROOT_PATH . '/config.php'); ?>

<?php
function getPublishedPosts($conn) {
    // Requête SQL : on sélectionne tous les articles publiés, avec les infos de l'auteur
    $sql = "SELECT posts.*, users.username FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.published = 1
            ORDER BY posts.created_at DESC";

    // Exécution de la requête SQL
    $result = mysqli_query($conn, $sql);
 
    // Initialisation d'un tableau vide pour stocker les résultats
    $posts = [];

    // On récupère chaque ligne de résultat 
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    // On retourne le tableau de posts
    return $posts;
}

 
function getPostBySlug($conn, $slug) {
    // Requête SQL paramétrée pour récupérer un post publié en fonction de son slug (URL-friendly)
    $sql = "SELECT posts.*, users.username FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.slug = ? AND posts.published = 1 LIMIT 1";

    // Préparation de la requête (évite les injections SQL)
    $stmt = $conn->prepare($sql);

    // Liaison du paramètre : "s" indique que c'est une chaîne de caractères
    $stmt->bind_param("s", $slug);

    // Exécution de la requête
    $stmt->execute();

    // Récupération du résultat
    $result = $stmt->get_result();

    // On retourne la première ligne du résultat (le post)
    return $result->fetch_assoc();
}

function getUsernameById($conn, $user_id) {
    // Préparation d'une requête SQL sécurisée pour récupérer l'utilisateur via son ID
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");

    // Liaison du paramètre (entier)
    $stmt->bind_param("i", $user_id);

    // Exécution de la requête
    $stmt->execute();

    // Récupération du résultat
    $result = $stmt->get_result();

    // Récupération de l'utilisateur
    $user = $result->fetch_assoc();

    // Si on trouve un utilisateur, on retourne son username ; sinon une valeur par défaut
    return $user ? $user['username'] : 'Utilisateur inconnu';
}
?>