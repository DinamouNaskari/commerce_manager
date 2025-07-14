<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer un compte</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8;
    }
    .register-card {
      max-width: 500px;
      margin: 60px auto;
      padding: 2rem;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
    }
  </style>
  <script>
    function afficherChamps() {
      const type = document.getElementById('type_utilisateur').value;
      const champsAdmin = document.getElementById('champAdmin');
      champsAdmin.style.display = (type === 'administrateur') ? 'block' : 'none';
    }
  </script>
</head>
<body>

<div class="container">
  <div class="register-card">
    <h3 class="text-center mb-4"><i class="bi bi-person-plus me-2"></i>Créer un compte</h3>

    <form action="traitement_inscription.php" method="POST">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="mot_de_passe" class="form-label">Mot de passe</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="type_utilisateur" class="form-label">Type de compte</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
          <select name="type_utilisateur" id="type_utilisateur" class="form-select" onchange="afficherChamps()" required>
            <option value="">-- Sélectionner --</option>
            <option value="administrateur">Administrateur</option>
            <option value="vendeur">Vendeur</option>
            <option value="livreur">Livreur</option>
            <option value="client">Client</option>
          </select>
        </div>
      </div>

      <div id="champAdmin" class="alert alert-warning" style="display: none;">
        ⚠️ Le nombre d'administrateurs est limité à 3.
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle me-1"></i>Créer le compte
        </button>
      </div>
    </form>

    <div class="text-center mt-3">
      <a href="login.php"><i class="bi bi-box-arrow-in-left"></i> Déjà inscrit ? Se connecter</a>
    </div>
  </div>
</div>

</body>
</html>
