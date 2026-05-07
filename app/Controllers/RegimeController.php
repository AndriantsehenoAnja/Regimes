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

        $objectifData = $session->get("objectif_data");

        if (!$objectifData) {

            return redirect()->to('/objectif')
                ->with('error', 'Veuillez sélectionner un objectif.');
        }

        $objectif = (int)$objectifData['objectif'];

        $regimeModel = new \App\Models\RegimeModel();

        if ($objectif === 3 && !$session->get("user")) {

            return redirect()->to('/health')
                ->with('error', 'Veuillez fournir vos informations santé.');
        }

        else if ($objectif === 3 && $session->get("user")) {

            $valeur = $this->request->getPost('valeur');

            $regimes = $regimeModel
                ->getRegimesIMCideal($session->get("user"), $valeur);

            return view('regime_suggere', [
                'regimes' => $regimes
            ]);
        }

        else if ($objectif === 1) {

            $regimes = $regimeModel->getRegimesPerte();

            return view('regime_suggere', [
                'regimes' => $regimes
            ]);
        }

        $regimes = $regimeModel->getRegimesPrise();

        return view('regime_suggere', [
            'regimes' => $regimes
        ]);
    }
}
