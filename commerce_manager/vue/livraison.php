<?php
include 'entete.php';
session_start();
require_once '../model/connexion.php';

// Vérifie si l'utilisateur est connecté et est un livreur
if (!isset($_SESSION['type_utilisateur']) || $_SESSION['type_utilisateur'] !== 'livreur') {
    header("Location: login.php");
    exit();
}

$id_livreur = $_SESSION['utilisateur_id'];

// Requête pour récupérer les livraisons du livreur connecté
$sql = "SELECT l.id, c.nom AS client_nom, c.prenom AS client_prenom, a.nom_article, l.date_livraison
        FROM livraison l
        JOIN commande co ON co.id = l.id_commande
        JOIN client c ON c.id = l.id_utilisateur
        JOIN article a ON a.id = co.id_article
        WHERE l.id_livreur = ?";
$stmt = $connexion->prepare($sql);
$stmt->execute([$id_livreur]);
$livraisons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Livraisons</title>
</head>
<body>
    <h2>Livraisons à effectuer</h2>
    <?php if (empty($livraisons)) : ?>
        <p>Aucune livraison assignée.</p>
    <?php else : ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Article</th>
                <th>Date</th>
            </tr>
            <?php foreach ($livraisons as $liv) : ?>
                <tr>
                    <td><?= htmlspecialchars($liv['id']) ?></td>
                    <td><?= htmlspecialchars($liv['client_nom'] . ' ' . $liv['client_prenom']) ?></td>
                    <td><?= htmlspecialchars($liv['nom_article']) ?></td>
                    <td><?= htmlspecialchars($liv['date_livraison']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
