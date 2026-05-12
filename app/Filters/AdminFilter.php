<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Database;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->has('user')) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté.');
        }

        $user = $session->get('user');
        $db = Database::connect();
        $builder = $db->table('is_admin');
        
        $admin = $builder->where('id_user', $user['id'])->get()->getRow();

        if (!$admin) {
            return redirect()->to('/')->with('error', 'Accès refusé. Vous n\'êtes pas administrateur.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Ne rien faire ici
    }
}
