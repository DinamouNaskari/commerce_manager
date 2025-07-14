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
    !empty($_FILES['images'])
) {
    $sql = "INSERT INTO article (nom_article, id_categorie, quantite, prix_achat, prix_vente, date_fabrication, date_expiration, images)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $req = $connexion->prepare($sql);

    $name = $_FILES['images']['name'];
    $tmp_name = $_FILES['images']['tmp_name'];

    $folder = "../public/images/";
    $destination = $folder . time() . "_" . basename($name);

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    if (move_uploaded_file($tmp_name, $destination)) {
        $req->execute([
            $_POST['nom_article'],
            $_POST['id_categorie'],
            $_POST['quantite'],
            $_POST['prix_achat'],
            $_POST['prix_vente'],
            $_POST['date_fabrication'],
            $_POST['date_expiration'],
            $destination
        ]);

        if ($req->rowCount() != 0) {
            $_SESSION['message']['text'] = "Article ajouté avec succès";
            $_SESSION['message']['type'] = "success";
        } else {
            $_SESSION['message']['text'] = "Une erreur s'est produite lors de l'ajout de l'article";
            $_SESSION['message']['type'] = "danger";
        }
    } else {
        $_SESSION['message']['text'] = "Échec de l'importation de l'image";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "Une information obligatoire non renseignée";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../vue/article.php');
exit();
