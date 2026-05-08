<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get(
    '/code/form',
    'CodeController::index'
);

$routes->post(
    '/code/ajouter',
    'CodeController::ajouterArgent'
);