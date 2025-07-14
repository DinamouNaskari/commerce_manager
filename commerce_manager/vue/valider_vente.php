<?php
require_once '../model/connexion.php';

if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "UPDATE vente SET etat = 1 WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id]);

    header("Location: liste_commandes.php");
    exit();
}
