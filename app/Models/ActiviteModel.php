<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
    protected $table = 'activites';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'description',
        'calories_brulees'
    ];

    protected $validationRules = [

        'nom' => [
            'rules' => 'required|min_length[2]|max_length[100]',
            'errors' => [
                'required' => 'Le nom est obligatoire'
            ]
        ],

        'description' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La description est obligatoire'
            ]
        ],

        'calories_brulees' => [
            'rules' => 'required|integer|greater_than[0]',
            'errors' => [
                'required' => 'Calories obligatoire',
                'integer' => 'Doit être un nombre',
                'greater_than' => 'Doit être supérieur à 0'
            ]
        ]
    ];
}