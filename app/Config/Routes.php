<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
const CONTR_ROUTE = "App\Controllers";
const LOGIN = "\login";

$routes->get('/', 'Home::index');
$routes->post('/login', 'LoginController::login', ['namespace' => CONTR_ROUTE . LOGIN]);
$routes->post('/get-user-data', 'LoginController::getUserData', ['namespace' => CONTR_ROUTE . LOGIN]);
