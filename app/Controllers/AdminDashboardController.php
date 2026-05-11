<?php

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
