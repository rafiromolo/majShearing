<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
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