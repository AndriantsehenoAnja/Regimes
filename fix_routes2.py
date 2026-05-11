import re

with open('app/Config/Routes.php', 'r') as f:
    content = f.read()

# remove old activite routes
to_remove = """$routes->get(
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
);"""

content = content.replace(to_remove, '')

with open('app/Config/Routes.php', 'w') as f:
    f.write(content)
