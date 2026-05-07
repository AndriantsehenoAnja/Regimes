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
            // Authentification réussie
            session()->set('user_id', $user['id']);
            session()->set('user_name', $user['nom']);

            return redirect()->to('/dashboard');
        } else {
            // Authentification échouée
            session()->setFlashdata('error', 'Email ou mot de passe incorrect.');

            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }

    public function inscription(): string
    {
        return view('inscription1');
    }

    public function save_user1()
    {
        $session = session();
        $data = [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'genre_id' => $this->request->getPost('genre_id'),
            'is_gold' => false,
            'solde' => 0
        ];
        $session->set("user_data", $data);
        return redirect()->to('/inscription2');
    }
    
     public function save_user2()
    {
        $session = session();
        $userData = $session->get("user_data");

        if (!$userData) {
            return redirect()->to('/inscription1');
        }

        $taille = $this->request->getPost('taille');
        $poids = $this->request->getPost('poids');

        $userModel = new \App\Models\UserModel();
        $userId = $userModel->insert($userData);

        if ($userId) {
            $userHealthModel = new \App\Models\UserHealthModel();
            $userHealthModel->insert([
                'user_id' => $userId,
                'taille' => $taille,
                'poids' => $poids
            ]);

            session()->setFlashdata('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');

            return redirect()->to('/login');
        } else {
            session()->setFlashdata('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.');

            return redirect()->to('/confirmation');
        }

    }
    
    public function precedente()
    {
        return redirect()->to('/inscription1?previous=1');
    }
}
