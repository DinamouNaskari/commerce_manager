<?php
include 'entete.php';

if (!empty($_GET['id'])) {
    $categorie = getCategorie($_GET['id']);
}
?>

<div class="home-content">
    <div class="overview-boxes">
        <!-- Formulaire d'ajout ou modification -->
        <div class="box">
            <form action="<?= !empty($_GET['id']) ? "../model/modifCategorie.php" : "../model/ajoutCategorie.php" ?>"
                method="post">
                <label for="libelle_categorie">Libelle</label>
                <input value="<?= !empty($_GET['id']) ? $categorie['libelle_categorie'] : "" ?>" type="text"
                    name="libelle_categorie" id="libelle_categorie" placeholder="Veuillez saisir le libellé" required>
                <input value="<?= !empty($_GET['id']) ? $categorie['id'] : "" ?>" type="hidden" name="id" id="id">

                <button type="submit">Valider</button>

                <?php if (!empty($_SESSION['message']['text'])): ?>
                    <div class="alert <?= $_SESSION['message']['type'] ?>">
                        <?= $_SESSION['message']['text'] ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
            </form>
        </div>

        <!-- Tableau des catégories -->
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Libellé catégorie</th>
                    <th>Action</th>
                </tr>
                <?php
                $categories = getCategorie();

                if (!empty($categories) && is_array($categories)) {
                    foreach ($categories as $value) {
                        ?>
                        <tr>
                            <td><?= $value['libelle_categorie'] ?></td>
                            <td>
                                <a href="?id=<?= $value['id'] ?>">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                &nbsp;&nbsp;
                                <a href="../model/supprimerCategorie.php?id=<?= $value['id'] ?>"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                                    <i class='bx bx-trash' style="color: red;"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>

</section>

<?php include 'pied.php'; ?>