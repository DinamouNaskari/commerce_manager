<?php
include 'entete.php';

$id_client = $_SESSION['id'];
$commandes = [];

if ($id_client) {
    $sql = "SELECT v.id, a.nom_article, v.quantite, v.prix, v.date_vente, v.statut_paiement
            FROM vente v
            JOIN article a ON v.id_article = a.id
            WHERE v.id_client = ? AND v.etat = 1
            ORDER BY v.date_vente DESC";

    $req = $connexion->prepare($sql);
    $req->execute([$id_client]);
    $commandes = $req->fetchAll();
}
?>

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <h2>Mes commandes</h2>

            <?php if (!empty($commandes)): ?>
                <table class="mtable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Article</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandes as $cmd): ?>
                            <tr>
                                <td><?= $cmd['id'] ?></td>
                                <td><?= $cmd['nom_article'] ?></td>
                                <td><?= $cmd['quantite'] ?></td>
                                <td><?= number_format($cmd['prix'], 0, ',', ' ') . ' F' ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($cmd['date_vente'])) ?></td>
                                <td>
                                    <?php
                                    switch ($cmd['statut_paiement']) {
                                        case 'payé':
                                            echo "<span style='color:green;'>Payé</span>";
                                            break;
                                        case 'en_attente':
                                            echo "<span style='color:orange;'>En attente</span>";
                                            break;
                                        case 'annulé':
                                            echo "<span style='color:red;'>Annulé</span>";
                                            break;
                                        default:
                                            echo ucfirst($cmd['statut_paiement']);
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align:center;">Aucune commande trouvée.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</section>
<?php include 'pied.php'; ?>