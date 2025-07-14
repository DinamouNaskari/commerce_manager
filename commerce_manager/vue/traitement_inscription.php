<?php
require_once '../model/connexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $email = trim($_POST["email"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);
    $type_utilisateur = trim($_POST["type_utilisateur"]);

    if ($nom && $prenom && $email && $mot_de_passe && $type_utilisateur) {

        // Si administrateur, limiter à 3 comptes
        if ($type_utilisateur === "administrateur") {
            $nb_admins = $connexion->query("SELECT COUNT(*) FROM compte_utilisateur WHERE type_utilisateur = 'administrateur'")->fetchColumn();
            if ($nb_admins >= 3) {
                echo "<p style='color:red;'>Nombre maximum d'administrateurs atteint.</p>";
                echo "<p><a href='creer_compte.php'>Retour</a></p>";
                exit();
            }
        }

        // Vérifie que l'email n'existe pas déjà
        $check = $connexion->prepare("SELECT id FROM compte_utilisateur WHERE email = ?");
        $check->execute([$email]);
        if ($check->rowCount() > 0) {
            echo "<p style='color:red;'>Cet email est déjà utilisé.</p>";
            echo "<p><a href='creer_compte.php'>Retour</a></p>";
            exit();
        }

        // Hachage du mot de passe
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insertion dans la base
        $stmt = $connexion->prepare("INSERT INTO compte_utilisateur (nom, prenom, email, mot_de_passe, type_utilisateur, actif)
                                     VALUES (?, ?, ?, ?, ?, '1')");
        $stmt->execute([$nom, $prenom, $email, $hash, $type_utilisateur]);

        echo "<p style='color:green;'>Compte $type_utilisateur créé avec succès !</p>";
        echo "<p><a href='login.php'>Se connecter</a></p>";
    } else {
        echo "<p style='color:red;'>Veuillez remplir tous les champs.</p>";
        echo "<p><a href='creer_compte.php'>Retour</a></p>";
    }
} else {
    header("Location: creer_compte.php");
    exit();
}
?>
