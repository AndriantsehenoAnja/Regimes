<?php

namespace App\Controllers;

use App\Models\ObjectifModel;

class ObjectifController extends BaseController
{
    public function index()
    {
        $objectifModel = new ObjectifModel();
        
        $data = [
            'objectifs' => $objectifModel->findAll()
        ];
        
        return view('programmes/programme1', $data); // Assuming a view will exist
    }
}
