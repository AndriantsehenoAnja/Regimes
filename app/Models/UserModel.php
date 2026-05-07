<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'email',
        'password',
        'genre_id',
        'is_gold',
        'solde'
    ];

    // timestamps
    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    // validation
    protected $validationRules = [
        'nom' => 'required|min_length[3]|max_length[100]',

        'email' => 'required|valid_email|is_unique[users.email]',

        'password' => 'required|min_length[3]|max_length[255]',

        'genre_id' => 'required|integer',

        'solde' => 'permit_empty|decimal'
    ];

    protected $validationMessages = [

        'nom' => [
            'required' => 'Le nom est obligatoire.',
            'min_length' => 'Le nom doit contenir au moins 3 caractères.',
            'max_length' => 'Le nom doit contenir au maximum 100 caractères.'
        ],

        'email' => [
            'required' => 'L\'email est obligatoire.',
            'valid_email' => 'Adresse email invalide.',
            'is_unique' => 'Cet email existe déjà.'
        ],

        'password' => [
            'required' => 'Le mot de passe est obligatoire.',
            'min_length' => 'Le mot de passe doit contenir au moins 3 caractères.'
        ],

        'genre_id' => [
            'required' => 'Le genre est obligatoire.',
            'integer' => 'Genre invalide.'
        ]
    ];

    // hash automatique du mot de passe
    protected $beforeInsert = ['hashPassword'];

    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {

            $data['data']['password'] =
                password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}