<?php
include 'entete.php';
include_once '../model/function.php';

$articles = getArticle();
?>

<div class="home-content">
    <h2>Catalogue des articles</h2>

    <?php if (!empty($_SESSION['message']['text'])): ?>
        <div class="alert <?= $_SESSION['message']['type'] ?>">
            <?= $_SESSION['message']['text'] ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <table class="mtable">
        <thead>
            <tr>
                <th>Article</th>
                <th>Catégorie</th>
                <th>Stock</th>
                <th>Prix</th>
                <th>Image</th>
                <th>Quantité</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <form method="post" action="ajouter_au_panier.php">
                        <input type="hidden" name="id_article" value="<?= $article['id'] ?>">
                        <td><?= $article['nom_article'] ?></td>
                        <td><?= $article['libelle_categorie'] ?></td>
                        <td><?= $article['quantite'] ?></td>
                        <td><?= number_format($article['prix_vente'], 0, ',', ' ') ?> F</td>
                        <td>
                            <img src="<?= $article['images'] ?>" alt="Image" style="width: 80px; height: 80px;">
                        </td>
                        <td>
                            <input type="number" name="quantite" value="1" min="1" max="<?= $article['quantite'] ?>"
                                style="width: 60px;">
                        </td>
                        <td>
                            <button type="submit">Ajouter</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="voir_panier.php" style="float: right;"><i class='bx bx-cart'></i> Voir mon panier</a>
</div>

<?php include 'pied.php'; ?>