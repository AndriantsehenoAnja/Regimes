<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\TransactionModel;
use App\Models\UserModel;

class CodeController extends BaseController
{
    public function index()
    {
        return view('code/index');
    }

    public function ajouterArgent()
    {
        $session = session();

        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $codeValue = trim(
            $this->request->getPost('code')
        );

        if (empty($codeValue)) {
            return redirect()->back()
                ->with('error', 'Veuillez entrer un code');
        }

        $codeModel = new CodeModel();
        $transactionModel = new TransactionModel();
        $userModel = new UserModel();

        // Recherche code
        $code = $codeModel
            ->where('code', $codeValue)
            ->first();

        if (!$code) {
            return redirect()->back()
                ->with('error', 'Code invalide');
        }

        // Déjà utilisé
        if ($code['utilise']) {
            return redirect()->back()
                ->with('error', 'Code déjà utilisé');
        }

        // Utilisateur
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Utilisateur introuvable');
        }

        $db = \Config\Database::connect();

        $db->transBegin();

        try {

            // Nouveau solde
            $nouveauSolde =
                $user['solde'] + $code['montant'];

            // Update user
            $userModel->update($userId, [
                'solde' => $nouveauSolde
            ]);

            // Code utilisé
            $codeModel->update($code['id'], [
                'utilise' => 1
            ]);

            // Transaction
            $transactionModel->insert([
                'user_id' => $userId,
                'code_id' => $code['id'],
                'montant' => $code['montant']
            ]);

            if ($db->transStatus() === false) {
                throw new \Exception(
                    'Erreur transaction'
                );
            }

            $db->transCommit();

            return redirect()->back()
                ->with(
                    'success',
                    'Votre solde a été crédité de '
                    . $code['montant']
                    . ' Ar'
                );

        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()->back()
                ->with(
                    'error',
                    'Erreur lors de la transaction'
                );
        }
    }
}