<?php
session_start();

if (!empty($_GET['id']) && isset($_SESSION['panier'][$_GET['id']])) {
    unset($_SESSION['panier'][$_GET['id']]);
    $_SESSION['message']['text'] = "Article supprimé du panier.";
    $_SESSION['message']['type'] = "warning";
}

header("Location: voir_panier.php");
exit();
