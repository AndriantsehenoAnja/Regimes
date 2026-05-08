<?php

namespace App\Controllers;

class RegimeController extends BaseController
{
   public function save_objectif()
    {
        $session = session();
        $data = [
            'objectif' => $this->request->getPost('objectif')
        ];
        $session->set("objectif_data", $data);
        return redirect()->to('/regime');
    }
    
    public function suggerer_regime()
    {
        $session = session();

        $objectifData = $this->request->getPost('objectif');

        if (!$objectifData) {
            return redirect()->to('/objectif')
                ->with('error', 'Veuillez sélectionner un objectif.');
        }

        $objectif = (int)$objectifData;
        $valeur = $this->request->getPost('valeur');

        $regimeModel = new \App\Models\RegimeModel();

        if ($objectif === 3 && !$session->get("user")) {
            return redirect()->to('/login')
                ->with('error', 'Veuillez fournir vos informations santé.');
        } else if ($objectif === 3 && $session->get("user")) {
            // L'utilisateur entre l'IMC cible (dans valeur), le modèle calcule automatiquement la perte/prise et le poids
            $regimes = $regimeModel->getRegimesIMCideal($session->get("user"), $valeur);

            return view('programmes/programme2', [
                'regimes' => $regimes
            ]);
        } else if ($objectif === 1) {
            // Objectif 1: Perdre du poids, la valeur postée est le nombre de kg à perdre
            $regimes = $regimeModel->getSuggestedRegimes('perte', $valeur);

            return view('programmes/programme2', [
                'regimes' => $regimes
            ]);
        }
        // Objectif 2: Prendre du poids, la valeur postée est le nombre de kg à prendre
        $regimes = $regimeModel->getSuggestedRegimes('prise', $valeur);

        return view('programmes/programme2', [
            'regimes' => $regimes
        ]);
    }
}
