<?php include_once(ROOT_PATH . '/config.php'); ?>

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

function createUser($username, $email, $password, $role_name) {
    global $conn;

    $sql = "INSERT INTO users (username, email, role, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur prepare: " . $conn->error);
    }

    $stmt->bind_param("ssss", $username, $email, $role_name, $password);
    return $stmt->execute();
}

   

function getUserById($admin_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateUser($admin_id, $username, $email, $password, $role_name) {
    global $conn;

    $sql = "UPDATE users SET username = ?, email = ?, password = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur prepare (update): " . $conn->error);
    }

    $stmt->bind_param("ssssi", $username, $email, $password, $role_name, $admin_id);
    return $stmt->execute();
}


function deleteUser ($admin_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    return $stmt->execute();
}

function getAllUsers() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

function getRoles($conn) {
    $sql = "SELECT * FROM roles";
    $result = mysqli_query($conn, $sql);
    $roles = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $roles[] = $row;
    }

    return $roles;
}

?>