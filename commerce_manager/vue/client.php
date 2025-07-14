<?php
include 'entete.php';

$type = $_SESSION['type_utilisateur'] ?? '';
$id_utilisateur = $_SESSION['utilisateur_id'] ?? null;

require_once '../model/connexion.php';

// 🔁 Cas client : on récupère uniquement ses infos
if ($type === 'client') {
    $sql = "SELECT cu.id, cu.nom, cu.prenom, cu.email, pc.telephone, pc.adresse
            FROM compte_utilisateur cu
            LEFT JOIN profil_client pc ON cu.id = pc.id_utilisateur
            WHERE cu.id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$id_utilisateur]);
    $client = $stmt->fetch();
}

// 🔁 Cas vendeur/admin : on récupère tous les clients
if ($type === 'vendeur' || $type === 'administrateur') {
    $sql = "SELECT cu.id, cu.nom, cu.prenom, cu.email, cu.actif, pc.telephone, pc.adresse
            FROM compte_utilisateur cu
            LEFT JOIN profil_client pc ON cu.id = pc.id_utilisateur
            WHERE cu.type_utilisateur = 'client'";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $clients = $stmt->fetchAll();
}
?>

<div class="home-content">
    <div class="overview-boxes">

        <!-- ✅ Section pour le client -->
        <?php if ($type === 'client' && $client): ?>
        <div class="box">
            <h4>Mon Profil</h4>
            <table class="mtable">
                <tr><th>Nom</th><td><?= htmlspecialchars($client['nom']) ?></td></tr>
                <tr><th>Prénom</th><td><?= htmlspecialchars($client['prenom']) ?></td></tr>
                <tr><th>Email</th><td><?= htmlspecialchars($client['email']) ?></td></tr>
            </table>
        </div>
        <?php endif; ?>

        <!-- ✅ Liste des clients visible pour admin ou vendeur -->
        <?php if (($type === 'administrateur' || $type === 'vendeur') && !empty($clients)): ?>
        <div class="box">
            <h4>Liste des clients</h4>
            <table class="mtable table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <?php if ($type === 'administrateur'): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($clients as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nom']) ?></td>
                        <td><?= htmlspecialchars($c['prenom']) ?></td>
                        <td><?= htmlspecialchars($c['email']) ?></td>
                        
                        <?php if ($type === 'administrateur'): ?>
                        <td>
                            <a href="../controller/action_utilisateur.php?id=<?= $c['id'] ?>&action=delete"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Voulez-vous vraiment supprimer ce client ?')">
                                <i class='bx bx-trash'></i>
                            </a>

                            <a href="../controller/action_utilisateur.php?id=<?= $c['id'] ?>&action=<?= $c['actif'] === '1' ? 'deactivate' : 'activate' ?>"
                               class="btn btn-sm <?= $c['actif'] === '1' ? 'btn-secondary' : 'btn-success' ?>">
                                <i class='bx <?= $c['actif'] === '1' ? 'bx-lock' : 'bx-unlock' ?>'></i>
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php include 'pied.php'; ?>
