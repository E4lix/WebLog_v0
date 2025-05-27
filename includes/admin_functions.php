<?php include_once(ROOT_PATH . '/config.php'); ?>
<?php include_once(ROOT_PATH . '/includes/public/head_section.php'); ?>

<?php
// Fonction qui renvoie le nombre d'utilisateurs inscrits dans la BDD
function getNumberOfUsers($conn): int {
    $sql = "SELECT COUNT(*) AS total_users FROM users";
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return (int) $row['total_users'];
    } else {
        return 0;
    }
}

// Fonction qui renvoie le nombre de postes dans la BDD
function getNumberOfPosts($conn): int {
    $sql = "SELECT COUNT(*) AS total_posts FROM posts";
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return (int) $row['total_posts'];
    } else {
        return 0;
    }
}

// Fonction qui renvoie le nombre de commentaires dans la BBD
// Précision : Il n'y en a pas encore, il faut les créer
function getNumberOfComments($conn): int {
    $sql = "SELECT COUNT(*) AS total_comms FROM posts";
    $result = mysqli_query($conn, $sql);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return (int) $row['total_comms'];
    } else {
        return 0;
    }
}
?>