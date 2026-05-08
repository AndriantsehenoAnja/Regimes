<?php

namespace App\Controllers;

use App\Models\ActiviteModel;

class ActiviteController extends BaseController
{
    public function edit($id)
    {
        $activiteModel = new ActiviteModel();

        $activite = $activiteModel->find($id);

        if (!$activite) {
            return redirect()
                ->back()
                ->with('error', 'Activité non trouvée');
        }

        return view('activite/edit', [
            'activite' => $activite
        ]);
    }

    public function update($id)
    {
        $activiteModel = new ActiviteModel();

        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'calories_brulees' => $this->request->getPost('calories_brulees')
        ];

        // Validation
        if (!$activiteModel->update($id, $data)) {

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
                'Activité mise à jour avec succès'
            );
    }
    public function delete($id)
    {
        $activiteModel = new ActiviteModel();

        if (!$activiteModel->find($id)) {
            return redirect()
                ->back()
                ->with('error', 'Activité non trouvée');
        }
        $regimeActiviteModel = new \App\Models\RegimeActiviteModel();
        $regimeActiviteModel->where('activite_id', $id)->delete();
        $activiteModel->delete($id);

        return redirect()
            ->back()
            ->with('success', 'Activité supprimée avec succès');
    }
    public function index()
{
    $activiteModel = new ActiviteModel();

    $activites = $activiteModel
        ->orderBy('id', 'DESC')
        ->findAll();

    return view('activite/index', [
        'activites' => $activites
    ]);
}
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