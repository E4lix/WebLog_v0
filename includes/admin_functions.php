<?php include_once(ROOT_PATH . '/config.php'); ?>

<?php
// Fonction qui retourne le nombre total d'utilisateurs dans la table `users`
function getNumberOfUsers($conn): int {
    $sql = "SELECT COUNT(*) AS total_users FROM users"; // Requête SQL pour compter tous les utilisateurs
    $result = mysqli_query($conn, $sql); // Exécution de la requête

    // Si la requête renvoie un résultat et qu'une ligne est récupérée
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return (int) $row['total_users']; // On retourne le nombre total sous forme entière
    } else {
        return 0; // Si erreur, on retourne 0
    }
}


// Fonction qui retourne le nombre total de posts dans la table `posts`
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

// Fonction qui crée un utilisateur dans la base de données
function createUser($username, $email, $password, $role_name) {
    global $conn; // On utilise la connexion globale à la BDD

    $sql = "INSERT INTO users (username, email, role, password) VALUES (?, ?, ?, ?)"; // Requête préparée
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur prepare: " . $conn->error); // Si erreur de préparation, on stoppe l'exécution
    }

    // On lie les variables aux paramètres (s = string)
    $stmt->bind_param("ssss", $username, $email, $role_name, $password);
    return $stmt->execute(); // Exécution de la requête
}


   

// Fonction qui récupère un utilisateur par son ID
function getUserById($admin_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $admin_id); // i = integer
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc(); // On retourne le résultat sous forme de tableau associatif
}


// Fonction qui met à jour les informations d'un utilisateur
function updateUser($admin_id, $username, $email, $password, $role_name) {
    global $conn;

    $sql = "UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur prepare (update): " . $conn->error);
    }

    $stmt->bind_param("ssssi", $username, $email, $password, $role_name, $admin_id); // s = string, i = integer
    return $stmt->execute();
}



// Fonction qui supprime un utilisateur par son ID
function deleteUser ($admin_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $admin_id); // i = integer
    return $stmt->execute();
}

// Fonction qui retourne tous les utilisateurs de la base
function getAllUsers() {
    global $conn;
    $sql = "SELECT * FROM users"; // Requête pour récupérer tous les utilisateurs
    $result = mysqli_query($conn, $sql);
    $users = [];

    while ($row = mysqli_fetch_assoc($result)) { // On boucle sur chaque ligne
        $users[] = $row; // On ajoute chaque utilisateur au tableau
    }
    return $users;
}

// Fonction qui retourne tous les rôles définis dans la table `roles`
function getRoles($conn) {
    $sql = "SELECT * FROM roles"; // Requête simple
    $result = mysqli_query($conn, $sql);
    $roles = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $roles[] = $row;
    }

    return $roles;
}
?>