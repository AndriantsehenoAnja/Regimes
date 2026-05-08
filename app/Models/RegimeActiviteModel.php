<?php
namespace App\Models;

use CodeIgniter\Model;

class RegimeActiviteModel extends Model
{
    protected $table = 'regime_activite';
    protected $primaryKey = 'id';
    protected $allowedFields = ['regime_id', 'activite_id', 'type_activite', 'variation'];
}