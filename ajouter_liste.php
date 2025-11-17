<?php
// ajouter_liste.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque_jp_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$id_lecteur = 1; // temporaire, à remplacer par id de session si connecté

// Vérifier méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Vérifier que id_livre est fourni
if (!isset($_POST['id_livre'])) {
    die("Erreur : id_livre manquant.");
}

$id_livre = intval($_POST['id_livre']);
if ($id_livre <= 0) {
    die("ID de livre invalide.");
}

// Vérifier que le livre existe dans la table livres
$checkLivre = $conn->prepare("SELECT id FROM livres WHERE id = ?");
$checkLivre->bind_param("i", $id_livre);
$checkLivre->execute();
$resLivre = $checkLivre->get_result();
if ($resLivre->num_rows === 0) {
    die("Erreur : le livre sélectionné n'existe pas.");
}

// Vérifier si le livre n’est pas déjà dans la liste
$check = $conn->prepare("SELECT * FROM liste_lecture WHERE id_lecteur = ? AND id_livre = ?");
$check->bind_param("ii", $id_lecteur, $id_livre);
$check->execute();
$result = $check->get_result();

if ($result->num_rows == 0) {
    $sql = "INSERT INTO liste_lecture (id_lecteur, id_livre) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_lecteur, $id_livre);
    if (!$stmt->execute()) {
        die("Erreur MySQL lors de l'ajout : " . $stmt->error);
    }
}

// Redirection vers la page de wishlist
header("Location: wishlist.php");
exit();
?>
