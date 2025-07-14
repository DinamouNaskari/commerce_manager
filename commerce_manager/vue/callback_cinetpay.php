<?php
session_start();
require_once '../cinetpay/CinetPay.php';
require_once '../model/connexion.php';

$apiKey = "VOTRE_API_KEY";
$site_id = "VOTRE_SITE_ID";

$cp = new CinetPay($site_id, $apiKey);
$transaction_id = $_POST['cpm_trans_id'] ?? '';

if ($transaction_id) {
    $statusData = $cp->checkPayStatus($transaction_id);
    if ($statusData['cpm_result'] === '00') {
        $client_id = $_SESSION['id'];
        $panier = unserialize($statusData['custom_panier']);

        foreach ($panier as $id_article => $item) {
            $quantite = $item['quantite'];
            $prix = $item['prix'];
            $prix_total = $quantite * $prix;

            // Enregistrer la vente en attente
            $stmt = $connexion->prepare("INSERT INTO vente (id_article, id_client, quantite, prix, etat, statut_paiement)
                                         VALUES (?, ?, ?, ?, 0, 'payé')");
            $stmt->execute([$id_article, $client_id, $quantite, $prix_total]);

            // Réduction du stock
            $up = $connexion->prepare("UPDATE article SET quantite = quantite - ? WHERE id = ?");
            $up->execute([$quantite, $id_article]);
        }

        $_SESSION['panier'] = []; // vider panier
    }
}
