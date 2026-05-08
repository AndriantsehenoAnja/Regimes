<?php

namespace App\Controllers;

use App\Models\AchatRegimeModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $session = session();

        // Vérification connexion
        if (!$session->has('user')) {

            return redirect()->to('/login')
                ->with(
                    'error',
                    'Veuillez vous connecter'
                );
        }

        $user = $session->get('user');

        $achatModel = new AchatRegimeModel();

        // Récupération des achats
        $achats = $achatModel
            ->select('
                achat_regime.*,
                regimes.nom as regime_nom,
                regimes.description,
                regimes.duree,
                regimes.type_regime
            ')
            ->join(
                'regimes',
                'regimes.id = achat_regime.regime_id'
            )
            ->where(
                'achat_regime.user_id',
                $user['id']
            )
            ->orderBy(
                'achat_regime.date_achat',
                'DESC'
            )
            ->findAll();

        return view('profile/index', [
            'user' => $user,
            'achats' => $achats
        ]);
    }
}