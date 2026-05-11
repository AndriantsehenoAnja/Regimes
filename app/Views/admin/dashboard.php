<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .card { box-shadow: 0 4px 8px rgba(0,0,0,0.1); border:none; margin-bottom: 20px;}
    .card-title { font-weight: bold; }
</style>

<div class="container mt-5 mb-5">
    <h1 class="mb-4">Tableau d'Administration (Dashboard)</h1>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4 class="card-title">Total Clients</h4>
                    <h2><?= $clients_total ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4 class="card-title">Chiffre d'Affaire</h4>
                    <h2><?= number_format($chiffre_affaire, 2, ',', ' ') ?> Ar</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h4>Répartition des clients par genre</h4>
                <canvas id="genreChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h4>Évolution du Chiffre d'Affaire par mois</h4>
                <canvas id="caChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h4>Régimes les plus populaires</h4>
                <table class="table table-bordered table-striped mt-2">
                    <thead class="table-dark">
                        <tr>
                            <th>Régime</th>
                            <th>Nombre d'achats</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($regimes_populaires as $regime): ?>
                        <tr>
                            <td><?= esc($regime['nom']) ?></td>
                            <td><?= esc($regime['achats']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h4>Tableau croisé : Achats de Régimes par Genre</h4>
                <table class="table table-bordered table-striped mt-2">
                    <thead class="table-dark">
                        <tr>
                            <th>Régime</th>
                            <th>Masculin</th>
                            <th>Féminin</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($achats_genre_croise as $row): ?>
                        <tr>
                            <td><?= esc($row['regime_nom']) ?></td>
                            <td><?= esc($row['masculin']) ?></td>
                            <td><?= esc($row['feminin']) ?></td>
                            <td><strong><?= esc($row['total']) ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const genreData = <?= json_encode($clients_genre) ?>;
    const caData = <?= json_encode($achats_par_mois) ?>;
    
    let genreLabels = [];
    let genreValues = [];
    genreData.forEach(d => {
        genreLabels.push(d.genre == '1' ? 'Homme' : 'Femme');
        genreValues.push(d.count);
    });

    new Chart(document.getElementById('genreChart'), {
        type: 'pie',
        data: {
            labels: genreLabels,
            datasets: [{
                data: genreValues,
                backgroundColor: ['#36a2eb', '#ff6384']
            }]
        }
    });
    
    let caLabels = [];
    let caValues = [];
    caData.forEach(d => {
        caLabels.push('Mois ' + d.mois);
        caValues.push(d.total);
    });

    new Chart(document.getElementById('caChart'), {
        type: 'bar',
        data: {
            labels: caLabels,
            datasets: [{
                label: 'Chiffre d'affaire (Ar)',
                data: caValues,
                backgroundColor: '#4bc0c0'
            }]
        }
    });
</script>
<?= $this->endSection() ?>
