<?php
// post_functions.php

function getAllPosts($conn) {
    $sql = "SELECT posts.*, users.username 
            FROM posts 
            JOIN users ON posts.user_id = users.id 
            ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    $posts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
    return $posts;
}

function getPostById($conn, $id) {
    $id = intval($id);
    $sql = "SELECT * FROM posts WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function createPost($conn, $user_id, $title, $slug, $body, $image = null, $published = false) {
    $title = mysqli_real_escape_string($conn, $title);
    $slug = mysqli_real_escape_string($conn, $slug);
    $body = mysqli_real_escape_string($conn, $body);
    $published = $published ? 1 : 0;
    $image = $image ? mysqli_real_escape_string($conn, $image) : 'default.jpg';

    $sql = "INSERT INTO posts (user_id, title, slug, body, image, published, created_at, updated_at, views)
            VALUES ($user_id, '$title', '$slug', '$body', '$image', $published, NOW(), NOW(), 0)";
    return mysqli_query($conn, $sql);
}

function updatePost($conn, $id, $title, $slug, $body, $image = null, $published = false) {
    $id = intval($id);
    $title = mysqli_real_escape_string($conn, $title);
    $slug = mysqli_real_escape_string($conn, $slug);
    $body = mysqli_real_escape_string($conn, $body);
    $published = $published ? 1 : 0;
    $image_sql = $image ? ", image='" . mysqli_real_escape_string($conn, $image) . "'" : "";

    $sql = "UPDATE posts 
            SET title='$title', slug='$slug', body='$body', published=$published $image_sql, updated_at=NOW()
            WHERE id = $id";
    return mysqli_query($conn, $sql);
}

function deletePost($conn, $id) {
    $id = intval($id);
    $sql = "DELETE FROM posts WHERE id = $id";
    return mysqli_query($conn, $sql);
}

function getAllTopics($conn) {
    $sql = "SELECT id, name, slug FROM topics ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);

    $topics = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $topics[] = $row;
    }

    return $topics;
}

?>

