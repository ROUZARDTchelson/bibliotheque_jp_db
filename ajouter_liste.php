<?php
session_start();

// ----- Vérifier si le lecteur est connecté -----
if (!isset($_SESSION['id_lecteur'])) {
    header("Location: login.php");
    exit();
}

$id_lecteur = $_SESSION['id_lecteur'];

// ----- Connexion à la base de données -----
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "bibliotheque_jp_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// ----- Vérifier méthode POST -----
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// ----- Vérifier que id_livre est fourni -----
if (!isset($_POST['id_livre'])) {
    die("Erreur : id_livre manquant.");
}

$id_livre = intval($_POST['id_livre']);
if ($id_livre <= 0) {
    die("ID de livre invalide.");
}

// ----- Vérifier que le livre existe -----
$checkLivre = $conn->prepare("SELECT id FROM livres WHERE id = ?");
$checkLivre->bind_param("i", $id_livre);
$checkLivre->execute();
$checkLivre->store_result();

if ($checkLivre->num_rows === 0) {
    die("Erreur : le livre sélectionné n'existe pas.");
}

// ----- Vérifier si le livre n’est pas déjà dans la liste -----
$check = $conn->prepare("SELECT 1 FROM liste_lecture WHERE id_lecteur = ? AND id_livre = ?");
$check->bind_param("ii", $id_lecteur, $id_livre);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {
    $sql = $conn->prepare("INSERT INTO liste_lecture (id_lecteur, id_livre) VALUES (?, ?)");
    $sql->bind_param("ii", $id_lecteur, $id_livre);
    if (!$sql->execute()) {
        die("Erreur MySQL lors de l'ajout : " . $sql->error);
    }
}

// ----- Redirection vers la page wishlist -----
header("Location: wishlist.php");
exit();

?>
