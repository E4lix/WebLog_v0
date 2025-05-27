<?php include_once(ROOT_PATH . '/config.php'); ?>

<?php
function getPublishedPosts($conn) {
    $sql = "SELECT posts.*, users.username FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.published = 1
            ORDER BY posts.created_at DESC";
    $result = mysqli_query($conn, $sql);
 
    $posts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
    return $posts;
}
 
function getPostBySlug($conn, $slug) {
    $sql = "SELECT posts.*, users.username FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.slug = ? AND posts.published = 1 LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getUsernameById($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    return $user ? $user['username'] : 'Utilisateur inconnu';
}
?>