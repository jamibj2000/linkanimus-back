<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
const CONTR_ROUTE = "App\Controllers";

$routes->get('/', 'Home::index');

const LOGIN = "\login";
$routes->post('/api/login', 'LoginController::login', ['namespace' => CONTR_ROUTE . LOGIN]);
// USER
$routes->post('/api/save-user', 'LoginController::saveUser', ['namespace' => CONTR_ROUTE . LOGIN]);
