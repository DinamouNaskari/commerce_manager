<?php
include 'connexion.php';

function getArticle($id = null, $searchDATA = array(), $limit = null, $offset = null)
{
    $pagination = "";
    if (!empty($limit) && (!empty($offset) || $offset == 0)) {
        $pagination = " LIMIT $limit OFFSET $offset";
    }

    if (!empty($id)) {
        $sql = "SELECT a.id AS id, id_categorie, nom_article, libelle_categorie, quantite, prix_achat, prix_vente, date_fabrication, 
                date_expiration, images
                FROM article AS a, categorie_article AS c 
                WHERE a.id=? AND c.id=a.id_categorie";

        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();

    } elseif (!empty($searchDATA)) {
        $search = "";
        extract($searchDATA);
        if (!empty($nom_article))
            $search .= " AND a.nom_article LIKE '%$nom_article%' ";
        if (!empty($id_categorie))
            $search .= " AND a.id_categorie = $id_categorie ";
        if (!empty($quantite))
            $search .= " AND a.quantite = $quantite ";
        if (!empty($prix_achat))
            $search .= " AND a.prix_achat = $prix_achat ";
        if (!empty($prix_vente))
            $search .= " AND a.prix_vente = $prix_vente ";
        if (!empty($date_fabrication))
            $search .= " AND DATE(a.date_fabrication) = '$date_fabrication' ";
        if (!empty($date_expiration))
            $search .= " AND DATE(a.date_expiration) = '$date_expiration' ";

        $sql = "SELECT a.id AS id, id_categorie, nom_article, libelle_categorie, quantite, prix_achat, prix_vente, date_fabrication, 
                date_expiration, images
                FROM article AS a, categorie_article AS c 
                WHERE c.id=a.id_categorie $search $pagination";

        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();

    } else {
        $sql = "SELECT a.id AS id, id_categorie, nom_article, libelle_categorie, quantite, prix_achat, prix_vente, date_fabrication, 
                date_expiration, images
                FROM article AS a, categorie_article AS c 
                WHERE c.id=a.id_categorie $pagination";

        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}

function countArticle($searchDATA = array())
{
    if (!empty($searchDATA)) {
        $search = "";
        extract($searchDATA);
        if (!empty($nom_article))
            $search .= " AND a.nom_article LIKE '%$nom_article%' ";
        if (!empty($id_categorie))
            $search .= " AND a.id_categorie = $id_categorie ";
        if (!empty($quantite))
            $search .= " AND a.quantite = $quantite ";
        if (!empty($prix_achat))
            $search .= " AND a.prix_achat = $prix_achat ";
        if (!empty($prix_vente))
            $search .= " AND a.prix_vente = $prix_vente ";
        if (!empty($date_fabrication))
            $search .= " AND DATE(a.date_fabrication) = '$date_fabrication' ";
        if (!empty($date_expiration))
            $search .= " AND DATE(a.date_expiration) = '$date_expiration' ";

        $sql = "SELECT COUNT(*) AS total FROM article AS a, categorie_article AS c 
                WHERE c.id=a.id_categorie $search";

        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetch();
    } else {
        $sql = "SELECT COUNT(*) AS total 
                FROM article AS a, categorie_article AS c 
                WHERE c.id=a.id_categorie";

        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetch();
    }
}

function getClient($id = null)
{
    $sql = !empty($id) ? "SELECT * FROM compte_utilisateur WHERE id=?" : "SELECT * FROM compte_utilisateur";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute(!empty($id) ? array($id) : []);
    return !empty($id) ? $req->fetch() : $req->fetchAll();
}

function getVente($id = null, $filtre = 'valide')
{
    if (!empty($id)) {
        $sql = "SELECT v.*, a.nom_article, a.id AS idArticle, c.nom, c.prenom, c.telephone, c.adresse
                FROM vente v
                JOIN article a ON v.id_article = a.id
                JOIN compte_utilisateur c ON v.id_client = c.id
                WHERE v.id = ?";
        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute([$id]);
        return $req->fetch();
    }

    $where = "";
    switch ($filtre) {
        case 'annule':
            $where = "WHERE v.etat = 0 OR v.statut_paiement = 'annulé'";
            break;
        case 'tous':
            $where = ""; // pas de filtre
            break;
        default:
            $where = "WHERE v.etat = 1 AND v.statut_paiement = 'payé'";
            break;
    }

    $sql = "SELECT v.*, a.nom_article, a.id AS idArticle, c.nom, c.prenom
            FROM vente v
            JOIN article a ON v.id_article = a.id
            JOIN compte_utilisateur c ON v.id_client = c.id
            $where
            ORDER BY v.date_vente DESC";

    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}



function getCommande($id = null)
{
    if (!empty($id)) {
        $sql = "SELECT nom_article, nom, prenom, co.quantite, prix, date_commande, co.id, prix_achat, adresse, telephone
                FROM fournisseur AS f, commande AS co, article AS a 
                WHERE co.id_article=a.id AND co.id_fournisseur=f.id AND co.id=?";
        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute(array($id));
        return $req->fetch();
    } else {
        $sql = "SELECT nom_article, nom, prenom, co.quantite, prix, date_commande, co.id, a.id AS idArticle
                FROM fournisseur AS f, commande AS co, article AS a 
                WHERE co.id_article=a.id AND co.id_fournisseur=f.id";
        $req = $GLOBALS['connexion']->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }
}

function getFournisseur($id = null)
{
    $sql = !empty($id) ? "SELECT * FROM fournisseur WHERE id=?" : "SELECT * FROM fournisseur";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute(!empty($id) ? array($id) : []);
    return !empty($id) ? $req->fetch() : $req->fetchAll();
}

function getAllCommande()
{
    $sql = "SELECT COUNT(*) AS nbre FROM commande";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetch();
}

function getAllVente()
{
    $sql = "SELECT COUNT(*) AS nbre FROM vente WHERE etat=?";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute(array(1));
    return $req->fetch();
}

function getAllArticle()
{
    $sql = "SELECT COUNT(*) AS nbre FROM article";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetch();
}

function getArticlesVendusTotal()
{
    $sql = "SELECT SUM(quantite) AS quantite FROM vente WHERE etat = 1 AND statut_paiement = 'payé'";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetch();
}


function getCA()
{
    $sql = "SELECT SUM(prix) AS prix FROM vente WHERE etat = 1 AND statut_paiement = 'payé'";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetch();
}


function getLastVente()
{
    $sql = "SELECT nom_article, nom, prenom, v.quantite, prix, date_vente, v.id, a.id AS idArticle
            FROM client AS c, vente AS v, article AS a 
            WHERE v.id_article=a.id AND v.id_client=c.id AND etat=? 
            ORDER BY date_vente DESC LIMIT 10";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute(array(1));
    return $req->fetchAll();
}

function getMostVente()
{
    $sql = "SELECT nom_article, SUM(prix) AS prix
            FROM client AS c, vente AS v, article AS a 
            WHERE v.id_article=a.id AND v.id_client=c.id AND etat=? 
            GROUP BY a.id
            ORDER BY SUM(prix) DESC LIMIT 10";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute(array(1));
    return $req->fetchAll();
}

function getVenteEnAttente()
{
    $sql = "SELECT COUNT(*) AS nbre FROM vente WHERE etat = 0 OR statut_paiement = 'en_attente'";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetch();
}

function getVenteEffectuee()
{
    $sql = "SELECT COUNT(*) AS nbre FROM vente WHERE etat = 1 AND statut_paiement = 'payé'";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetch();
}


function getVentesAujourdHui()
{
    $sql = "SELECT COUNT(*) AS nbre 
            FROM vente 
            WHERE etat = 1 AND statut_paiement = 'payé' 
            AND DATE(date_vente) = CURDATE()";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetch();
}

function getCategorie($id = null)
{
    $sql = !empty($id) ? "SELECT * FROM categorie_article WHERE id=?" : "SELECT * FROM categorie_article";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute(!empty($id) ? array($id) : []);
    return !empty($id) ? $req->fetch() : $req->fetchAll();
}

function getCommandesEnAttente()
{
    $sql = "SELECT v.*, a.nom_article, a.id AS idArticle, c.nom, c.prenom
            FROM vente v
            JOIN article a ON v.id_article = a.id
            JOIN client c ON v.id_client = c.id
            WHERE v.etat = 0";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}

function validerCommande($id_vente)
{
    $sql = "UPDATE vente SET etat = 1 WHERE id = ?";
    $req = $GLOBALS['connexion']->prepare($sql);
    return $req->execute([$id_vente]);
}

function getCoutTotalAchats()
{
    $sql = "SELECT SUM(v.quantite * a.prix_achat) AS cout
            FROM vente v
            JOIN article a ON v.id_article = a.id
            WHERE v.etat = 1 AND v.statut_paiement = 'payé'";
    $req = $GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetch();
}



