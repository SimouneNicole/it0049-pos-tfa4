<?php

use App\Controllers\Auth;
use App\Controllers\Customers;
use App\Controllers\Pages;
use App\Controllers\Users;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Pages::class, 'home']);
$routes->get('about', [Pages::class, 'about']);
$routes->get('login', [Auth::class, 'login']);
$routes->post('login', [Auth::class, 'attempt']);
$routes->get('logout', [Auth::class, 'logout']);

$routes->get('customers', [Customers::class, 'index'], ['filter' => 'auth']);
$routes->get('customers/new', [Customers::class, 'new'], ['filter' => 'auth']);
$routes->post('customers', [Customers::class, 'create'], ['filter' => 'auth']);
$routes->get('customers/(:num)/edit', [Customers::class, 'edit/$1'], ['filter' => 'auth']);
$routes->post('customers/(:num)', [Customers::class, 'update/$1'], ['filter' => 'auth']);
$routes->get('users', [Users::class, 'index'], ['filter' => 'auth']);
$routes->get('users/new', [Users::class, 'new'], ['filter' => 'auth']);
$routes->post('users', [Users::class, 'create'], ['filter' => 'auth']);
$routes->get('users/(:num)/edit', [Users::class, 'edit/$1'], ['filter' => 'auth']);
$routes->post('users/(:num)', [Users::class, 'update/$1'], ['filter' => 'auth']);
