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
        'variation_poid_min',
        'variation_poid_max',
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

        'variation_poid_min' => 'required|decimal',

        'variation_poid_max' => 'required|decimal',

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

        'variation_poid_min' => [
            'required' => 'La variation minimale est obligatoire.',
            'decimal' => 'Valeur invalide.'
        ],

        'variation_poid_max' => [
            'required' => 'La variation maximale est obligatoire.',
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

    public function getRegimesIMCideal($user,$valeur){
        $usersan = new App\Models\UserHealthModel();
        $usersante = $usersan->where('user_id =',$user['id'])->find();

        $ecarsIMC = $usersante['imc'] - $valeur;
        $poids = $ecarsIMC*$usersante['taille'];
        if ($poids<0){
            return $this->where(['type_regime =perte'],['variation_poid_min <=',$poids*(-1),'<= variation_poid_max'])
                        ->findAll();
        }
        else{
            return $this->where(['type_regime =prise'],['variation_poid_min <=',$poids*(-1),'<= variation_poid_max'])
                        ->findAll();
        }
    }

    
}