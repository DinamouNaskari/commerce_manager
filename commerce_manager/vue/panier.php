<?php
session_start();
require_once '../model/function.php';

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Traitement de l'ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $id_article = $_POST['id_article'];
    $quantite = $_POST['quantite'];

    if (!empty($id_article) && !empty($quantite)) {
        $article = getArticle($id_article);

        if ($article) {
            // Si l'article est déjà dans le panier, augmenter la quantité
            if (isset($_SESSION['panier'][$id_article])) {
                $_SESSION['panier'][$id_article]['quantite'] += $quantite;
            } else {
                // Sinon, l'ajouter avec ses infos
                $_SESSION['panier'][$id_article] = [
                    'nom' => $article['nom_article'],
                    'prix' => $article['prix_vente'],
                    'quantite' => $quantite
                ];
            }
            $_SESSION['message']['text'] = "Article ajouté au panier !";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "Article non trouvé.";
            $_SESSION['message']['type'] = "danger";
        }
    } else {
        $_SESSION['message']['text'] = "Informations manquantes.";
        $_SESSION['message']['type'] = "warning";
    }

    header("Location: catalogue_client.php");
    exit();
}
