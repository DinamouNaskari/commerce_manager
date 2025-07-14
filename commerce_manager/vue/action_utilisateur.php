<?php
session_start();
require_once '../model/connexion.php';

if ($_SESSION['type_utilisateur'] !== 'administrateur') {
    header('Location: ../vue/dashboard.php');
    exit;
}

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id && $action) {
    switch ($action) {
        case 'delete':
            $stmt = $connexion->prepare("DELETE FROM compte_utilisateur WHERE id = ? AND type_utilisateur = 'client'");
            $stmt->execute([$id]);
            break;
        case 'activate':
            $stmt = $connexion->prepare("UPDATE compte_utilisateur SET actif = '1' WHERE id = ?");
            $stmt->execute([$id]);
            break;
        case 'deactivate':
            $stmt = $connexion->prepare("UPDATE compte_utilisateur SET actif = '0' WHERE id = ?");
            $stmt->execute([$id]);
            break;
    }
}

header("Location: ../vue/client.php");
exit;
