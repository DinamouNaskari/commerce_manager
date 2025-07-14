<?php
include 'entete.php';

// Simule les jours de la semaine (à remplacer plus tard par des vraies données SQL)
$jours = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
$ventesParJour = [120000, 90000, 140000, 80000, 160000, 100000, 110000]; // à rendre dynamique
$ventes = getLastVente();
$articles = getMostVente();
?>

<style>
.overview-boxes {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.overview-boxes .box {
    flex: 1 1 calc(33.333% - 20px);
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    position: relative;
    min-width: 250px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    box-sizing: border-box;
}

@media screen and (max-width: 1024px) {
    .overview-boxes .box {
        flex: 1 1 calc(50% - 20px);
    }
}

@media screen and (max-width: 600px) {
    .overview-boxes .box {
        flex: 1 1 100%;
    }
}

.sales-boxes {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 30px;
}

.sales-boxes .box {
    flex: 1 1 48%;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    box-sizing: border-box;
}

@media screen and (max-width: 768px) {
    .sales-boxes .box {
        flex: 1 1 100%;
    }
}

.charts-section {
    margin-top: 30px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.charts-section .box {
    flex: 1 1 100%;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    box-sizing: border-box;
}

.sales-details {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 10px;
    margin-top: 15px;
}

.sales-details ul.details {
    flex: 1 1 23%;
    list-style: none;
    padding: 0;
}

.sales-details ul.details li {
    margin-bottom: 10px;
}

.sales-details ul.details li.topic {
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
}
</style>

<div class="home-content">

    <!-- ========== BOÎTES ========== -->
    <div class="overview-boxes">
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Ventes en attente</div>
                <div class="number"><?= getVenteEnAttente()['nbre']; ?></div>
                <div class="indicator">
                    <i class="bx bx-time"></i>
                    <span class="text">Paiement en attente</span>
                </div>
            </div>
            <i class="bx bx-hourglass cart"></i>
        </div>

        <div class="box">
            <div class="right-side">
                <div class="box-topic">Ventes effectuées</div>
                <div class="number"><?= getVenteEffectuee()['nbre']; ?></div>
                <div class="indicator">
                    <i class="bx bx-check-circle"></i>
                    <span class="text">Payées & livrées</span>
                </div>
            </div>
            <i class="bx bx-check cart two"></i>
        </div>

        <div class="box">
            <div class="right-side">
                <div class="box-topic">Articles vendus</div>
                <div class="number"><?= getArticlesVendusTotal()['quantite']; ?></div>
                <div class="indicator">
                    <i class="bx bx-up-arrow-alt"></i>
                    <span class="text">Nombre total</span>
                </div>
            </div>
            <i class="bx bx-package cart three"></i>
        </div>

        <div class="box">
            <div class="right-side">
                <div class="box-topic">Coût des articles</div>
                <div class="number"><?= number_format(getCoutTotalAchats()['cout'], 0, ',', ' ') . ' F'; ?></div>
                <div class="indicator">
                    <i class="bx bx-calculator"></i>
                    <span class="text">Basé sur le prix d'achat</span>
                </div>
            </div>
            <i class="bx bx-money cart four"></i>
        </div>

        <div class="box">
            <div class="right-side">
                <div class="box-topic">Chiffre d'affaires</div>
                <div class="number"><?= number_format(getCA()['prix'], 0, ',', ' ') . ' F'; ?></div>
                <div class="indicator">
                    <i class="bx bx-bar-chart-alt-2"></i>
                    <span class="text">Ventes payées uniquement</span>
                </div>
            </div>
            <i class="bx bx-bar-chart-alt cart five"></i>
        </div>

        <div class="box">
            <div class="right-side">
                <div class="box-topic">Ventes aujourd'hui</div>
                <div class="number"><?= getVentesAujourdHui()['nbre']; ?></div>
                <div class="indicator">
                    <i class="bx bx-calendar-check"></i>
                    <span class="text">Aujourd'hui</span>
                </div>
            </div>
            <i class="bx bx-calendar cart six"></i>
        </div>
    </div>

   
    <!-- ========== DIAGRAMME ========= -->
    <div class="charts-section">
        <div class="box">
            <div class="title">Statistiques graphiques (ventes semaine)</div>
            <canvas id="salesChart" width="100%" height="40"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($jours) ?>,
        datasets: [{
            label: 'Ventes (F)',
            data: <?= json_encode($ventesParJour) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Ventes de la semaine'
            }
        }
    }
});
</script>

<?php include 'pied.php'; ?>
