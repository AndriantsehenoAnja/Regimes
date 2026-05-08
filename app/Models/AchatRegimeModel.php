<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatRegimeModel extends Model
{
    protected $table = 'achat_regime';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'regime_id',
        'prix_paye'
    ];

    protected $validationRules = [

        'user_id' => [
            'rules' => 'required|integer',
            'errors' => [
                'required' => 'Utilisateur obligatoire'
            ]
        ],

        'regime_id' => [
            'rules' => 'required|integer',
            'errors' => [
                'required' => 'Régime obligatoire'
            ]
        ],

        'prix_paye' => [
            'rules' => 'required|decimal',
            'errors' => [
                'required' => 'Prix obligatoire'
            ]
        ]
    ];
}