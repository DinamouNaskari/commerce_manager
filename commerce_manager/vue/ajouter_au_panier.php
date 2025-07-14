<?php

if (!empty($_POST['id_article']) && !empty($_POST['quantite'])) {
    $id = $_POST['id_article'];
    $quantite = (int) $_POST['quantite'];

    if ($quantite <= 0) {
        $_SESSION['message']['text'] = "Quantité invalide.";
        $_SESSION['message']['type'] = "danger";
    } else {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        if (isset($_SESSION['panier'][$id])) {
            $_SESSION['panier'][$id] += $quantite;
        } else {
            $_SESSION['panier'][$id] = $quantite;
        }

        $_SESSION['message']['text'] = "Article ajouté au panier.";
        $_SESSION['message']['type'] = "success";
    }
} else {
    $_SESSION['message']['text'] = "Paramètres manquants.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: catalogue_client.php');
exit();
