<?php

namespace App\Models;

use CodeIgniter\Model;

class UserHealthModel extends Model
{
    protected $table = 'user_health';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'taille',
        'poids',
        'imc'
    ];

    protected $validationRules = [

        'user_id' => 'required|integer',

        'taille' => 'required|decimal',

        'poids' => 'required|decimal'
    ];

    protected $validationMessages = [

        'taille' => [
            'required' => 'La taille est obligatoire.',
            'decimal' => 'La taille doit être un nombre.'
        ],

        'poids' => [
            'required' => 'Le poids est obligatoire.',
            'decimal' => 'Le poids doit être un nombre.'
        ]
    ];

    // calcul automatique IMC
    protected $beforeInsert = ['calculIMC'];

    protected $beforeUpdate = ['calculIMC'];

    protected function calculIMC(array $data)
    {
        if (
            isset($data['data']['taille']) &&
            isset($data['data']['poids'])
        ) {

            $taille = $data['data']['taille'];

            $poids = $data['data']['poids'];

            if ($taille > 0) {

                $imc = $poids / ($taille * $taille);

                $data['data']['imc'] = round($imc, 2);
            }
        }

        return $data;
    }

    // catégorie IMC
    public function getCategorieIMC($imc)
    {
        if ($imc < 18.5) {
            return 'Maigreur';
        }

        if ($imc < 25) {
            return 'Normal';
        }

        if ($imc < 30) {
            return 'Surpoids';
        }

        return 'Obésité';
    }
}