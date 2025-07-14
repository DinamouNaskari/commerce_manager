<?php
session_start();
require_once '../model/connexion.php';
require_once '../model/function.php';

if (!empty($_POST['id_client']) && !empty($_POST['articles'])) {
    $client_id = $_POST['id_client'];
    $articles = $_POST['articles'];
    $success = true;

    foreach ($articles as $id_article => $data) {
        $quantite = (int) $data['quantite'];
        $prix_unitaire = (int) $data['prix'];
        $prix_total = $prix_unitaire * $quantite;

        // Vérifier le stock
        $article = getArticle($id_article);
        if ($article['quantite'] < $quantite) {
            $_SESSION['message']['text'] = "Stock insuffisant pour l'article : " . $article['nom_article'];
            $_SESSION['message']['type'] = "danger";
            $success = false;
            break;
        }

        // Insertion dans vente avec etat=0 (en attente de validation)
        $sql = "INSERT INTO vente (id_article, id_client, quantite, prix, etat) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$id_article, $client_id, $quantite, $prix_total, 0]);

        // Diminuer le stock
        $sqlUpdate = "UPDATE article SET quantite = quantite - ? WHERE id = ?";
        $stmtUpdate = $connexion->prepare($sqlUpdate);
        $stmtUpdate->execute([$quantite, $id_article]);
    }

    if ($success) {
        $_SESSION['panier'] = []; // Vider le panier
        $_SESSION['message']['text'] = "Commande enregistrée avec succès ✅";
        $_SESSION['message']['type'] = "success";
    }

} else {
    $_SESSION['message']['text'] = "Erreur lors de la commande ❌";
    $_SESSION['message']['type'] = "danger";
}

header("Location: voir_panier.php");
exit();
