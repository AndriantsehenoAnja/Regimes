<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'email',
        'mot_de_passe'
    ];

    protected $validationRules = [

        'nom' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'Le nom est obligatoire',
                'min_length' => 'Le nom doit contenir au moins 3 caractères'
            ]
        ],

        'email' => [
            'rules' => 'required|valid_email|is_unique[admin.email]',
            'errors' => [
                'required' => 'L’email est obligatoire',
                'valid_email' => 'Email invalide',
                'is_unique' => 'Cet email existe déjà'
            ]
        ],

        'mot_de_passe' => [
            'rules' => 'required|min_length[6]',
            'errors' => [
                'required' => 'Le mot de passe est obligatoire',
                'min_length' => 'Le mot de passe doit contenir au moins 6 caractères'
            ]
        ]
    ];
}