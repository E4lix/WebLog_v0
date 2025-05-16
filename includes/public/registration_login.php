<?php include('config.php'); ?>

<?php
if (isset($_POST['login_btn'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) && empty($password)) {
        $_SESSION['message'] = "Le nom d'utilisateur et le mot de passe sont requis.";
        header('Location: index.php');
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if ($password === $user['password']) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                ];
                $_SESSION['message'] = "Connexion réussie !";
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['message'] = "Mot de passe incorrect.";
                header('Location: index.php');
                exit();
            }
        } else {
            $_SESSION['message'] = "Nom d'utilisateur non trouvé.";
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['message'] = "Erreur de connexion à la base de données.";
        header('Location: index.php');
        exit();
    }
}
?>
