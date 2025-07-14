<?php
session_start();
include 'connexion.php';
include_once "function.php";

if (
    !empty($_POST['id_article']) &&
    !empty($_POST['id_client']) &&
    !isset($_POST['quantite']) === false && $_POST['quantite'] !== '' &&
    !empty($_POST['prix'])
) {
    $article = getArticle($_POST['id_article']);

    if (!empty($article) && is_array($article)) {
        if ($_POST['quantite'] > $article['quantite']) {
            $_SESSION['message']['text'] = "❌ La quantité à vendre n'est pas disponible";
            $_SESSION['message']['type'] = "danger";
        } else {
            $sql = "INSERT INTO vente (id_article, id_client, quantite, prix, etat)
                    VALUES (?, ?, ?, ?, 1)";
            $req = $connexion->prepare($sql);

            $req->execute([
                $_POST['id_article'],
                $_POST['id_client'],
                $_POST['quantite'],
                $_POST['prix']
            ]);

            if ($req->rowCount() != 0) {
                // Mettre à jour la quantité de l'article
                $sql = "UPDATE article SET quantite = quantite - ? WHERE id = ?";
                $req = $connexion->prepare($sql);
                $req->execute([
                    $_POST['quantite'],
                    $_POST['id_article']
                ]);

                if ($req->rowCount() != 0) {
                    $_SESSION['message']['text'] = "✅ Vente effectuée avec succès";
                    $_SESSION['message']['type'] = "success";
                } else {
                    $_SESSION['message']['text'] = "⚠ La vente est enregistrée, mais le stock n'a pas été mis à jour.";
                    $_SESSION['message']['type'] = "warning";
                }
            } else {
                $_SESSION['message']['text'] = "❌ Une erreur s'est produite lors de l'enregistrement de la vente.";
                $_SESSION['message']['type'] = "danger";
            }
        }
    }
} else {
    $_SESSION['message']['text'] = "❌ Une information obligatoire est manquante.";
    $_SESSION['message']['type'] = "danger";
}

header('Location: ../vue/vente.php');
exit();
