<?php
session_start();
include 'connexion.php';

if (
    !empty($_POST['nom_article']) &&
    !empty($_POST['id_categorie']) &&
    !empty($_POST['quantite']) &&
    !empty($_POST['prix_achat']) &&
    !empty($_POST['prix_vente']) &&
    !empty($_POST['date_fabrication']) &&
    !empty($_POST['date_expiration']) &&
    !empty($_POST['id'])
) {
    $params = [
        $_POST['nom_article'],
        $_POST['id_categorie'],
        $_POST['quantite'],
        $_POST['prix_achat'],
        $_POST['prix_vente'],
        $_POST['date_fabrication'],
        $_POST['date_expiration']
    ];

    $sql = "UPDATE article SET nom_article=?, id_categorie=?, quantite=?, prix_achat=?, prix_vente=?, 
            date_fabrication=?, date_expiration=?";

    // Si une image est envoyée, on la traite
    if (!empty($_FILES['images']['name'])) {
        $name = time() . "_" . basename($_FILES['images']['name']);
        $tmp_name = $_FILES['images']['tmp_name'];
        $destination = "../public/images/" . $name;

        if (!is_dir("../public/images/")) {
            mkdir("../public/images/", 0777, true);
        }

        if (move_uploaded_file($tmp_name, $destination)) {
            $sql .= ", images=?";
            $params[] = $destination;
        } else {
            $_SESSION['message']['text'] = "Erreur lors du téléchargement de l'image.";
            $_SESSION['message']['type'] = "danger";
            header('Location: ../vue/article.php');
            exit();
        }
    }

    $sql .= " WHERE id=?";
    $params[] = $_POST['id'];

    $req = $connexion->prepare($sql);
    $req->execute($params);

    if ($req->rowCount() != 0) {
        $_SESSION['message']['text'] = "Article modifié avec succès.";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Aucune modification détectée.";
        $_SESSION['message']['type'] = "warning";
    }
} else {
    $_SESSION['message']['text'] = "Une information obligatoire est manquante.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../vue/article.php');
exit();
