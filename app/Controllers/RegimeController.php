<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use App\Models\RegimeActiviteModel;
use App\Models\ActiviteModel;

class RegimeController extends BaseController
{
    public function edit($id)
    {
        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteModel();
        $regimeActiviteModel = new RegimeActiviteModel();

        $regime = $regimeModel->find($id);
        if (!$regime) {
            return redirect()->to('/regimes')->with('error', 'Régime non trouvé.');
        }

        $activites = $activiteModel->findAll();
        $activitesAssociees = $regimeActiviteModel->where('regime_id', $id)->findAll();

        // Créer un tableau d'activités associées pour faciliter la vérification dans la vue
        $activitesAssocieesIds = array_column($activitesAssociees, 'activite_id');

        return view('regime/edit', [
            'regime' => $regime,
            'activites' => $activites,
            'activitesAssocieesIds' => $activitesAssocieesIds
        ]);
    }

    public function update($id)
    {
        $regimeModel = new RegimeModel();
        $regimeActiviteModel = new RegimeActiviteModel();

        // Démarrer une transaction
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // 1. Mise à jour du régime
            $regimeData = [
                'nom'                  => $this->request->getPost('nom'),
                'description'          => $this->request->getPost('description'),
                'prix'                 => $this->request->getPost('prix'),
                'duree'                => $this->request->getPost('duree'),
                'variation'            => $this->request->getPost('variation'),
                'type_regime'          => $this->request->getPost('type_regime'),
                'pourcentage_viande'   => $this->request->getPost('pourcentage_viande'),
                'pourcentage_poisson'  => $this->request->getPost('pourcentage_poisson'),
                'pourcentage_volaille' => $this->request->getPost('pourcentage_volaille')
            ];
            $regimeModel->update($id, $regimeData);

            // 2. Mise à jour des activités liées
            // Supprimer les associations existantes
            $regimeActiviteModel->where('regime_id', $id)->delete();

            // Réinsérer les associations mises à jour
            $activites = $this->request->getPost('activites');
            $variations = $this->request->getPost('variation_activite');

            if (!empty($activites)) {
                foreach ($activites as $activiteId) {
                    $regimeActiviteModel->insert([
                        'regime_id'     => $id,
                        'activite_id'   => $activiteId,
                        'variation'     => isset($variations[$activiteId]) ? $variations[$activiteId] : 0,
                        'type_activite' => $regimeData['type_regime']
                    ]);
                }
            }

            // Valider la transaction
            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
            }

            $db->transCommit();
            return redirect()->to('/regimes')->with('success', 'Régime mis à jour avec succès !');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $regimeModel = new RegimeModel();
        $regimeActiviteModel = new RegimeActiviteModel();

        // Démarrer une transaction
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Supprimer les associations d'activités liées
            $regimeActiviteModel->where('regime_id', $id)->delete();

            // Supprimer le régime
            $regimeModel->delete($id);

            // Valider la transaction
            if ($db->transStatus() === false) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }

        $db->transCommit();
        return redirect()->to('/regimes')->with('success', 'Régime supprimé avec succès !');
    }

    public function index()
    {
        $regimeModel = new RegimeModel();
        
        $data = [
            'regimes' => $regimeModel->findAll()
        ];
        
        return view('regime/index', $data);
    }
    // Affiche le formulaire d'ajout
    public function create()
    {
        $activiteModel = new ActiviteModel();
        
        $data = [
            'activites' => $activiteModel->findAll()
        ];
        
        return view('regime/create', $data);
    }

    // Gère l'insertion simultanée
    public function store()
    {
        $regimeModel = new RegimeModel();
        $regimeActiviteModel = new RegimeActiviteModel();
        
        // Démarrer une transaction pour s'assurer que tout réussit ou rien
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // 1. Insertion du régime
            $regimeData = [
                'nom'                  => $this->request->getPost('nom'),
                'description'          => $this->request->getPost('description'),
                'prix'                 => $this->request->getPost('prix'),
                'duree'                => $this->request->getPost('duree'),
                'variation'            => $this->request->getPost('variation'),
                'type_regime'          => $this->request->getPost('type_regime'),
                'pourcentage_viande'   => $this->request->getPost('pourcentage_viande'),
                'pourcentage_poisson'  => $this->request->getPost('pourcentage_poisson'),
                'pourcentage_volaille' => $this->request->getPost('pourcentage_volaille')
            ];
            $regimeModel->insert($regimeData);
            
            // Récupérer l'ID généré
            $regimeId = $regimeModel->getInsertID();

            // 2. Insertion des activités liées
            $activites = $this->request->getPost('activites');
            $variations = $this->request->getPost('variation_activite');

            if (!empty($activites)) {
                foreach ($activites as $activiteId) {
                    $regimeActiviteModel->insert([
                        'regime_id'     => $regimeId,
                        'activite_id'   => $activiteId,
                        'variation'     => isset($variations[$activiteId]) ? $variations[$activiteId] : 0,
                        'type_activite' => $regimeData['type_regime']
                    ]);
                }
            }

            $db->transCommit();
            return redirect()->to('/regimes')->with('success', 'Régime créé avec succès !');
            
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }
    
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

        $session->set("valeur", $valeur);
        $session->set("objectif", $objectif);
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

    public function ajouterActivite($id)
{
    $regimeModel = new RegimeModel();
    $db = \Config\Database::connect();

    $regime = $regimeModel->find($id);

    if (!$regime) {
        return redirect()->to('/regimes')->with('error', 'Régime non trouvé.');
    }

    // Récupérer les activités déjà liées à ce régime
    $activitesLiees = $db->table('regime_activite')
        ->select('activite_id')
        ->where('regime_id', $id)
        ->get()
        ->getResultArray();

    $idsExclus = array_column($activitesLiees, 'activite_id');

    // Récupérer toutes les activités NON encore liées à ce régime
    $builder = $db->table('activites');

    if (!empty($idsExclus)) {
        $builder->whereNotIn('id', $idsExclus);
    }

    $activites = $builder->get()->getResultArray();

    return view('regime/ajoutActivite', [
        'regime' => $regime,
        'activites' => $activites
    ]);
}
public function storeActivite($id)
{
    $regimeModel = new RegimeModel();
    $db = \Config\Database::connect();

    $regime = $regimeModel->find($id);

    if (!$regime) {
        return redirect()->to('/regimes')->with('error', 'Régime non trouvé.');
    }

    $activites = $this->request->getPost('activites');
    $variations = $this->request->getPost('variation_activite');

    if (!$activites) {
        return redirect()->back()->with('error', 'Aucune activité sélectionnée.');
    }

    foreach ($activites as $activiteId) {

        $variation = isset($variations[$activiteId]) ? $variations[$activiteId] : 0;

        // Exemple de logique simple :
        $type = ($variation > 0) ? 'prise' : 'perte';

        $db->table('regime_activite')->insert([
            'regime_id'    => $id,
            'activite_id'  => $activiteId,
            'type_activite'=> $type,
            'variation'    => $variation
        ]);
    }

    return redirect()->to('/regimes')->with('success', 'Activités ajoutées avec succès.');
}
}
