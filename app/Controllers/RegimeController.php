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
            return redirect()->to('/objectif')->with('error', 'Veuillez d\'abord sélectionner un objectif.');
        }
        
        $objectif = $objectifData['objectif'];
        $regimeModel = new \App\Models\RegimeModel();
        if($objectif === 3 and !$session->get("user")){
            return redirect()->to('/health')->with('error', 'Veuillez d\'abord fournir vos informations de santé pour suggérer un régime adapté à votre objectif de prise de poids.');
        }
        else if($objectif === 3 and $session->get("user")){
            
        }
        
    }
}
