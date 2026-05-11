<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminDashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Statistiques utilisateurs non-admin
        $clients_total = $db->query("SELECT COUNT(*) as total FROM users WHERE id NOT IN (SELECT id_user FROM is_admin)")->getRow()->total ?? 0;
        $clients_genre = $db->query("SELECT g.nom as genre, COUNT(u.id) as count FROM users u JOIN genres g ON u.genre_id = g.id WHERE u.id NOT IN (SELECT id_user FROM is_admin) GROUP BY g.nom")->getResultArray();
        
        // Statistiques argents
        $chiffre_affaire = $db->query("SELECT SUM(prix_paye) as total FROM achat_regime")->getRow()->total ?? 0;
        $achats_par_mois = $db->query("SELECT MONTH(date_achat) as mois, SUM(prix_paye) as total FROM achat_regime GROUP BY MONTH(date_achat)")->getResultArray();
        
        // Statistiques régimes
        $regimes_populaires = $db->query("SELECT r.nom, COUNT(ar.regime_id) as achats FROM achat_regime ar JOIN regimes r ON ar.regime_id = r.id GROUP BY r.id, r.nom ORDER BY achats DESC LIMIT 5")->getResultArray();

        // Tableau croisé (pivot table): Achats de Régimes par Genre
        $sql_croise = "
            SELECT r.nom as regime_nom,
                   SUM(CASE WHEN g.nom = 'Homme' THEN 1 ELSE 0 END) as masculin,
                   SUM(CASE WHEN g.nom = 'Femme' THEN 1 ELSE 0 END) as feminin,
                   COUNT(*) as total
            FROM achat_regime ar
            JOIN regimes r ON ar.regime_id = r.id
            JOIN users u ON ar.user_id = u.id
            JOIN genres g ON u.genre_id = g.id
            GROUP BY r.id, r.nom
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
