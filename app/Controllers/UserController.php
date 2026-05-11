<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function login(): string
    {
        return view('login');
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');

        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('user', $user);
            
            // Check if user is admin
            $db = \Config\Database::connect();
            $admin = $db->table('is_admin')->where('id_user', $user['id'])->get()->getRow();
            if ($admin) {
                session()->set('isAdmin', true);
            } else {
                session()->set('isAdmin', false);
            }
            
            return redirect()->to('/');
            // Authentification réussie

        } else {
            // Authentification échouée
            session()->setFlashdata('error', 'Email ou mot de passe incorrect.');

            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }

    public function inscription(): string
    {
        return view('inscription/inscription1');
    }

    public function save_user1()
    {
        $session = session();
        $data = [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'genre_id' => $this->request->getPost('genre_id'),
            'is_gold' => false,
            'solde' => 0
        ];
        $session->set("user_data", $data);
        return redirect()->to('/inscription2');
    }
    public function inscription2(): string
    {
        return view('inscription/inscription2');
    }
     public function save_user2()   
    {
        $session = session();

        $data=[
            'taille' => $this->request->getPost('taille'),
            'poids' => $this->request->getPost('poids'),
        ];

        $session->set("user_data_sante", $data);
        return redirect()->to('/confirmation');
    }
    public function confirmation(): string
    {
        return view('inscription/confirmation');
    }

    public function insertConfirmation(){
        $session = session();
        $userData = $session->get("user_data");
        $userHealthData = $session->get("user_data_sante");
        $userModel = new \App\Models\UserModel();
        $userId = $userModel->insert($userData);

        if ($userId) {
            $userHealthModel = new \App\Models\UserHealthModel();
            $userHealthModel->insert([
                'user_id' => $userId,
                'taille' => $userHealthData['taille'],
                'poids' => $userHealthData['poids'],
                'imc' => $userHealthData['poids'] / (($userHealthData['taille']) * ($userHealthData['taille']))
            ]);
            session()->set("user", $userModel->find($userId));

            session()->setFlashdata('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');

            return redirect()->to('/');
        } else {
            session()->setFlashdata('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.');

            return redirect()->to('/inscription1');
        }
    }

    public function precedente()
    {
        return redirect()->to('/inscription1?previous=1');
    }
}
