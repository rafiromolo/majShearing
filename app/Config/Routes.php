<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->options('(:any)', function() {
    return service('response')
        ->setStatusCode(200)
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->setHeader('Access-Control-Allow-Credentials', 'true');
});
$routes->get('/', 'Report::index');
$routes->get('/material', 'Report::material');
$routes->post('/shearing', 'Report::shearing');
$routes->get('/spec-shearing', 'Report::spec_shearing');
$routes->get('/print', 'Report::print');
$routes->post('/create-order', 'Report::create_order');
// $routes->group('api', function ($routes) {
//     $routes->get('users', 'LocalAPI::index');
// });
$routes->get('/users', 'LocalAPI::index');