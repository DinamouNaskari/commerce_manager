<?php
include 'entete.php';

if (!empty($_GET['id'])) {
    $article = getVente($_GET['id']);
}
?>
<div class="home-content">
    <div class="overview-boxes">

        <!-- Formulaire de vente -->
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifVente.php" : "../model/ajoutVente.php" ?>"
                method="post">
                <input type="hidden" name="id" value="<?= !empty($_GET['id']) ? $article['id'] : "" ?>">

                <label for="id_article">Article</label>
                <select onchange="setPrixEtStock()" name="id_article" id="id_article">
                    <option value="">-- Choisir un article --</option>
                    <?php
                    $articles = getArticle();
                    if (!empty($articles) && is_array($articles)) {
                        foreach ($articles as $value) {
                            $selected = (!empty($_GET['id']) && $article['idArticle'] == $value['id']) ? "selected" : "";
                            ?>
                            <option <?= $selected ?> data-prix="<?= $value['prix_vente'] ?>"
                                data-stock="<?= $value['quantite'] ?>" value="<?= $value['id'] ?>">
                                <?= $value['nom_article'] . " - " . $value['quantite'] . " en stock" ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <label for="id_client">Client</label>
                <select name="id_client" id="id_client">
                    <option value="">-- Choisir un client --</option>
                    <?php
                    $clients = getClient();
                    if (!empty($clients) && is_array($clients)) {
                        foreach ($clients as $value) {
                            $selected = (!empty($_GET['id']) && $article['id_client'] == $value['id']) ? "selected" : "";
                            ?>
                            <option <?= $selected ?> value="<?= $value['id'] ?>">
                                <?= $value['nom'] . " " . $value['prenom'] ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>

                <label for="quantite">Quantité</label>
                <input onkeyup="checkStock()" type="number" name="quantite" id="quantite"
                    placeholder="Veuillez saisir la quantité"
                    value="<?= !empty($_GET['id']) ? $article['quantite'] : "" ?>">

                <label for="prix">Prix unitaire (auto)</label>
                <input type="number" name="prix" id="prix" readonly
                    value="<?= !empty($_GET['id']) ? $article['prix'] : "" ?>">

                <div id="stock-alert" style="color: red; display: none; font-size: 13px;">⚠ Quantité demandée supérieure
                    au stock disponible !</div>

                <button type="submit">Valider</button>

                <?php if (!empty($_SESSION['message']['text'])): ?>
                    <div class="alert <?= $_SESSION['message']['type'] ?>">
                        <?= $_SESSION['message']['text'] ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Liste des ventes -->
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Article</th>
                    <th>Client</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php
                $ventes = getVente();
                if (!empty($ventes) && is_array($ventes)) {
                    foreach ($ventes as $value) {
                        ?>
                        <tr>
                            <td><?= $value['nom_article'] ?></td>
                            <td><?= $value['nom'] . " " . $value['prenom'] ?></td>
                            <td><?= $value['quantite'] ?></td>
                            <td><?= number_format($value['prix'], 0, ',', ' ') . " F" ?></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($value['date_vente'])) ?></td>
                            <td>
                                <a href="recuVente.php?id=<?= $value['id'] ?>"><i class='bx bx-receipt'>Imprimer</i></a>
                                <a onclick="annuleVente(<?= $value['id'] ?>, <?= $value['idArticle'] ?>, <?= $value['quantite'] ?>)"
                                    style="color: red;"><i class='bx bx-stop-circle'>Annuler</i></a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>Aucune vente trouvée.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>
</section>

<?php include 'pied.php'; ?>

<!-- JS -->
<script>
    function annuleVente(idVente, idArticle, quantite) {
        if (confirm("Voulez-vous vraiment annuler cette vente ?")) {
            window.location.href = "../model/annuleVente.php?idVente=" + idVente + "&idArticle=" + idArticle + "&quantite=" + quantite;
        }
    }

    function setPrixEtStock() {
        const select = document.getElementById('id_article');
        const prix = document.getElementById('prix');
        const stock = select.options[select.selectedIndex]?.getAttribute('data-stock');
        const prixVente = select.options[select.selectedIndex]?.getAttribute('data-prix');
        prix.value = prixVente || 0;
        checkStock();
    }

    function checkStock() {
        const select = document.getElementById('id_article');
        const quantite = parseFloat(document.getElementById('quantite').value || 0);
        const stock = parseFloat(select.options[select.selectedIndex]?.getAttribute('data-stock') || 0);
        const alertBox = document.getElementById('stock-alert');

        alertBox.style.display = (quantite > stock) ? 'block' : 'none';
    }
</script>