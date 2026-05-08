<?php

namespace App\Controllers;

use App\Models\AchatRegimeModel;
use App\Models\RegimeModel;
use App\Models\UserModel;

class AchatRegimeController extends BaseController
{
    public function acheter()
    {
        $session = session();

        // Vérification login
        if (!$session->has('user')) {

            return redirect()->to('/login')
                ->with(
                    'error',
                    'Veuillez vous connecter'
                );
        }

        $sessionUser = $session->get('user');

        $userId = $sessionUser['id'];

        $regimeId = $this->request->getPost('regime_id');

        $multiplicateur = $this->request->getPost('multiplicateur');

        $prix = $this->request->getPost('prix');

        if (!$regimeId || !$prix) {

            return redirect()->to('/suggerer')
                ->with(
                    'error',
                    'Informations invalides'
                );
        }

        $userModel = new UserModel();

        $regimeModel = new RegimeModel();

        $achatModel = new AchatRegimeModel();

        // Utilisateur DB
        $dbUser = $userModel->find($userId);

        if (!$dbUser) {

            return redirect()->to('/suggerer')
                ->with(
                    'error',
                    'Utilisateur introuvable'
                );
        }

        // Vérification régime
        $regime = $regimeModel->find($regimeId);

        if (!$regime) {

            return redirect()->to('/suggerer')
                ->with(
                    'error',
                    'Régime introuvable'
                );
        }

        // Réduction Gold
        if ($dbUser['is_gold']) {

            $prix = $prix - ($prix * 0.15);
        }

        // Vérification solde
        if ($dbUser['solde'] < $prix) {

            return redirect()->to('/suggerer')
                ->with(
                    'error',
                    'Solde insuffisant'
                );
        }

        $db = \Config\Database::connect();

        $db->transBegin();

        try {

            // Nouveau solde
            $nouveauSolde =
                $dbUser['solde'] - $prix;

            // Update user
            $userModel->update($userId, [
                'solde' => $nouveauSolde
            ]);

            // Achat
            $achatModel->insert([
                'user_id' => $userId,
                'regime_id' => $regimeId,
                'prix_paye' => $prix
            ]);

            if ($db->transStatus() === false) {

                throw new \Exception(
                    'Erreur transaction'
                );
            }

            $db->transCommit();

            // Update session
            $dbUser['solde'] = $nouveauSolde;

            $session->set('user', $dbUser);

            return redirect()->to('/suggerer')
                ->with(
                    'success',
                    'Régime acheté avec succès'
                );

        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()->to('/suggerer')
                ->with(
                    'error',
                    'Erreur lors de l’achat'
                );
        }
    }
}