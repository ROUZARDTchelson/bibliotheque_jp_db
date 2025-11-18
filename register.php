<?php
session_start();

// ----- Connexion à la base de données -----
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "bibliotheque_jp_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur MySQL : " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]); // récupération du prénom
    $email = trim($_POST["email"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);

    if (empty($nom) || empty($prenom) || empty($email) || empty($mot_de_passe)) {
        $message = "Merci de remplir tous les champs.";
    } else {
        // Vérifier si l'email est déjà utilisé
        $check = $conn->prepare("SELECT email FROM lecteurs WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            $message = "Cet email est déjà utilisé.";
        } else {
            // Hachage du mot de passe
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Insertion du nouvel utilisateur
            $sql = $conn->prepare("INSERT INTO lecteurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
            $sql->bind_param("ssss", $nom, $prenom, $email, $hash);

            if ($sql->execute()) {
                $message = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
            } else {
                $message = "Erreur lors de l'inscription : " . $sql->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Bibliothèque Jacques Premier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <h1>Créer un compte</h1>
    <a href="index.php">Retour à l'accueil</a>
</header>

<main class="login-container">

    <?php if (!empty($message)) : ?>
        <div class="message-erreur"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="" class="login-form">
        <label>Nom :</label>
        <input type="text" name="nom" required value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>">

        <label>Prénom :</label>
        <input type="text" name="prenom" required value="<?= isset($prenom) ? htmlspecialchars($prenom) : '' ?>">

        <label>Email :</label>
        <input type="email" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">

        <label>Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>

        <button type="submit">Créer mon compte</button>
    </form>

    <p class="creer-compte">
        Déjà inscrit ? <a href="login.php">Se connecter</a>
    </p>

</main>

<footer class="site-footer">
    <p>© 2025 Bibliothèque en ligne | Développé par Tchelson Rouzard</p>
</footer>

</body>
</html>
