<?php
session_start();
require_once '../model/connexion.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);

    if (!empty($email) && !empty($mot_de_passe)) {
        $sql = "SELECT * FROM compte_utilisateur WHERE email = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user["actif"] === "1" && password_verify($mot_de_passe, $user["mot_de_passe"])) {
            $_SESSION["utilisateur_id"] = $user["id"];
            $_SESSION["nom"] = $user["nom"];
            $_SESSION["prenom"] = $user["prenom"];
            $_SESSION["type_utilisateur"] = $user["type_utilisateur"];

            switch ($user["type_utilisateur"]) {
                case 'administrateur':
                    header("Location: dashboard.php");
                    exit();
                case 'vendeur':
                    header("Location: vente.php");
                    exit();
                case 'livreur':
                    header("Location: livraison.php");
                    exit();
                case 'client':
                    header("Location: client.php");
                    exit();
                default:
                    $message = "Type d'utilisateur inconnu.";
            }
        } else {
            $message = "Identifiants invalides ou compte inactif.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .login-card {
            max-width: 400px;
            margin: 80px auto;
            padding: 2rem;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-card">
        <h3 class="text-center mb-4"><i class="bi bi-box-arrow-in-right me-2"></i>Connexion</h3>

        <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" name="mot_de_passe" id="mot_de_passe" required>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                </button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <a href="creer_compte.php"><i class="bi bi-person-plus"></i> Créer un compte</a> |
            <a href="mot_de_passe_oublie.php"><i class="bi bi-question-circle"></i> Mot de passe oublié ?</a>
        </div>
    </div>
</div>

</body>
</html>
