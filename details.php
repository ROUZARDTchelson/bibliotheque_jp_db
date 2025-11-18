<?php
// details.php
// Affiche les détails d'un livre et propose l'ajout à la wishlist

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque_jp_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur : " . $conn->connect_error);
}

// Vérifier l'ID dans l'URL
if (!isset($_GET['id'])) {
    die("Aucun livre sélectionné.");
}
$id = intval($_GET['id']);
if ($id <= 0) {
    die("ID de livre invalide.");
}

// Récupérer le livre
$sql = "SELECT * FROM livres WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Livre introuvable.");
}

$livre = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du livre - <?= htmlspecialchars($livre['titre']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1><?= htmlspecialchars($livre['titre']) ?></h1>
    <a href="index.php">Retour à l'acceuil|</a> 
    <a href="wishlist.php">Ma liste de lecture</a>
    <a href="logout.php" class="btn-logout">|Se déconnecter</a>
</header>

<main class="details">
<section class="details-container">
    <h2>Titre : <?= htmlspecialchars($livre['titre']) ?></h2>

    <?php if (!empty($livre['auteur'])): ?>
        <p><strong>Auteur :</strong> <?= htmlspecialchars($livre['auteur']) ?></p>
    <?php endif; ?>

    <?php if (!empty($livre['maison_edition'])): ?>
        <p><strong>Maison Edition :</strong> <?= htmlspecialchars($livre['maison_edition']) ?></p>
    <?php endif; ?>

    <p><strong>Description :</strong><br>
        <?= nl2br(htmlspecialchars($livre['description'])) ?>
    </p>

    <!-- Ajouter à la liste de lecture -->
    <form action="ajouter_liste.php" method="post" style="margin-top:20px;">
        <input type="hidden" name="id_livre" value="<?= htmlspecialchars($livre['id']) ?>">
        <button type="submit">Ajouter à ma liste de lecture</button>
    </form>

    <!-- Sélectionner un livre à modifier -->
    <form action="modifier_livre.php" method="get" style="margin-top:20px;">
        <label for="livre_select"><strong>Choisir un livre à modifier :</strong></label>
        <select id="livre_select" name="id" required>
            <option value="">-- Sélectionner un livre --</option>
            <?php
            $sql_livres = "SELECT id, titre FROM livres ORDER BY titre ASC";
            $result_livres = $conn->query($sql_livres);
            while ($rowLivre = $result_livres->fetch_assoc()):
            ?>
                <option value="<?= htmlspecialchars($rowLivre['id']) ?>">
                    <?= htmlspecialchars($rowLivre['titre']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" style="margin-top:10px;">Modifier</button>
    </form>
</section>

<section class="list-section">
    <h2>Les livres de la bibliothèque</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Maison Édition</th>
            <th>Image</th>
            <th>Description</th>
            <th>Nombre d'exemplaires</th>
        </tr>
        <?php
      $sql_all = "SELECT * FROM livres ORDER BY id DESC"; 
      $all = $conn->query($sql_all);

      while ($row = $all->fetch_assoc()) {

        $image = $row['image']; 
        $image_url = "Images/" . $image;                      
         $image_disk_path = __DIR__ . "/Images/" . $image;     

         echo "<tr>
            <td>".htmlspecialchars($row['id'])."</td>
            <td>".htmlspecialchars($row['titre'])."</td>
            <td>".htmlspecialchars($row['auteur'])."</td>
            <td>".htmlspecialchars($row['maison_edition'])."</td>
            <td>";

         if (!empty($image) && file_exists($image_disk_path)) {
             echo "<img src='$image_url' width='80' height='100' alt='couverture'>";
           } else {
             echo "<span style='color:gray;'>Aucune image</span>";
             }

         echo    "</td>
            <td>".substr(htmlspecialchars($row['description']), 0, 80)."...</td>
            <td>".htmlspecialchars($row['nombre_exemplaire'])."</td>
          </tr>";
          }

        ?>
    </table>
</section>
</main>

<footer>
    <p>&copy; 2025 Bibliothèque en Ligne | Développé par Tchelson Rouzard</p>
</footer>
</body>
</html>
<?php
$conn->close();
?>
