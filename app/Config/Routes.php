<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// Auth
$routes->get('/inscription1', 'UserController::inscription');
$routes->get('/inscription2', 'UserController::inscription2');
// savessession
$routes->post('/save_user1', 'UserController::save_user1');
$routes->post('/save_user2', 'UserController::save_user2');
// confirmation
$routes->get('/confirmation', 'UserController::confirmation');
$routes->post('/insertConfirmation', 'UserController::insertConfirmation');
// login
$routes->get('/login', 'UserController::login');
$routes->post('/authenticate', 'UserController::authenticate');
$routes->get('/logout', 'UserController::logout');

$routes->get(
    '/code/form',
    'CodeController::index'
);

$routes->post(
    '/code/ajouter',
    'CodeController::ajouterArgent'
);
