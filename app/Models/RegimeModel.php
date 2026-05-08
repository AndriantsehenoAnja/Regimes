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
            WHERE r.type_regime = ? OR (ra.type_activite = ? AND ra.type_activite IS NOT NULL)
        ";

        $query = $db->query($sql, [$type_objectif, $type_objectif]);
        $results = $query->getResultArray();

        $suggestions = [];

        foreach ($results as $row) {
            $variation_finale = 0;

            // Calcul de la variation finale selon le type de régime et d'activité
            if ($row['type_regime'] == $type_objectif) {
                $variation_finale += $row['regime_variation'];
            } else {
                $variation_finale -= $row['regime_variation'];
            }

            if ($row['activite_variation'] != null) {
                if ($row['type_activite'] == $type_objectif) {
                    $variation_finale += $row['activite_variation'];
                } else {
                    $variation_finale -= $row['activite_variation'];
                }
            }

            if ($variation_finale > 0) {
                $multiplier = ceil($poids_cible / $variation_finale);

                $suggestions[] = [
                    'regime' => $row['regime_nom'],
                    'activite' => $row['activite_nom'] ?? 'Aucune',
                    'variation_finale_unitaire' => $variation_finale,
                    'multiplicateur' => $multiplier,
                    'duree_totale' => $row['regime_duree'] * $multiplier,
                    'prix_total' => $row['regime_prix'] * $multiplier,
                    'poids_estime_atteint' => $variation_finale * $multiplier
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
        $usersan = new App\Models\UserHealthModel();
        // Since find() might return multiple arrays or an entity, assuming get first element if needed, 
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