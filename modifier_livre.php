<?php
// ------- Connexion -------
$host = "localhost";
$user = "root";
$pass = "";
$db = "bibliotheque_jp_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// -------------------- Chargement des données d’un livre --------------------
$livre = [
    "id" => "",
    "titre" => "",
    "auteur" => "",
    "description" => "",
    "maison_edition" => "",
    "nombre_exemplaire" => "",
    "image" => ""
];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM livres WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $livre = $result->fetch_assoc();
    }
}

// -------------------- ENREGISTRER UNE MODIFICATION --------------------
if (isset($_POST['modifier'])) {

    $id = intval($_POST['id']);
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $description = $_POST['description'];
    $maison = $_POST['maison_edition'];
    $exemplaires = intval($_POST['nombre_exemplaire']);
    $image = $livre['image'];

    // Upload image si nouvelle
    if (!empty($_FILES["image"]["name"])) {
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "Images/" . $image);
    }

    $sql = "UPDATE livres SET titre=?, auteur=?, description=?, maison_edition=?, nombre_exemplaire=?, image=? 
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisi", $titre, $auteur, $description, $maison, $exemplaires, $image, $id);
    $stmt->execute();

    header("Location: modifier_livre.php?msg=modifie&id=$id");
    exit;
}

// -------------------- AJOUTER UN LIVRE --------------------
if (isset($_POST['ajouter'])) {

    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $description = $_POST['description'];
    $maison = $_POST['maison_edition'];
    $exemplaires = intval($_POST['nombre_exemplaire']);
    $image = "";

    if (!empty($_FILES["image"]["name"])) {
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "Images/" . $image);
    }

    $sql = "INSERT INTO livres (titre, auteur, description, maison_edition, nombre_exemplaire, image)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $titre, $auteur, $description, $maison, $exemplaires, $image);
    $stmt->execute();

    header("Location: modifier_livre.php?msg=ajoute");
    exit;
}

// -------------------- SUPPRIMER UN LIVRE --------------------
if (isset($_POST['supprimer'])) {

    $id = intval($_POST['id_supprimer']);
    $stmt = $conn->prepare("DELETE FROM livres WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: modifier_livre.php?msg=supprime");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des livres</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body { font-family: Arial; background:#f0f0f0; padding:20px; }
        .section-box { background:white; padding:20px; margin-bottom:30px; border-radius:10px; width:500px; }
        input, textarea, select { width:100%; padding:8px; margin-bottom:10px; }
        button { padding:10px; cursor:pointer; }
        h2 { margin-top:0; }
    </style>
</head>
<body>

<?php if (isset($_GET['msg'])): ?>
    <p style="color:green; font-weight:bold;">
        ✔ Opération effectuée : <?= htmlspecialchars($_GET['msg']) ?>
    </p>
<?php endif; ?>


<!-- ========================= MODIFIER UN LIVRE ========================= -->
<div class="section-box">
    <h2>Modifier un livre</h2>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $livre['id'] ?>">

        <label>Titre :</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>

        <label>Auteur :</label>
        <input type="text" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required>

        <label>Description :</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($livre['description']) ?></textarea>

        <label>Maison d’édition :</label>
        <input type="text" name="maison_edition" value="<?= htmlspecialchars($livre['maison_edition']) ?>">

        <label>Nombre d'exemplaires :</label>
        <input type="number" name="nombre_exemplaire" value="<?= $livre['nombre_exemplaire'] ?>">

        <label>Image :</label>
        <input type="file" name="image">

        <button type="submit" name="modifier">Enregistrer</button>
    </form>
</div>
<!-- ========================= SUPPRIMER UN LIVRE ========================= -->
<div class="section-box">
    <h2>Supprimer un livre</h2>

    <form method="post">
        <label>Choisir un livre :</label>
        <select name="id_supprimer" required>
            <option value="">-- Sélectionner --</option>
            <?php
            $res = $conn->query("SELECT id, titre FROM livres ORDER BY titre ASC");
            while ($l = $res->fetch_assoc()):
            ?>
                <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['titre']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="supprimer" style="background:red; color:white;">
            Supprimer
        </button>
    </form>
</div>

</body>
</html>
