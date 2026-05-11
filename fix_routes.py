import re

with open('app/Config/Routes.php', 'r') as f:
    content = f.read()

# remove old activite routes
content = re.sub(r'/\* CRUD activite \*/.*?activite/delete.*?ActiviteController::delete/\$1.*?\);\s*', '', content, flags=re.DOTALL)

# remove old regime routes
content = re.sub(r'// CRUD régimes.*?RegimeController::storeActivite/\$1.*?\);\s*', '', content, flags=re.DOTALL)

admin_routes = """
// Admin Routes (CRUD Activites & Regimes)
$routes->group('', ['filter' => 'admin'], static function ($routes) {
    /* CRUD activite */
    $routes->get('/activite', 'ActiviteController::index');
    $routes->get('/activite/form', 'ActiviteController::form');
    $routes->post('/activite/save', 'ActiviteController::save');
    $routes->get('/activite/edit/(:num)', 'ActiviteController::edit/$1');
    $routes->post('/activite/update/(:num)', 'ActiviteController::update/$1');
    $routes->get('/activite/delete/(:num)', 'ActiviteController::delete/$1');

    // CRUD régimes
    $routes->get('regimes', 'RegimeController::index');
    $routes->get('regimes/create', 'RegimeController::create');
    $routes->post('regimes/store', 'RegimeController::store');
    $routes->get('regimes/edit/(:num)', 'RegimeController::edit/$1');
    $routes->post('regimes/update/(:num)', 'RegimeController::update/$1');
    $routes->get('regimes/delete/(:num)', 'RegimeController::delete/$1');
    $routes->get('regimes/ajouterActivite/(:num)', 'RegimeController::ajouterActivite/$1');
    $routes->post('regimes/ajouterActivite/(:num)', 'RegimeController::storeActivite/$1');
});
"""

content = content.replace('// admin', admin_routes + '\n// admin')

with open('app/Config/Routes.php', 'w') as f:
    f.write(content)
