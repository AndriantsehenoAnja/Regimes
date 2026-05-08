<?php

namespace App\Controllers;

use App\Models\ActiviteModel;

class ActiviteController extends BaseController
{
    public function form()
    {
        return view('activite/form');
    }

    public function save()
    {
        $activiteModel = new ActiviteModel();

        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'calories_brulees' => $this->request->getPost('calories_brulees')
        ];

        // Validation
        if (!$activiteModel->insert($data)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $activiteModel->errors()
                );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Activité ajoutée avec succès'
            );
    }
}