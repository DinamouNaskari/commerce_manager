<?php
include 'entete.php';

$articles = getArticle();
?>

<div class="home-content">
    <h2 style="margin-bottom: 20px;">Nos articles</h2>

    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <div style="border: 1px solid #ccc; border-radius: 8px; padding: 10px; width: 250px;">
                    <img src="<?= $article['images'] ?>" alt="<?= $article['nom_article'] ?>"
                        style="width:100%; height:180px; object-fit:cover;">
                    <h4><?= $article['nom_article'] ?></h4>
                    <p><strong>Prix :</strong> <?= number_format($article['prix_vente'], 0, ',', ' ') ?> F</p>
                    <p><strong>Stock :</strong> <?= $article['quantite'] ?></p>
                    <form action="panier.php" method="post">
                        <input type="hidden" name="id_article" value="<?= $article['id'] ?>">
                        <label for="quantite_<?= $article['id'] ?>">Quantité :</label>
                        <input type="number" name="quantite" id="quantite_<?= $article['id'] ?>" value="1" min="1"
                            max="<?= $article['quantite'] ?>" style="width: 60px;">
                        <button type="submit" name="ajouter" style="margin-top: 10px;">Ajouter au panier</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'pied.php'; ?>