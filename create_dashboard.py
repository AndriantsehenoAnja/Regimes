import os

controller_content = """<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\CodeModel;
use CodeIgniter\Controller;

class AdminDashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Statistiques clients
        $clients_total = $db->query("SELECT COUNT(*) as total FROM clients")->getRow()->total;
        $clients_genre = $db->query("SELECT genre, COUNT(*) as count FROM clients GROUP BY genre")->getResultArray();
        
        // Statistiques argents
        $chiffre_affaire = $db->query("SELECT SUM(montant) as total FROM achat_regimes")->getRow()->total ?? 0;
        $achats_par_mois = $db->query("SELECT MONTH(date_achat) as mois, SUM(montant) as total FROM achat_regimes GROUP BY MONTH(date_achat)")->getResultArray();
        
        // Statistiques régimes
        $regimes_populaires = $db->query("SELECT r.nom, COUNT(ar.id_regime) as achats FROM achat_regimes ar JOIN regimes r ON ar.id_regime = r.id_regime GROUP BY r.id_regime ORDER BY achats DESC LIMIT 5")->getResultArray();
        
        $data = [
            'clients_total' => $clients_total,
            'clients_genre' => $clients_genre,
            'chiffre_affaire' => $chiffre_affaire,
            'achats_par_mois' => $achats_par_mois,
            'regimes_populaires' => $regimes_populaires
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
</head>
<body>
    <?php include APPPATH . 'Views/includes/header.php'; ?>
    <div class="container mt-5">
        <h1>Tableau de bord Administrateur</h1>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h3>Total Clients</h3>
                        <h2><?= $clients_total ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h3>Chiffre d'affaires</h3>
                        <h2><?= $chiffre_affaire ?> Ar</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <h4>Répartition des clients par genre</h4>
                <canvas id="genreChart"></canvas>
            </div>
            <div class="col-md-6">
                <h4>Évolution du Chiffre d'Affaire</h4>
                <canvas id="caChart"></canvas>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-12">
                <h4>Régimes les plus populaires</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Régime</th>
                            <th>Nombre d'achats</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($regimes_populaires as $regime): ?>
                        <tr>
                            <td><?= esc($regime['nom']) ?></td>
                            <td><?= $regime['achats'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        const genreData = <?= json_encode($clients_genre) ?>;
        const caData = <?= json_encode($achats_par_mois) ?>;
        
        new Chart(document.getElementById('genreChart'), {
            type: 'pie',
            data: {
                labels: genreData.map(d => d.genre == '1' ? 'Homme' : 'Femme'),
                datasets: [{
                    data: genreData.map(d => d.count),
                    backgroundColor: ['#36a2eb', '#ff6384']
                }]
            }
        });
        
        new Chart(document.getElementById('caChart'), {
            type: 'bar',
            data: {
                labels: caData.map(d => 'Mois ' + d.mois),
                datasets: [{
                    label: 'Chiffre d\'affaire (Ar)',
                    data: caData.map(d => d.total),
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

routes_path = 'app/Config/Routes.php'
with open(routes_path, 'r') as f:
    content = f.read()

if "AdminDashboardController::index" not in content:
    content = content.replace(
        "$routes->get('login','AdminController::login');",
        "$routes->get('/admin/dashboard', 'AdminDashboardController::index', ['filter' => 'admin']);\n$routes->get('login','AdminController::login');"
    )
    with open(routes_path, 'w') as f:
        f.write(content)

