<?php

namespace App\Controllers;

use App\Models\UserModel;

class GoldController extends BaseController
{
    private $goldPrice = 50000;

    public function index()
    {
        return view('gold/index', [
            'goldPrice' => $this->goldPrice
        ]);
    }

    public function activer()
    {
        $session = session();
        $user = $session->get('user');

        if (!$user) {
            return redirect()->to('/login');
        }
        $userId = $user['id'] ;

        $userModel = new UserModel();

        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()
                ->with(
                    'error',
                    'Utilisateur introuvable'
                );
        }

        // Déjà gold
        if ($user['is_gold']) {
            return redirect()->back()
                ->with(
                    'error',
                    'Option Gold déjà activée'
                );
        }

        // Vérification solde
        if ($user['solde'] < $this->goldPrice) {

            return redirect()->back()
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
            $user['solde'] - $this->goldPrice;
            // Update user
            $userModel->update($userId, [
                'solde' => $nouveauSolde,
                'is_gold' => 1
            ]);
            $user['solde'] = $nouveauSolde;
            if ($db->transStatus() === false) {
                throw new \Exception(
                    'Erreur transaction'
                );
            }
            $session->set('user', $user);
            $db->transCommit();

            // Update session
            $session->set([
                'is_gold' => 1,
                'solde' => $nouveauSolde
            ]);
            $session->set('user', $user);

            return redirect()->back()
                ->with(
                    'success',
                    'Option Gold activée avec succès'
                );

        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()->back()
                ->with(
                    'error',
                    'Erreur lors de l’activation'
                );
        }
    }
}
