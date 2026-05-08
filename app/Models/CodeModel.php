<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table            = 'codes';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'code',
        'montant',
        'utilise'
    ];

    protected $validationRules = [
        'code' => 'required|min_length[5]|max_length[50]|is_unique[codes.code,id,{id}]',
        'montant' => 'required|decimal|greater_than[0]',
        'utilise' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'code' => [
            'required' => 'Le code est obligatoire',
            'is_unique' => 'Ce code existe déjà'
        ],

        'montant' => [
            'required' => 'Le montant est obligatoire',
            'decimal' => 'Le montant doit être un nombre valide',
            'greater_than' => 'Le montant doit être supérieur à 0'
        ]
    ];
}