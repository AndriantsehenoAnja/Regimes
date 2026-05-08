<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

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