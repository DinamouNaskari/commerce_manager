<?php
session_start();
$_SESSION['message']['text'] = "Paiement reçu. En attente de validation.";
$_SESSION['message']['type'] = "success";
header("Location: voir_panier.php");
exit();
