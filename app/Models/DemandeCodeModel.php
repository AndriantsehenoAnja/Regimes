<?php

namespace App\Models;

use CodeIgniter\Model;

class DemandeCodeModel extends Model
{
    protected $table = 'demandes_code';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['user_id', 'code_id', 'status'];

    public function getPendingDemandes()
    {
        return $this->select('demandes_code.*, users.nom as user_nom, codes.code as code_val, codes.montant')
                    ->join('users', 'users.id = demandes_code.user_id')
                    ->join('codes', 'codes.id = demandes_code.code_id')
                    ->where('demandes_code.status', 0)
                    ->findAll();
    }
}
