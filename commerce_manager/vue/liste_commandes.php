<?php
include 'entete.php';
$commandes = getCommandesEnAttente(); // fonction de function.php
?>

<div class="home-content">
    <h2>Commandes en attente de validation</h2>

    <?php if (!empty($commandes)): ?>
        <table class="mtable">
            <tr>
                <th>Client</th>
                <th>Article</th>
                <th>Quantité</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?= $commande['nom'] . " " . $commande['prenom'] ?></td>
                    <td><?= $commande['nom_article'] ?></td>
                    <td><?= $commande['quantite'] ?></td>
                    <td><?= number_format($commande['prix'], 0, ',', ' ') ?> F</td>
                    <td><?= date('d/m/Y H:i', strtotime($commande['date_vente'])) ?></td>
                    <td>
                        <a href="valider_vente.php?id=<?= $commande['id'] ?>" class="btn">✅ Valider</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucune commande en attente.</p>
    <?php endif; ?>
</div>

<?php include 'pied.php'; ?>
