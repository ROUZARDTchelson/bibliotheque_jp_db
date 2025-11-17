<?php
// --- Connexion à la base de données ---
$servername = "localhost";
$username = "root";     // à modifier selon ton environnement
$password = "";         // mot de passe MySQL (souvent vide sous XAMPP)
$dbname = "bibliotheque_jp_db"; // nom de ta base de données

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// --- Traitement de l'ajout d'un livre ---
$message_ajout = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_livre'])) {
    $id = intval($_POST['id']);
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $description = $_POST['description'];
    $maison_edition = $_POST['maison_edition'];
    $nombre_exemplaire = intval($_POST['nombre_exemplaire']);
    $image = $_POST['image'];

    $sql_insert = "INSERT INTO livres (id, titre, auteur, description, maison_edition, nombre_exemplaire, image)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("issssis", $id, $titre, $auteur, $description, $maison_edition, $nombre_exemplaire, $image);

    if ($stmt->execute()) {
        $message_ajout = "Livre ajouté avec succès !";
    } else {
        $message_ajout = "Erreur lors de l'ajout : " . $stmt->error;
    }
}

// --- Récupération du terme de recherche ---
$terme = "";
$resultats = [];

if (isset($_GET['recherche'])) {
    $terme = trim($_GET['recherche']);

    // Requête SQL pour chercher par titre ou auteur
    $sql = "SELECT * FROM livres 
            WHERE titre LIKE ? OR auteur LIKE ?";

    $stmt = $conn->prepare($sql);
    $likeTerme = "%" . $terme . "%";
    $stmt->bind_param("ss", $likeTerme, $likeTerme);
    $stmt->execute();
    $resultats = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de recherche - Bibliothèque en ligne</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Résultats de la recherche</h1>
        <p>Résultats pour : <strong><?= htmlspecialchars($terme) ?></strong></p>
        <a href="index.html"> Retour à l'accueil</a>
    </header>

    <main>

        <!-- Résultats de recherche -->
        <?php if (isset($_GET['recherche'])): ?>
            <?php if ($resultats && $resultats->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultats->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['titre']) ?></td>
                                <td><?= htmlspecialchars($row['auteur']) ?></td>
                                <td>
                                    <form action="details.php" method="get" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit">Voir détails</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun résultat trouvé pour "<strong><?= htmlspecialchars($terme) ?></strong>".</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Veuillez saisir un terme de recherche depuis la page d'accueil.</p>
        <?php endif; ?>

        <hr><br>

        <!-- 🟦 SECTION : AJOUT D'UN LIVRE -->
        <section>
            <h2>Ajouter un nouveau livre</h2>

            <?php if ($message_ajout): ?>
                <p style="color: green; font-weight: bold;"><?= $message_ajout ?></p>
            <?php endif; ?>

            <form method="post">

                <label>ID :</label><br>
                <input type="number" name="id" required><br><br>

                <label>Titre :</label><br>
                <input type="text" name="titre" required><br><br>

                <label>Auteur :</label><br>
                <input type="text" name="auteur" required><br><br>

                <label>Description :</label><br>
                <textarea name="description" required></textarea><br><br>

                <label>Maison d'édition :</label><br>
                <input type="text" name="maison_edition" required><br><br>

                <label>Nombre d'exemplaires :</label><br>
                <input type="number" name="nombre_exemplaire" required><br><br>

                <label>URL de l'image :</label><br>
                <input type="text" name="image" required><br><br>

                <button type="submit" name="ajouter_livre">Ajouter le livre</button>
            </form>
        </section>

    </main>

    <footer>
        <p>&copy; 2025 Bibliothèque en Ligne</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
