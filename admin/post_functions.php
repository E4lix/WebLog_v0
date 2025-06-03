<?php
// post_functions.php

function getAllPosts($conn) {
    // Requête SQL pour récupérer tous les posts avec le nom de l'auteur
    $sql = "SELECT posts.*, users.username 
            FROM posts 
            JOIN users ON posts.user_id = users.id 
            ORDER BY created_at DESC";

    // Exécution de la requête
    $result = mysqli_query($conn, $sql);

    // Tableau pour stocker les résultats
    $posts = [];

    // On remplit le tableau avec chaque ligne retournée
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    // Renvoie un tableau de posts avec le nom de l'auteur
    return $posts;
}

function getPostById($conn, $id) {
    // Conversion en entier pour éviter l'injection SQL
    $id = intval($id);

    // Requête SQL pour récupérer un post précis selon son ID
    $sql = "SELECT * FROM posts WHERE id = $id LIMIT 1";

    // Exécution de la requête
    $result = mysqli_query($conn, $sql);

    // Renvoie le premier résultat trouvé
    return mysqli_fetch_assoc($result);
}

function createPost($conn, $user_id, $title, $slug, $body, $image = null, $published = false) {
    // Sécurisation des champs texte
    $title = mysqli_real_escape_string($conn, $title);
    $slug = mysqli_real_escape_string($conn, $slug);
    $body = mysqli_real_escape_string($conn, $body);

    // Transformation booléenne en entier (1 ou 0) pour stocker dans la table posts
    $published = $published ? 1 : 0;

    // Si aucune image n’est fournie, on assigne une image par défaut
    $image = $image ? mysqli_real_escape_string($conn, $image) : 'banner.jpg'; // mysqli_real_escape_string() évite les injections SQL.

    // Requête d’insertion du post dans la BDD
    $sql = "INSERT INTO posts (user_id, title, slug, body, image, published, created_at, updated_at, views)
            VALUES ($user_id, '$title', '$slug', '$body', '$image', $published, NOW(), NOW(), 0)"; // NOW() insère la date/heure actuelle.

    // Renvoie l'exécution de la requête
    return mysqli_query($conn, $sql);
}

function updatePost($conn, $id, $title, $slug, $body, $image = null, $published = false) {
    // Conversion en entier pour éviter l'injection SQL
    $id = intval($id);

    // Sécurisation des champs modifiables
    $title = mysqli_real_escape_string($conn, $title);
    $slug = mysqli_real_escape_string($conn, $slug);
    $body = mysqli_real_escape_string($conn, $body);

    // Transformation booléenne en entier (1 ou 0) pour stocker dans la table posts
    $published = $published ? 1 : 0;

    // Si une image est fournie, on ajoute le champ image à la requête
    $image_sql = $image ? ", image='" . mysqli_real_escape_string($conn, $image) . "'" : "";

    // Requête SQL de mise à jour du post
    $sql = "UPDATE posts 
            SET title='$title', slug='$slug', body='$body', published=$published $image_sql, updated_at=NOW()
            WHERE id = $id";

    // Renvoie l'exécution de la requête
    return mysqli_query($conn, $sql);
}

function deletePost($conn, $id) {
    // Conversion en entier pour éviter l'injection SQL
    $id = intval($id);

    // Requête sql
    $sql = "DELETE FROM posts WHERE id = $id";

    // Renvoie l'exécution de la requête
    return mysqli_query($conn, $sql);
}

function getAllTopics($conn) {
    // Requête sql
    $sql = "SELECT id, name, slug FROM topics ORDER BY name ASC";

    // Exécuté et recupère la requête
    $result = mysqli_query($conn, $sql);

    // Tableau pour stocker les topics
    $topics = [];

    // Stockage de chaque topic dans le tableau
    while ($row = mysqli_fetch_assoc($result)) {
        $topics[] = $row;
    }

    // Renvoie du tableau des topics
    return $topics;
}
?>

