import os

controller_content = """<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminDashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Statistiques clients
        $clients_total = $db->query("SELECT COUNT(*) as total FROM clients")->getRow()->total ?? 0;
        $clients_genre = $db->query("SELECT genre, COUNT(*) as count FROM clients GROUP BY genre")->getResultArray();
        
        // Statistiques argents
        $chiffre_affaire = $db->query("SELECT SUM(montant) as total FROM achat_regimes")->getRow()->total ?? 0;
        $achats_par_mois = $db->query("SELECT MONTH(date_achat) as mois, SUM(montant) as total FROM achat_regimes GROUP BY MONTH(date_achat)")->getResultArray();
        
        // Statistiques régimes
        $regimes_populaires = $db->query("SELECT r.nom, COUNT(ar.id_regime) as achats FROM achat_regimes ar JOIN regimes r ON ar.id_regime = r.id_regime GROUP BY r.id_regime ORDER BY achats DESC LIMIT 5")->getResultArray();

        // Tableau croisé (pivot table): Achats de Régimes par Genre
        // Assumant qu'on a un lien achat_regimes -> clients pour obtenir le genre
        $sql_croise = "
            SELECT r.nom as regime_nom,
                   SUM(CASE WHEN c.genre = 1 THEN 1 ELSE 0 END) as masculin,
                   SUM(CASE WHEN c.genre = 2 THEN 1 ELSE 0 END) as feminin,
                   COUNT(*) as total
            FROM achat_regimes ar
            JOIN regimes r ON ar.id_regime = r.id_regime
            JOIN clients c ON ar.id_client = c.id_client
            GROUP BY r.id_regime, r.nom
        ";
        $achats_genre_croise = $db->query($sql_croise)->getResultArray();
        
        $data = [
            'clients_total' => $clients_total,
            'clients_genre' => $clients_genre,
            'chiffre_affaire' => $chiffre_affaire,
            'achats_par_mois' => $achats_par_mois,
            'regimes_populaires' => $regimes_populaires,
            'achats_genre_croise' => $achats_genre_croise
        ];
        
        return view('admin/dashboard', $data);
    }
}
"""

view_content = """<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?= base_url('style/bootstrap.min.css') ?>">
    <style>
        .card { box-shadow: 0 4px 8px rgba(0,0,0,0.1); border:none; margin-bottom: 20px;}
        .card-title { font-weight: bold; }
    </style>
</head>
<body>
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
                    label: 'Chiffre d\'affaire (Ar)',
                    data: caValues,
                    backgroundColor: '#4bc0c0'
                }]
            }
        });
    </script>
</body>
</html>
"""

os.makedirs('app/Controllers', exist_ok=True)
os.makedirs('app/Views/admin', exist_ok=True)

with open('app/Controllers/AdminDashboardController.php', 'w') as f:
    f.write(controller_content)
    
with open('app/Views/admin/dashboard.php', 'w') as f:
    f.write(view_content)

