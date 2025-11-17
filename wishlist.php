<?php
// wishlist.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque_jp_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$id_lecteur = 1; // temporaire

// --- Suppression d’un livre de la liste ---
// Ici on utilise id_livre comme identifiant à supprimer dans la table liste_lecture
if (isset($_POST['supprimer_id'])) {
    $id_livre = intval($_POST['supprimer_id']);
    if ($id_livre > 0) {
        $sql_delete = "DELETE FROM liste_lecture WHERE id_lecteur = ? AND id_livre = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("ii", $id_lecteur, $id_livre);
        $stmt->execute();
    }
}

// --- Récupérer les livres de la liste de lecture ---
$sql = "SELECT livres.id AS id_livre, livres.titre, livres.auteur
        FROM liste_lecture
        JOIN livres ON liste_lecture.id_livre = livres.id
        WHERE liste_lecture.id_lecteur = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_lecteur);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma liste de lecture - Bibliothèque en ligne</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Ma liste de lecture</h1>
        <a href="index.php">Retour à l'accueil</a>
    </header>

    <main>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['titre']) ?></td>
                            <td><?= htmlspecialchars($row['auteur']) ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="supprimer_id" value="<?= htmlspecialchars($row['id_livre']) ?>">
                                    <button type="submit" class="delete-btn">Retirer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Votre liste de lecture est vide</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Bibliothèque en Ligne</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
