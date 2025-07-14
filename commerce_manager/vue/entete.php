<?php
session_start();
require_once '../model/function.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['type_utilisateur'])) {
    header("Location: ../login.php");
    exit();
}

$type = $_SESSION['type_utilisateur'];
$nom_page = ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF'])));
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title><?= $nom_page ?> | MICROFIT_IP</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar hidden-print">
        <div class="logo-details">
            <i class="bx bxl-c-plus-plus"></i>
            <span class="logo_name">MICROFIT_IP</span>
        </div>
        <ul class="nav-links">

            <!-- ADMINISTRATEUR -->
            <?php if ($type === 'administrateur'): ?>
                <li><a href="dashboard.php" class="<?= $nom_page === 'Dashboard' ? 'active' : '' ?>"><i
                            class="bx bx-grid-alt"></i><span class="links_name">Dashboard</span></a></li>
                <li><a href="article.php" class="<?= $nom_page === 'Article' ? 'active' : '' ?>"><i
                            class="bx bx-box"></i><span class="links_name">Article</span></a></li>
                <li><a href="categorie.php" class="<?= $nom_page === 'Categorie' ? 'active' : '' ?>"><i
                            class="bx bx-list-ul"></i><span class="links_name">Catégorie</span></a></li>
                <li><a href="fournisseur.php" class="<?= $nom_page === 'Fournisseur' ? 'active' : '' ?>"><i
                            class="bx bx-user"></i><span class="links_name">Fournisseur</span></a></li>
            <?php endif; ?>

            <!-- ADMIN & VENDEUR -->
            <?php if (in_array($type, ['administrateur', 'vendeur'])): ?>
                <li class="menu-role-admin-vendeur">
                    <a href="vente.php" class="<?= $nom_page === 'Vente' ? 'active' : '' ?>">
                        <i class="bx bx-shopping-bag"></i><span class="links_name">Vente</span>
                    </a>
                </li>
                <li class="menu-role-admin-vendeur">
                    <a href="client.php" class="<?= $nom_page === 'Client' ? 'active' : '' ?>">
                        <i class="bx bx-user"></i><span class="links_name">Client</span>
                    </a>
                </li>
                <li class="menu-role-admin-vendeur">
                    <a href="catalogue_client.php" class="<?= $nom_page === 'Catalogue_client' ? 'active' : '' ?>">
                        <i class="bx bx-store"></i><span class="links_name">Boutique</span>
                    </a>
                </li>
                <li class="menu-role-admin-vendeur">
                    <a href="liste_commandes.php">
                        <i class='bx bx-task'></i><span class="links_name">Commandes</span>
                    </a>
                </li>
            <?php endif; ?>


            <!-- LIVREUR -->
            <?php if ($type === 'livreur'): ?>
                <li><a href="livraison.php" class="<?= $nom_page === 'Livraison' ? 'active' : '' ?>"><i
                            class="bx bx-car"></i><span class="links_name">Livraisons</span></a></li>
            <?php endif; ?>

            <!-- CLIENT -->
            <?php if ($type === 'client'): ?>
                <li><a href="liste_articles_client.php" class="<?= $nom_page === 'Categorie' ? 'active' : '' ?>"><i
                            class="bx bx-list-ul"></i><span class="links_name">Article</span></a></li>
                <li><a href="commande_client.php" class="<?= $nom_page === 'Commande_client' ? 'active' : '' ?>"><i
                            class="bx bx-book-alt"></i><span class="links_name">Mes commandes</span></a></li>
                <li><a href="voir_panier.php" class="<?= $nom_page === 'Panier' ? 'active' : '' ?>"><i
                            class="bx bx-heart"></i><span class="links_name">Mon panier</span></a></li>
            <?php endif; ?>

            <!-- TOUS LES UTILISATEURS -->
            <li class="log_out">
                <a href="deconnexion.php">
                    <i class="bx bx-log-out"></i>
                    <span class="links_name">Déconnexion</span>
                </a>
            </li>
        </ul>
    </div>

    <section class="home-section">
        <nav class="hidden-print">
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
                <span class="dashboard"><?= $nom_page ?></span>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Recherche...">
                <i class="bx bx-search"></i>
            </div>
            <div class="profile-details">
                <span class="admin_name"><?= ucfirst($_SESSION['prenom'] ?? 'Utilisateur') ?> (<?= $type ?>)</span>
                <i class="bx bx-chevron-down"></i>
            </div>
        </nav>