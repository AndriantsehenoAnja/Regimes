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
    'activite/form',
    'ActiviteController::form'
);

$routes->post(
    'activite/save',
    'ActiviteController::save'
);

$routes->post(
    '/acheter',
    'AchatRegimeController::acheter'
);