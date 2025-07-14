<?php
include 'entete.php';

if (!empty($_GET['id'])) {
    $article = getArticle($_GET['id']);
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 2;
$offset = ($page - 1) * $limit;
?>

<div class="home-content">
    <div class="overview-boxes">
        <!-- Formulaire ajout/modif -->
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifArticle.php" : "../model/ajoutArticle.php" ?>"
                method="post" enctype="multipart/form-data">
                <label for="nom_article">Nom de l'article</label>
                <input type="text" name="nom_article" id="nom_article" placeholder="Veuillez saisir le nom"
                    value="<?= !empty($_GET['id']) ? $article['nom_article'] : "" ?>">
                <input type="hidden" name="id" id="id" value="<?= !empty($_GET['id']) ? $article['id'] : "" ?>">

                <label for="id_categorie">Catégorie</label>
                <select name="id_categorie" id="id_categorie">
                    <option value="">--Choisir une catégorie--</option>
                    <?php
                    $categories = getCategorie();
                    if (is_array($categories) && !empty($categories)) {
                        foreach ($categories as $value) {
                            $selected = (!empty($_GET['id']) && $article['id_categorie'] == $value['id']) ? "selected" : "";
                            echo "<option value='{$value['id']}' $selected>{$value['libelle_categorie']}</option>";
                        }
                    }
                    ?>
                </select>

                <label for="quantite">Quantité</label>
                <input type="number" name="quantite" id="quantite" placeholder="Veuillez saisir la quantité"
                    value="<?= !empty($_GET['id']) ? $article['quantite'] : "" ?>">

                <label for="prix_achat">Prix achat</label>
                <input type="number" name="prix_achat" id="prix_achat" placeholder="Veuillez saisir le prix achat"
                    value="<?= !empty($_GET['id']) ? $article['prix_achat'] : "" ?>">

                <label for="prix_vente">Prix vente</label>
                <input type="number" name="prix_vente" id="prix_vente" placeholder="Veuillez saisir le prix vente"
                    value="<?= !empty($_GET['id']) ? $article['prix_vente'] : "" ?>">

                <label for="date_fabrication">Date de fabrication</label>
                <input type="datetime-local" name="date_fabrication" id="date_fabrication"
                    value="<?= !empty($_GET['id']) ? $article['date_fabrication'] : "" ?>">

                <label for="date_expiration">Date d'expiration</label>
                <input type="datetime-local" name="date_expiration" id="date_expiration"
                    value="<?= !empty($_GET['id']) ? $article['date_expiration'] : "" ?>">

                <label for="images">Image</label>
                <input type="file" name="images" id="images">

                <button type="submit">Valider</button>

                <?php if (!empty($_SESSION['message']['text'])): ?>
                    <div class="alert <?= $_SESSION['message']['type'] ?>">
                        <?= $_SESSION['message']['text'] ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Recherche et tableau -->
        <div style="display: block;" class="box">

            <br>
            <table class="mtable">
                <tr>
                    <th>Nom article</th>
                    <th>Catégorie</th>
                    <th>Quantité</th>
                    <th>Prix achat</th>
                    <th>Prix vente</th>
                    <th>Date fabrication</th>
                    <th>Date expiration</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <?php
                $total_articles = 0;
                $total_pages = 0;
                if (!empty($_GET['s'])) {
                    $articles = getArticle(null, $_GET, $limit, $offset);
                    $count = countArticle($_GET);
                } else {
                    $articles = getArticle(null, null, $limit, $offset);
                    $count = countArticle(null);
                }

                $total_articles = $count['total'];
                $total_pages = ceil($total_articles / $limit);

                if (!empty($articles) && is_array($articles)) {
                    foreach ($articles as $value) {
                        echo "<tr>
                            <td>{$value['nom_article']}</td>
                            <td>{$value['libelle_categorie']}</td>
                            <td>{$value['quantite']}</td>
                            <td>{$value['prix_achat']}</td>
                            <td>{$value['prix_vente']}</td>
                            <td>" . date('d/m/Y H:i:s', strtotime($value['date_fabrication'])) . "</td>
                            <td>" . date('d/m/Y H:i:s', strtotime($value['date_expiration'])) . "</td>
                            <td><img width='100' height='100' src='{$value['images']}' alt='{$value['nom_article']}'></td>
                            <td><a href='?id={$value['id']}'><i class='bx bx-edit-alt'></i></a></td>
                        </tr>";
                    }
                }
                ?>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                if ($page > 1) {
                    $prev_page = $page - 1;
                    echo "<a href='?page=$prev_page'>&laquo; Précédent</a> ";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i == $page) ? "active" : "";
                    echo "<a class='$active' href='?page=$i'>$i</a> ";
                }

                if ($page < $total_pages) {
                    $next_page = $page + 1;
                    echo "<a href='?page=$next_page'>Suivant &raquo;</a> ";
                }
                ?>
            </div>
        </div>
    </div>
</div>
</section>

<?php include 'pied.php'; ?>