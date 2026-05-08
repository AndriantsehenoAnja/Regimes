<?php

namespace App\Controllers;

use App\Models\ImcDetailsModel;
use App\Models\ObjectifModel;

class ObjectifController extends BaseController
{
    public function index()
    {
        $objectifModel = new ObjectifModel();
        $imc = new ImcDetailsModel();
        
        $data = [
            'objectifs' => $objectifModel->findAll(),
            'imc' => $imc->findAll()
        ];
        return view('programmes/programme1', $data); // Assuming a view will exist
    }
}
