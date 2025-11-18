<?php
session_start();

// Si l'utilisateur n'est PAS connecté → redirection
if (!isset($_SESSION['id_lecteur'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Jacques Premier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <h1>Bienvenue à la Bibliothèque Jacques Premier</h1>

    <nav class="top-nav">
        <span class="user-info">
            Bienvenue : <strong><?= htmlspecialchars($_SESSION['nom']); ?></strong>
        </span>
        <a href="wishlist.php">|Acceder à la liste de lecture</a>
        <a href="logout.php" class="btn-logout">|Se déconnecter</a>
    </nav>

    <p>Explorez, recherchez et gérez votre collection de livres facilement.</p>
</header>

<main>

    <!-- Section de recherche -->
    <section class="search-section">
        <h2>Rechercher un livre</h2>
        <form action="recherche.php" method="get">
            <input type="text" name="recherche" placeholder="Titre ou auteur..." required>
            <button type="submit">Rechercher</button>
        </form>
    </section>

    <!-- Description / Instructions -->
    <section class="info-section">
        <h2>Comment utiliser le site</h2>
        <ul>
            <li>Recherchez un livre par titre ou auteur.</li>
            <li>Ajoutez un nouveau livre à la collection.</li>
            <li>Modifiez les informations d’un livre existant.</li>
            <li>Supprimez un livre de la bibliothèque.</li>
            <li>Consultez les détails d’un livre.</li>
            <li>Ajoutez un livre à votre liste de lecture.</li>
        </ul>
    </section>

</main>

<footer>
    <p>&copy; 2025 Bibliothèque en Ligne | Développé par Tchelson Rouzard</p>
</footer>

</body>
</html>
