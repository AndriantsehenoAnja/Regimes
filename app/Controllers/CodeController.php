<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use App\Models\DemandeCodeModel;

class CodeController extends BaseController
{
    public function index()
    {
        return view('code/index');
    }

    public function ajouterArgent()
    {
        $session = session();

        $user = $session->get('user');
        if (!$user) return redirect()->to('/login');
        
        $userId = $user['id'];

        $codeValue = trim($this->request->getPost('code'));

        if (empty($codeValue)) {
            return redirect()->back()->with('error', 'Veuillez entrer un code');
        }

        $codeModel = new CodeModel();
        $userModel = new UserModel();
        $demandeModel = new DemandeCodeModel();

        // Recherche code
        $code = $codeModel->where('code', $codeValue)->first();

        if (!$code) {
            return redirect()->back()->with('error', 'Code invalide');
        }

        // Déjà utilisé
        if ($code['utilise']) {
            return redirect()->back()->with('error', 'Code déjà utilisé');
        }
        
        $pending = $demandeModel->where(['code_id' => $code['id'], 'status' => 0])->first();
        if ($pending) {
            return redirect()->back()->with('error', 'Ce code est déjà en attente de validation.');
        }

        // Utilisateur
        $dbUser = $userModel->find($userId);

        if (!$dbUser) {
            return redirect()->back()->with('error', 'Utilisateur introuvable');
        }

        $demandeModel->insert([
            'user_id' => $userId,
            'code_id' => $code['id'],
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Votre demande a été soumise. Un administrateur va valider votre code bientôt.');
    }

    public function validation()
    {
        $demandeModel = new DemandeCodeModel();
        $demandes = $demandeModel->getPendingDemandes();
        return view('code/validation', ['demandes' => $demandes]);
    }

    public function valider($demandeId)
    {
        $demandeModel = new DemandeCodeModel();
        $codeModel = new CodeModel();
        $userModel = new UserModel();
        $transactionModel = new TransactionModel();
        
        $demande = $demandeModel->find($demandeId);
        if (!$demande) return redirect()->back()->with('error', 'Demande introuvable');
        
        $code = $codeModel->find($demande['code_id']);
        $user = $userModel->find($demande['user_id']);
        
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            if ($code['utilise']) {
                $demandeModel->update($demandeId, ['status' => 2]); // refuse
                $db->transCommit();
                return redirect()->back()->with('error', 'Le code a déjà été utilisé.');
            }

            // Nouveau solde -> actually updating DB
            $nouveauSolde = $user['solde'] + $code['montant'];
            $userModel->update($user['id'], ['solde' => $nouveauSolde]);

            // Code utilisé
            $codeModel->update($code['id'], ['utilise' => 1]);

            // Transaction
            $transactionModel->insert([
                'user_id' => $user['id'],
                'code_id' => $code['id'],
                'montant' => $code['montant']
            ]);
            
            $demandeModel->update($demandeId, ['status' => 1]); // validé

            if ($db->transStatus() === false) {
                throw new \Exception('Erreur transaction');
            }
            $db->transCommit();
            return redirect()->back()->with('success', 'Code validé avec succès. Le solde a été mis à jour.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Erreur lors de la validation.');
        }
    }

    public function refuser($demandeId)
    {
        $demandeModel = new DemandeCodeModel();
        $demandeModel->update($demandeId, ['status' => 2]); // refusé
        return redirect()->back()->with('success', 'Le code a été refusé.');
    }
}
