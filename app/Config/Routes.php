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
$routes->get('/insertConfirmation', 'UserController::insertConfirmation');
// login
$routes->get('/login', 'UserController::login');
$routes->post('/authenticate', 'UserController::authenticate');
$routes->get('/logout', 'UserController::logout');
// programme régime1
$routes->get('/programme1', 'ObjectifController::index');
$routes->post('/suggerer', 'RegimeController::suggerer_regime');


/* Code */
$routes->get(
    '/code/form',
    'CodeController::index'
);

$routes->post(
    '/code/ajouter',
    'CodeController::ajouterArgent'
);

/* Option Gold */
$routes->get(
    '/gold/form',
    'GoldController::index'
);

$routes->post(
    '/gold/activer',
    'GoldController::activer'
);

/* CRUD activite */

$routes->get(
    '/activite',
    'ActiviteController::index'
);

$routes->get(
    '/activite/form',
    'ActiviteController::form'
);

$routes->post(
    '/activite/save',
    'ActiviteController::save'
);

$routes->get(
    '/activite/edit/(:num)',
    'ActiviteController::edit/$1'
);

$routes->post(
    '/activite/update/(:num)',
    'ActiviteController::update/$1'
);

$routes->get(
    '/activite/delete/(:num)',
    'ActiviteController::delete/$1'
);

/* Achat régime */
$routes->post(
    '/acheter',
    'AchatRegimeController::acheter'
);

$routes->get(
    '/profile',
    'ProfileController::index'
);

// CRUD régimes
$routes->get('regimes/create', 'RegimeController::create');
$routes->post('regimes/store', 'RegimeController::store');
// Optionnel: routes index etc.
$routes->get('regimes', 'RegimeController::index');
$routes->get('regimes/edit/(:num)', 'RegimeController::edit/$1');
$routes->post('regimes/update/(:num)', 'RegimeController::update/$1');
$routes->get('regimes/delete/(:num)', 'RegimeController::delete/$1');
$routes->get('regimes/ajouterActivite/(:num)', 'RegimeController::ajouterActivite/$1');
$routes->post('regimes/ajouterActivite/(:num)', 'RegimeController::storeActivite/$1');

// admin
$routes->get('login','AdminController::login');
$routes->post('/admin/authenticate','AdminController::authenticate');
$routes->get('/admin/dashbord','AdminController::index');