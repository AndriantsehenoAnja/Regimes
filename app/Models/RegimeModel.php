<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'description',
        'prix',
        'duree',
        'variation',
        'type_regime',
        'pourcentage_viande',
        'pourcentage_poisson',
        'pourcentage_volaille'
    ];

    // timestamps
    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    // validation
    protected $validationRules = [

        'nom' => 'required|min_length[3]|max_length[100]',

        'description' => 'permit_empty|max_length[1000]',

        'prix' => 'required|decimal',

        'duree' => 'required|integer',

        'variation' => 'required|decimal',

        'type_regime' => 'required|in_list[perte,prise]',

        'pourcentage_viande' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',

        'pourcentage_poisson' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',

        'pourcentage_volaille' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]'
    ];

    protected $validationMessages = [

        'nom' => [
            'required' => 'Le nom du régime est obligatoire.',
            'min_length' => 'Le nom doit contenir au moins 3 caractères.'
        ],

        'prix' => [
            'required' => 'Le prix est obligatoire.',
            'decimal' => 'Le prix doit être un nombre.'
        ],

        'duree' => [
            'required' => 'La durée est obligatoire.',
            'integer' => 'La durée doit être un nombre entier.'
        ],

        'variation' => [
            'required' => 'La variation est obligatoire.',
            'decimal' => 'Valeur invalide.'
        ],

        'type_regime' => [
            'required' => 'Le type de régime est obligatoire.',
            'in_list' => 'Le type doit être perte ou prise.'
        ]
    ];

    // validation personnalisée
    protected $beforeInsert = ['verifierPourcentage'];

    protected $beforeUpdate = ['verifierPourcentage'];

    protected function verifierPourcentage(array $data)
    {
        $viande = $data['data']['pourcentage_viande'] ?? 0;

        $poisson = $data['data']['pourcentage_poisson'] ?? 0;

        $volaille = $data['data']['pourcentage_volaille'] ?? 0;

        $total = $viande + $poisson + $volaille;

        if ($total > 100) {

            throw new \RuntimeException(
                'La somme des pourcentages ne doit pas dépasser 100%.'
            );
        }

        return $data;
    }

    public function getSuggestedRegimes($type_objectif, $poids_cible)
    {
        $db = \Config\Database::connect();

        $sql = "
            SELECT 
                r.id AS regime_id, r.nom AS regime_nom, r.duree AS regime_duree, r.prix AS regime_prix, r.variation AS regime_variation, r.type_regime,
                a.id AS activite_id, a.nom AS activite_nom, ra.variation AS activite_variation, ra.type_activite
            FROM regimes r
            LEFT JOIN regime_activite ra ON r.id = ra.regime_id
            LEFT JOIN activites a ON ra.activite_id = a.id
        "; // On enlève le WHERE pour traiter tout et combiner

        $query = $db->query($sql);
        $results = $query->getResultArray();

        // Grouper par régime
        $regimes = [];
        foreach ($results as $row) {
            $regime_id = $row['regime_id'];
            if (!isset($regimes[$regime_id])) {
                $regimes[$regime_id] = [
                    'regime_nom' => $row['regime_nom'],
                    'regime_duree' => $row['regime_duree'],
                    'regime_prix' => $row['regime_prix'],
                    'regime_variation' => $row['regime_variation'],
                    'type_regime' => $row['type_regime'],
                    'activites' => [],
                    'id' => $regime_id
                ];
            }
            if ($row['activite_id']) {
                $regimes[$regime_id]['activites'][] = [
                    'activite_nom' => $row['activite_nom'],
                    'activite_variation' => $row['activite_variation'],
                    'type_activite' => $row['type_activite']
                ];
            }
        }

        $suggestions = [];

        foreach ($regimes as $regime) {
            $variation_finale = 0;

            // Calcul de la variation finale du régime
            if ($regime['type_regime'] == $type_objectif) {
                $variation_finale += $regime['regime_variation'];
            } else {
                $variation_finale -= $regime['regime_variation'];
            }

            $activites_noms = [];
            // Ajouter les variations de toutes les activités du régime
            foreach ($regime['activites'] as $activite) {
                if ($activite['type_activite'] == $type_objectif) {
                    $variation_finale += $activite['activite_variation'];
                } else {
                    $variation_finale -= $activite['activite_variation'];
                }
                $activites_noms[] = $activite['activite_nom'];
            }

            if ($variation_finale > 0) {
                $multiplier = ceil($poids_cible / $variation_finale);

                $suggestions[] = [
                    'regime' => $regime['regime_nom'],
                    'activite' => !empty($activites_noms) ? implode(', ', $activites_noms) : 'Aucune',
                    'variation_finale_unitaire' => $variation_finale,
                    'multiplicateur' => $multiplier,
                    'duree_totale' => $regime['regime_duree'] * $multiplier,
                    'prix_total' => $regime['regime_prix'] * $multiplier,
                    'poids_estime_atteint' => $variation_finale * $multiplier,
                    'id' => $regime['id']
                ];
            }
        }

        return $suggestions;
    }

    // régimes de perte de poids
    public function getRegimesPerte()
    {
        return $this->where('type_regime', 'perte')
                    ->findAll();
    }

    // régimes de prise de poids
    public function getRegimesPrise()
    {
        return $this->where('type_regime', 'prise')
                    ->findAll();
    }

    // recherche par durée
    public function getByDuree($duree)
    {
        return $this->where('duree <=', $duree)
                    ->findAll();
    }

    // recherche par budget
    public function getByPrix($prixMax)
    {
        return $this->where('prix <=', $prixMax)
                    ->findAll();
    }

    public function getRegimesIMCideal($user, $valeur)
    {
        $usersan = new \App\Models\UserHealthModel();
        // Since find() might return multiple arrays or an array of objects
        // or just first() depending on their structure. We keep their original lines.
        $usersante = $usersan->where('user_id =', $user['id'])->first(); 
        if (!$usersante) {
            $usersante = $usersan->where('user_id =', $user['id'])->find();
            if (isset($usersante[0])) {
                $usersante = $usersante[0];
            }
        }
        
        $ecarsIMC = $usersante['imc'] - $valeur;
        $poids = $ecarsIMC * $usersante['taille'];
        
        if ($poids < 0) {
            return $this->getSuggestedRegimes('perte', $poids * (-1));
        } else {
            return $this->getSuggestedRegimes('prise', $poids);
        }
    }
}