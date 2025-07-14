<?php
$nom_serveur = "localhost";
$nom_base_de_donne = "commerce_nanager";
$utilisateur = "root";
$motpass = "";

try {
    $connexion = new PDO("mysql:host=$nom_serveur;dbname=$nom_base_de_donne;charset=utf8mb4", $utilisateur, $motpass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
