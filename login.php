<?php
session_start();

// ----- Connexion à la base de données -----
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "bibliotheque_jp_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion MySQL : " . $conn->connect_error);
}

// ----- Déjà connecté → redirection vers index -----
if (isset($_SESSION['id_lecteur'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$email_input = "";

// ----- Traitement du formulaire -----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email_input = trim($_POST['email'] ?? '');
    $pw_input    = $_POST['password'] ?? '';

    if ($email_input === '' || $pw_input === '') {
        $error = "Veuillez remplir tous les champs.";
    } else {

        // Sélectionne le lecteur par email
        $sql = "SELECT * FROM lecteurs WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email_input);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 1) {
                $user = $res->fetch_assoc();
                $stored = $user['mot_de_passe'];

                // ---- Comparaison mot de passe hashé ----
                if (password_verify($pw_input, $stored)) {

                    // ----- Création de la session -----
                    $_SESSION['id_lecteur'] = $user['id'];
                    $_SESSION['nom']        = $user['nom'];
                    $_SESSION['email']      = $user['email'];

                    // ----- Redirection vers index -----
                    header("Location: index.php");
                    exit();

                } else {
                    $error = "Mot de passe incorrect.";
                }
            } else {
                $error = "Aucun compte trouvé avec cet email.";
            }

            $stmt->close();
        } else {
            $error = "Erreur SQL : " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Connexion</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <h1>Bienvenue à la Bibliothèque Jacques Premier</h1>
    <nav class="top-nav">
        <a href="login.php" class="btn-login">Se connecter</a>
    </nav>
</header>

<main class="login-container">
    <h2>Connexion</h2>

    <?php if ($error): ?>
        <div class="message-erreur"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Email :</label>
        <input type="email" name="email" required value="<?= htmlspecialchars($email_input) ?>">

        <label>Mot de passe :</label>
        <input type="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <p class="creer-compte">Si vous n'avez pas de compte ? <a href="register.php">Créer un compte ici</a></p>
</main>

<footer class="site-footer">
    <p>© 2025 Bibliothèque en ligne | Développé par Tchelson Rouzard</p>
</footer>

</body>
</html>
