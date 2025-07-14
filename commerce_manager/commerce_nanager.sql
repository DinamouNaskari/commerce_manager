-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 14 juil. 2025 à 20:28
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `commerce_nanager`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `nom_article` varchar(50) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_achat` int(11) NOT NULL,
  `prix_vente` int(11) NOT NULL,
  `date_fabrication` datetime NOT NULL,
  `date_expiration` datetime NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `id_fournisseur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `nom_article`, `id_categorie`, `quantite`, `prix_achat`, `prix_vente`, `date_fabrication`, `date_expiration`, `images`, `id_fournisseur`) VALUES
(8, 'Télécommande', 3, 4, 300, 1000, '2025-06-08 00:00:00', '2025-07-15 00:00:00', '../public/images/WhatsApp Image 2023-01-23 at 12.57.19.jpeg', NULL),
(9, 'Cable VGA', 3, 0, 500, 2000, '2025-06-06 08:37:00', '2026-08-29 08:38:00', '../public/images/1749567349_vga.jpg', NULL),
(10, 'HP', 1, 0, 0, 50000, '2024-09-05 09:34:00', '2026-04-09 09:34:00', '../public/images/ordi hp.jpg', NULL),
(11, 'DELL', 1, 1, 0, 40000, '2024-08-07 12:00:00', '2027-03-11 12:01:00', '../public/images/profile.jpg', NULL),
(12, 'HP corei5', 1, 2, 100000, 150000, '2024-03-07 12:52:00', '2027-04-09 12:53:00', '../public/images/1749552813_ordi hp.jpg', NULL),
(13, 'Airpod pro 3', 7, 5, 150, 500, '2024-11-05 15:29:00', '2026-04-25 15:29:00', '../public/images/1749562174_airpod.jpg', NULL),
(14, 'Aire Nike', 8, 4, 5000, 10000, '2024-09-04 10:24:00', '2026-09-25 10:24:00', '../public/images/1749630317_air nike.jpg', NULL),
(15, 'Aire Nike Pro', 8, 5, 5000, 7500, '2024-10-18 10:26:00', '2026-08-21 10:26:00', '../public/images/1749630476_couvre.jpg', NULL),
(16, 'Veste gris', 9, 7, 15000, 24999, '2025-01-24 10:28:00', '2027-04-17 10:28:00', '../public/images/1749630557_veste gris.jpg', NULL),
(17, 'Veste Noir', 9, 3, 14999, 27000, '2024-05-10 10:29:00', '2027-04-16 10:30:00', '../public/images/1749630629_veste.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categorie_article`
--

CREATE TABLE `categorie_article` (
  `id` int(11) NOT NULL,
  `libelle_categorie` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie_article`
--

INSERT INTO `categorie_article` (`id`, `libelle_categorie`) VALUES
(2, 'Imprimante'),
(3, 'Accessoire'),
(5, 'Ordinateur'),
(7, 'Casque'),
(8, 'chaussure'),
(9, 'Habits');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `adresse` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `telephone`, `adresse`) VALUES
(1, 'Dinamou', 'Frederic', '+235 98960382', 'Abeche, Tchad'),
(2, 'Naska', 'fredo', '+235 85007514', 'rue de 40');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `id_fournisseur` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `date_commande` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_client`
--

CREATE TABLE `commande_client` (
  `id_commande` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `quantite` int(11) NOT NULL CHECK (`quantite` > 0),
  `id_transaction` varchar(255) NOT NULL,
  `statut_paiement` enum('en_attente','payé','expédié','livré','annulé') DEFAULT 'en_attente',
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compte_utilisateur`
--

CREATE TABLE `compte_utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `type_utilisateur` enum('administrateur','vendeur','livreur','client') NOT NULL,
  `actif` enum('0','1') NOT NULL DEFAULT '1',
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `compte_utilisateur`
--

INSERT INTO `compte_utilisateur` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `type_utilisateur`, `actif`, `cree_le`) VALUES
(1, 'Dinamou', 'Frédéric', 'ri714@gmail.com', '$2y$10$NRYGQ7L2cVyzgOON3PA2dO9IYP2BNr/uKwUJFhTlLhYTn/o142SQq', 'vendeur', '1', '2025-06-08 23:20:06'),
(2, 'Dinamou', 'Frédéric', 'admin4@gmail.com', '$2y$10$JwhXV2bo/hb3F7GibedakuMbKIqPtNC3MUARAmFM6A3jNXOApcdTi', 'administrateur', '1', '2025-06-09 00:02:38'),
(3, 'livreur', 'liv', 'livreur@gmail.com', '$2y$10$x1Az9qCVwQ8.HJ6/.LJcGOpBaffw62CwTorqE3mFwfIFwI8Rj0lG6', 'livreur', '1', '2025-06-09 00:22:54'),
(4, 'client', 'clt', 'client@gmail.com', '$2y$10$qpdcnTApHLCL16ET4g7uaOnMOKGexBBj3TWReJVAIqQDNJJUrGdzu', 'client', '1', '2025-06-09 00:39:36'),
(5, 'jacques', 'frederic', 'jacques@gmail.com', '$2y$10$4Ns6coF7Sq5Lw0blCxU1luthvXQBS0/eBV1CW5SKMh8q2pWN3i1EG', 'client', '1', '2025-06-16 08:05:54'),
(6, 'ven', 'n1', 'vendeur@gmail.com', '$2y$10$Xc6gbUstrxasn.3eaZsbAuhgAQH4wxSPVU2cXZ7GG8Y6lnNk7fz3C', 'vendeur', '1', '2025-06-23 07:53:39');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(2) NOT NULL,
  `prenom` varchar(3) NOT NULL,
  `email` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `prenom`, `email`) VALUES
(1, 'Ja', 'Ama', 'jaha');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `adresse` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `nom`, `prenom`, `telephone`, `adresse`) VALUES
(1, 'Naska', 'Fredo', '+235 92470763', 'Abeche, Tchad'),
(2, 'FREDO', 'Test', '+235 90000000', 'Pala, Tchad'),
(3, 'Dinamou', 'Frédéric', '+235 66388334', 'Djodo gassa');

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_livreur` int(11) NOT NULL,
  `date_livraison` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` enum('en_attente','en_cours','livré','annulé') DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livreur`
--

CREATE TABLE `livreur` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `zone_livraison` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1 CHECK (`quantite` > 0),
  `ajoute_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `profil_client`
--

CREATE TABLE `profil_client` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vendeur`
--

CREATE TABLE `vendeur` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `magasin` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE `vente` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `date_vente` timestamp NOT NULL DEFAULT current_timestamp(),
  `etat` enum('0','1') NOT NULL DEFAULT '1',
  `statut_paiement` enum('en_attente','payé','expédié','livré','annulé') DEFAULT 'payé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`id`, `id_article`, `id_client`, `quantite`, `prix`, `date_vente`, `etat`, `statut_paiement`) VALUES
(6, 11, 4, 1, 300, '2025-06-09 10:04:32', '0', 'payé'),
(7, 8, 3, 6, 63000, '2025-06-10 12:47:25', '1', 'payé'),
(8, 8, 4, 4, 1000, '2025-06-10 11:40:44', '0', 'annulé'),
(9, 11, 3, 1, 40000, '2025-06-10 12:15:05', '', 'payé'),
(10, 8, 3, 3, 1000, '2025-06-10 12:49:25', '0', 'payé'),
(11, 9, 4, 2, 2000, '2025-06-10 13:04:08', '0', 'payé'),
(12, 11, 2, 1, 40000, '2025-06-10 13:22:26', '0', 'payé'),
(13, 11, 2, 1, 40000, '2025-06-10 13:23:09', '0', 'payé'),
(14, 10, 2, 3, 50000, '2025-06-11 06:11:15', '0', 'payé'),
(15, 10, 3, 0, 50000, '2025-06-11 07:15:16', '', 'payé'),
(16, 8, 2, 3, 1000, '2025-06-16 08:39:31', '0', 'payé'),
(17, 13, 5, 2, 500, '2025-06-23 08:04:23', '0', 'payé'),
(18, 13, 5, 2, 500, '2025-06-23 08:04:23', '0', 'payé'),
(19, 9, 1, 2, 2000, '2025-07-14 08:55:45', '0', 'payé');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categorie` (`id_categorie`),
  ADD KEY `fk_article_fournisseur` (`id_fournisseur`);

--
-- Index pour la table `categorie_article`
--
ALTER TABLE `categorie_article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_article` (`id_article`),
  ADD KEY `id_fournisseur` (`id_fournisseur`);

--
-- Index pour la table `commande_client`
--
ALTER TABLE `commande_client`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `compte_utilisateur`
--
ALTER TABLE `compte_utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_livreur` (`id_livreur`);

--
-- Index pour la table `livreur`
--
ALTER TABLE `livreur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produit` (`id_produit`),
  ADD KEY `panier_ibfk_2` (`id_utilisateur`);

--
-- Index pour la table `profil_client`
--
ALTER TABLE `profil_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `vendeur`
--
ALTER TABLE `vendeur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `vente`
--
ALTER TABLE `vente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_article` (`id_article`),
  ADD KEY `id_client` (`id_client`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `categorie_article`
--
ALTER TABLE `categorie_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commande_client`
--
ALTER TABLE `commande_client`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `compte_utilisateur`
--
ALTER TABLE `compte_utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `livreur`
--
ALTER TABLE `livreur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profil_client`
--
ALTER TABLE `profil_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vendeur`
--
ALTER TABLE `vendeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vente`
--
ALTER TABLE `vente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_fournisseur` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id`);

--
-- Contraintes pour la table `commande_client`
--
ALTER TABLE `commande_client`
  ADD CONSTRAINT `commande_client_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `compte_utilisateur` (`id`),
  ADD CONSTRAINT `commande_client_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`);

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `livraison_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `compte_utilisateur` (`id`),
  ADD CONSTRAINT `livraison_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `livraison_ibfk_3` FOREIGN KEY (`id_livreur`) REFERENCES `compte_utilisateur` (`id`);

--
-- Contraintes pour la table `livreur`
--
ALTER TABLE `livreur`
  ADD CONSTRAINT `livreur_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `compte_utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `compte_utilisateur` (`id`);

--
-- Contraintes pour la table `profil_client`
--
ALTER TABLE `profil_client`
  ADD CONSTRAINT `profil_client_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `compte_utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vendeur`
--
ALTER TABLE `vendeur`
  ADD CONSTRAINT `vendeur_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `compte_utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `vente_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `vente_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `compte_utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
