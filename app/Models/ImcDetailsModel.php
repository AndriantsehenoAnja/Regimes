<?php

namespace App\Models;

use CodeIgniter\Model;

class ImcDetailsModel extends Model
{
    protected $table = 'imc_details';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'intervalle_min',
        'intervalle_max',
        'categorie'
    ];

    protected $validationRules = [

        'intervalle_min' => [
            'rules' => 'required|decimal',
            'errors' => [
                'required' => 'Intervalle minimum obligatoire',
                'decimal'  => 'Intervalle minimum doit être un nombre décimal'
            ]
        ],

        'intervalle_max' => [
            'rules' => 'required|decimal',
            'errors' => [
                'required' => 'Intervalle maximum obligatoire',
                'decimal'  => 'Intervalle maximum doit être un nombre décimal'
            ]
        ],

        'categorie' => [
            'rules' => 'required|max_length[50]',
            'errors' => [
                'required' => 'Catégorie obligatoire',
                'max_length' => 'Catégorie trop longue'
            ]
        ]
    ];
}