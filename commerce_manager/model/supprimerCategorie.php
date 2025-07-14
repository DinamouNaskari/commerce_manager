<?php
include_once 'connexion.php'; // ✅ Utilise bien ton fichier existant

if (!empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM categorie_article WHERE id = :id";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_INT);

    if ($req->execute() && $req->rowCount() > 0) {
        $_SESSION['message']['text'] = "Catégorie supprimée avec succès.";
        $_SESSION['message']['type'] = "success";
    } else {
        $_SESSION['message']['text'] = "Échec de la suppression. Cette catégorie est peut-être utilisée ailleurs (clé étrangère).";
        $_SESSION['message']['type'] = "danger";
    }
} else {
    $_SESSION['message']['text'] = "ID non fourni pour la suppression.";
    $_SESSION['message']['type'] = "danger";
}

header("Location: ../vue/categorie.php");
exit;
