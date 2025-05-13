<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
  // Health
  $routes->get('/', 'Api::status');

  // Auth
  $routes->post('auth/login', 'AuthController::login');
  $routes->post('auth/logout', 'AuthController::logout');
  $routes->get('auth/me', 'AuthController::me');

  // Lists
  $routes->get('lists', 'ListController::showAll');
  $routes->post('lists', 'ListController::create');
  $routes->get('lists/(:num)', 'ListController::show/$1');
  $routes->put('lists/(:num)', 'ListController::update/$1');
  $routes->delete('lists/(:num)', 'ListController::delete/$1');

  // Tasks
  $routes->post('lists/(:num)/tasks', 'TaskController::create/$1');
  $routes->put('tasks/(:num)', 'TaskController::update/$1');
  $routes->delete('tasks/(:num)', 'TaskController::delete/$1');

  // Fallback
  $routes->match(['get', 'post', 'put', 'delete', 'patch', 'options'], '(.*)', 'Api::fallback');
});
