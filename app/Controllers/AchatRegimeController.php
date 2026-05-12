<?php

namespace App\Controllers;

use App\Models\AchatRegimeModel;
use App\Models\RegimeModel;
use App\Models\UserModel;

class AchatRegimeController extends BaseController
{
    public function confirmerAchat()
    {
        $session = session();
        if (!$session->has('user')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter');
        }

        $regimeId = $this->request->getPost('regime_id');
        $multiplicateur = $this->request->getPost('multiplicateur');
        $prixTotal = $this->request->getPost('prix');

        if (!$regimeId || !$prixTotal) {
            return redirect()->to('/suggerer')->with('error', 'Informations invalides');
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);
        if (!$regime) {
            return redirect()->to('/suggerer')->with('error', 'Régime introuvable');
        }

        // Activites associées
        $db = \Config\Database::connect();
        $builderAct = $db->table('regime_activite');
        $builderAct->select('activites.nom');
        $builderAct->join('activites', 'activites.id = regime_activite.activite_id');
        $builderAct->where('regime_activite.regime_id', $regimeId);
        $activites = $builderAct->get()->getResultArray();

        return view('regime/confirmation_achat', [
            'regime' => $regime,
            'activites' => $activites,
            'multiplicateur' => $multiplicateur,
            'prixTotal' => $prixTotal
        ]);
    }

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

            return redirect()->to('/profile')
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

    public function mesRegimes()
    {
        $session = session();
        if (!$session->has('user')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter');
        }

        $userId = $session->get('user')['id'];
        
        $db = \Config\Database::connect();
        $builder = $db->table('achat_regime');
        $builder->select('achat_regime.id, achat_regime.prix_paye as prix, achat_regime.date_achat as date_achat, regimes.nom as regime_nom, regimes.id as regime_id');
        $builder->join('regimes', 'achat_regime.regime_id = regimes.id');
        $builder->where('achat_regime.user_id', $userId);
        $builder->orderBy('achat_regime.date_achat', 'DESC');
        
        $achats = $builder->get()->getResultArray();

        return view('regime/mes_regimes', ['achats' => $achats]);
    }

    public function exportPdf($regimeId)
    {
        $session = session();
        if (!$session->has('user')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter');
        }

        $userId = $session->get('user')['id'];

        $db = \Config\Database::connect();
        
        // Verifier que l'utilisateur a vraiment acheté ce régime
        $builder = $db->table('achat_regime');
        $builder->where('user_id', $userId);
        $builder->where('regime_id', $regimeId);
        $achat = $builder->get()->getRowArray();
        
        if (!$achat) {
            return redirect()->to('/mes-regimes')->with('error', 'Vous n\'avez pas acheté ce régime.');
        }

        $regimeModel = new \App\Models\RegimeModel();
        $regime = $regimeModel->find($regimeId);

        // Activites associées
        $db = \Config\Database::connect();
        $builderAct = $db->table('regime_activite');
        $builderAct->select('activites.nom');
        $builderAct->join('activites', 'activites.id = regime_activite.activite_id');
        $builderAct->where('regime_activite.regime_id', $regimeId);
        $activites = $builderAct->get()->getResultArray();

        $html = view('regime/pdf_template', [
            'user' => $session->get('user'),
            'date_achat' => $achat['date_achat'] ?? date('Y-m-d H:i:s'),
            'regime' => $regime,
            'activites' => $activites
        ]);

        $dompdf = new \Dompdf\Dompdf();
        
        // Dompdf Options
        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("regime-export-" . $regimeId . ".pdf", ["Attachment" => true]);
        exit();
    }
}