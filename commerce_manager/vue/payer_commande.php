<?php
session_start();
include_once '../model/connexion.php';
include_once '../model/function.php';

if (!isset($_POST['operateur'], $_POST['articles'], $_POST['id_client'])) {
    $_SESSION['message']['text'] = "Données manquantes pour le paiement.";
    $_SESSION['message']['type'] = "danger";
    header('Location: panier.php');
    exit();
}

$id_client = $_POST['id_client'];
$articles = $_POST['articles'];
$total = $_POST['total'];
$operateur = $_POST['operateur'];

foreach ($articles as $id_article => $details) {
    $quantite = $details['quantite'];
    $prix = $details['prix'] * $quantite;

    $sql = "INSERT INTO vente (id_article, id_client, quantite, prix, etat, statut_paiement)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id_article, $id_client, $quantite, $prix, 0, 'payé']);
}

// Vider le panier
unset($_SESSION['panier']);

$_SESSION['message']['text'] = "Paiement via " . strtoupper($operateur) . " effectué. En attente de validation.";
$_SESSION['message']['type'] = "success";
header('Location: commande_client.php');
exit();
