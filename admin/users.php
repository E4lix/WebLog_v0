<?php 
include('../config.php'); 
include(ROOT_PATH . '/includes/admin_functions.php'); 
include(ROOT_PATH . '/includes/admin/head_section.php'); 

// Vérification de la session utilisateur
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Initialisation des variables
$username = "";
$email = "";
$role_name = "";
$isEditingUser   = false; // Indique si nous sommes en mode édition
$admin_id = 0; // ID de l'utilisateur à éditer

$roles = getRoles($conn); // Récupérer les rôles disponibles

// Gestion de la création et de la mise à jour des utilisateurs
if (isset($_POST['create_admin'])) {
    // Récupération des données du formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role_name = $_POST['role_name'];

    // Validation des données
    if (empty($username) || empty($email) || empty($password) || empty($role_name)) {
        $_SESSION['message'] = "Tous les champs sont requis.";
        header('Location: users.php');
        exit();
    }

    // Création d'un nouvel utilisateur
    createUser ($username, $email, $password, $role_name); // Fonction pour créer un utilisateur
    $_SESSION['message'] = "Utilisateur créé avec succès.";
    header('Location: users.php');
    exit();
}

// Gestion de l'édition d'un utilisateur
if (isset($_GET['edit-admin'])) {
    $isEditingUser   = true; // Passer en mode édition
    $admin_id = $_GET['edit-admin']; // Récupérer l'ID de l'utilisateur à éditer

    // Récupérer les informations de l'utilisateur
    $user = getUserById($admin_id); // Fonction pour obtenir un utilisateur par ID
    if ($user) {
        $username = $user['username'];
        $email = $user['email'];
        $role_name = $user['role'];
    }    
}

// Gestion de la mise à jour d'un utilisateur
if (isset($_POST['update_admin'])) {
    $admin_id = $_POST['admin_id']; // Récupérer l'ID de l'utilisateur à mettre à jour
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role_name = $_POST['role_name'];

    // Validation des données
    if (empty($username) || empty($email) || empty($role_name)) {
        $_SESSION['message'] = "Tous les champs sont requis.";
        header('Location: users.php');
        exit();
    }

    // Mise à jour de l'utilisateur
    updateUser ($admin_id, $username, $email, $password, $role_name); // Fonction pour mettre à jour un utilisateur
    $_SESSION['message'] = "Utilisateur mis à jour avec succès.";
    header('Location: users.php');
    exit();
}

// Gestion de la suppression d'un utilisateur
if (isset($_GET['delete-admin'])) {
    $admin_id = $_GET['delete-admin']; // Récupérer l'ID de l'utilisateur à supprimer
    deleteUser ($admin_id); // Fonction pour supprimer un utilisateur
    $_SESSION['message'] = "Utilisateur supprimé avec succès.";
    header('Location: users.php');
    exit();
}

// Récupérer tous les utilisateurs pour affichage
$admins = getAllUsers(); // Fonction pour obtenir tous les utilisateurs
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin | Manage users</title>
</head>
<body>
    <!-- En-tête de la page admin -->
    <div class="header">
        <div class="logo">
            <a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">
                <h1>MyWebSite - Admin</h1>
            </a>
        </div>

        <!-- Vérification de la session utilisateur connecté, affichage du nom et bouton logout -->
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="user-info">
                <span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp;
                <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
            </div>
        <?php endif ?>
    </div>

    <!-- Contenu de la page users -->
    <div class="container content">
        <!-- Left side menu -->
        <?php include(ROOT_PATH . '/includes/admin/menu.php') ?>

        <!-- Middle form - to create and edit  -->
        <div class="action">
            <h1 class="page-title">Create/Edit Admin User</h1>

            <!-- validation errors for the form -->
            <?php include(ROOT_PATH . '/includes/public/errors.php') ?>

            <!-- form to create or edit admin user -->
            <form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>">
                <!-- if editing user, the id is required to identify that user -->
                <?php if ($isEditingUser  === true) : ?>
                    <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                <?php endif ?>

                <!-- username -->
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username" required>

                <!-- email -->
                <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email" required>
                
                <!-- password -->
                <input type="password" name="password" placeholder="Password" required>
                
                <!-- select role -->
                <select name="role_name" required>
                    <option value="" selected disabled>Assign role</option>
                    <?php foreach ($roles as $role) : ?>
                        <option value="<?php echo $role['id']; ?>" <?php echo ($role['id'] == $role_name) ? 'selected' : ''; ?>>
                            <?php echo $role['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- if editing user, display the update button instead of create button -->
                <?php if ($isEditingUser  === true) : ?>
                    <button type="submit" class="btn" name="update_admin">UPDATE</button>
                <?php else : ?>
                    <button type="submit" class="btn" name="create_admin">Save User</button>
                <?php endif ?>
            </form>
        </div>
        <!-- // Middle form - to create and edit  -->

        <!-- Display records from DB -->
        <div class="table-div">
            <!-- Display notification message -->
            <?php include(ROOT_PATH . '/includes/public/messages.php') ?>

            <?php if (empty($admins)) : ?>
                <h1>No admins in the database.</h1>
            <?php else : ?>
                <table class="table">
                    <thead>
                        <th>N</th>
                        <th>Admin</th>
                        <th>Role</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $key => $admin) : ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <?php echo $admin['username']; ?>, &nbsp;
                                    <?php echo $admin['email']; ?>
                                </td>
                                <td><?php echo $admin['role']; ?></td>
                                <td>
                                    <a class="fa fa-pencil btn edit" href="users.php?edit-admin=<?php echo $admin['id'] ?>">
                                    </a>
                                </td>
                                <td>
                                    <a class="fa fa-trash btn delete" href="users.php?delete-admin=<?php echo $admin['id'] ?>">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
        <!-- // Display records from DB -->

    </div>
</body>
</html>
