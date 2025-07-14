<?php
session_start();
include 'connexion.php';

if (
    !empty($_GET['idVente']) &&
    !empty($_GET['idArticle']) &&
    isset($_GET['quantite']) && is_numeric($_GET['quantite'])
) {
    try {
        $connexion->beginTransaction();

        // 1. Annulation de la vente
        $sql = "UPDATE vente SET etat = 0 WHERE id = ?";
        $req = $connexion->prepare($sql);
        $req->execute([$_GET['idVente']]);

        // 2. Rétablir la quantité dans le stock si la vente a bien été désactivée
        if ($req->rowCount() > 0) {
            $sql = "UPDATE article SET quantite = quantite + ? WHERE id = ?";
            $req = $connexion->prepare($sql);
            $req->execute([$_GET['quantite'], $_GET['idArticle']]);

            $_SESSION['message']['text'] = "✅ Vente annulée avec succès.";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "⚠ Aucun changement : la vente n'a pas été trouvée ou déjà annulée.";
            $_SESSION['message']['type'] = "warning";
        }

        $connexion->commit();

    } catch (PDOException $e) {
        $connexion->rollBack();
        $_SESSION['message']['text'] = "❌ Erreur lors de l'annulation : " . $e->getMessage();
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "❌ Paramètres manquants ou invalides pour l'annulation.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../vue/vente.php');
exit();
