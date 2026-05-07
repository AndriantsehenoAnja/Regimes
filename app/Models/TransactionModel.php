<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'user_id',
        'code_id',
        'montant',
        'date_transaction'
    ];

    protected $validationRules = [
        'user_id' => 'required|integer',
        'code_id' => 'required|integer',
        'montant' => 'required|decimal|greater_than[0]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'Utilisateur obligatoire'
        ],

        'code_id' => [
            'required' => 'Code obligatoire'
        ],

        'montant' => [
            'required' => 'Montant obligatoire'
        ]
    ];
}