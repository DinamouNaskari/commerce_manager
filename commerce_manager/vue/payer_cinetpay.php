<?php
/*
session_start();
require_once '../cinetpay/CinetPay.php';
require_once '../model/connexion.php';

if (empty($_SESSION['panier'])) {
    header("Location: voir_panier.php");
    exit();
}

$apiKey = "VOTRE_API_KEY"; // Remplacer
$site_id = "VOTRE_SITE_ID"; // Remplacer

$transaction_id = uniqid();
$_SESSION['transaction_id'] = $transaction_id;

$total = 0;
foreach ($_SESSION['panier'] as $item) {
    $total += $item['prix'] * $item['quantite'];
}

$cp = new CinetPay($site_id, $apiKey);

$cp->setTransId($transaction_id);
$cp->setAmount($total);
$cp->setCurrency("XOF");
$cp->setDesignation("Paiement commande client ID " . $_SESSION['id']);
$cp->setNotifyUrl("https://votresite.com/callback_cinetpay.php");
$cp->setReturnUrl("https://votresite.com/retour_paiement.php");
$cp->setCustomerName($_SESSION['prenom']);
$cp->setCustomerSurname($_SESSION['nom']);
$cp->setData(['custom_panier' => serialize($_SESSION['panier'])]);

$cp->displayPayButton(); // Affiche les boutons Moov / Airtel
*/

?>
<html>
    <p>Erreur 404</p>
</html>
