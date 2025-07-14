<?php
include 'entete.php';

$client_id = $_SESSION['id']; // L'ID du client connecté
?>

<div class="home-content">
    <h2>Mon panier</h2>

    <?php if (!empty($_SESSION['panier'])): ?>
        <form action="valider_commande.php" method="post">
            <table class="mtable">
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
                <?php
                $total = 0;
                foreach ($_SESSION['panier'] as $id_article => $item):
                    $total_item = $item['prix'] * $item['quantite'];
                    $total += $total_item;
                    ?>
                    <tr>
                        <td><?= $item['nom'] ?></td>
                        <td><?= $item['quantite'] ?></td>
                        <td><?= number_format($item['prix'], 0, ',', ' ') ?> F</td>
                        <td><?= number_format($total_item, 0, ',', ' ') ?> F</td>
                    </tr>
                    <!-- Champs cachés pour chaque article -->
                    <input type="hidden" name="articles[<?= $id_article ?>][quantite]" value="<?= $item['quantite'] ?>">
                    <input type="hidden" name="articles[<?= $id_article ?>][prix]" value="<?= $item['prix'] ?>">
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong><?= number_format($total, 0, ',', ' ') ?> F</strong></td>
                </tr>
            </table>
            
            <form action="payer_commande.php" method="post">
                <input type="hidden" name="id_client" value="<?= $client_id ?>">
                <input type="hidden" name="total" value="<?= $total ?>">
                <?php foreach ($_SESSION['panier'] as $id_article => $item): ?>
                    <input type="hidden" name="articles[<?= $id_article ?>][quantite]" value="<?= $item['quantite'] ?>">
                    <input type="hidden" name="articles[<?= $id_article ?>][prix]" value="<?= $item['prix'] ?>">
                <?php endforeach; ?>
                <a href="payer_cinetpay.php" class="btn">💳 Commander & Payer avec Mobile Money</a>

            </form>

        </form>
    <?php else: ?>
        <p>Votre panier est vide.</p>
    <?php endif; ?>
</div>

<?php include 'pied.php'; ?>