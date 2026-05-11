<?php

namespace App\Controllers;


class AdminController extends BaseController
{
    public function index()
    {
        $allUsers = (new \App\Models\UserModel())->findAll();
        $allregimes = (new \App\Models\RegimeModel())->findAll();
        return view('admin/dashboard', ['users' => $allUsers, 'regimes' => $allregimes]);
    }
    public function login()
    {
        return view('admin/login');
    }
    public function authenticate()
    {
        $email = $this->request->getPost('email');

        $password = $this->request->getPost('password');

        $adminModel = new \App\Models\AdminModel();

        $admin = $adminModel->where('email', $email)->first();

        if ($admin && password_verify($password, $admin['mot_de_passe'])) {
            session()->set('admin', $admin);
            return redirect()->to('/admin');
            // Authentification réussie

        } else {
            // Authentification échouée
            session()->setFlashdata('error', 'Email ou mot de passe incorrect.');
            return redirect()->to('/admin/login');
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}