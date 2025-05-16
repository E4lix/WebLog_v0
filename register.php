<?php include('config.php'); ?>
<?php include('includes/public/head_section.php'); ?>
</head>

<body>

<div class="container">

    <!-- Navbar -->
    <?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
    <!-- // Navbar -->

    <?php
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Vérifications de base
        if (empty($username)) $errors[] = "Le nom d'utilisateur est requis.";
        if (empty($email)) $errors[] = "L'email est requis.";
        if (empty($password)) $errors[] = "Le mot de passe est requis.";

        // Vérifier si le nom d'utilisateur ou l'email existe déjà
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $errors[] = "Un utilisateur avec ce nom ou cet email existe déjà.";
        }

        // Si aucune erreur, insérer l'utilisateur
        if (empty($errors)) {
            $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $username, $email, $password); // 🔐 À sécuriser plus tard avec un hash
            if ($insert_stmt->execute()) {
                // Démarrer la session automatiquement après inscription
                $_SESSION['user'] = [
                    'id' => $insert_stmt->insert_id,
                    'username' => $username
                ];
                header('Location: index.php');
                exit();
            } else {
                $errors[] = "Erreur lors de l'enregistrement.";
            }
        }
    }
    ?>

    <!-- Formulaire HTML -->
    <form method="POST">
        <br>
        <label><h3>Username :</h3></label>
        <input type="text" name="username" required><br>

        <label><h3>Email :</h3></label>
        <input type="email" name="email" required><br>

        <label><h3>Mot de passe :</h3></label>
        <input type="password" name="password" required>

        <button class="btn" type="submit">S'inscrire</button>
        <br><br>

        <!-- Affichage des erreurs -->
        <?php if (!empty($errors)): ?>
            <div style="color:red;">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </form>

    <!-- content -->
    <div class="content">
        <h2 class="content-title">Recent Articles</h2>
        <hr>
    </div>
    <!-- // content -->

</div>
<!-- // container -->

<!-- Footer -->
<?php include(ROOT_PATH . '/includes/public/footer.php'); ?>
<!-- // Footer -->
</body>
</html>
