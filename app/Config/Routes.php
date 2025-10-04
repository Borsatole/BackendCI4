<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Rotas de Login
$routes->group('login', function ($routes) {
    $routes->post('/', 'AuthController::login');
    $routes->post('validar', 'AuthController::validarToken');
});

// Rotas de Usuarios do sistema
$routes->group('usuarios', ['filter' => ['autenticacao', 'rotecontrol']], function ($routes) {
    $routes->get('', 'UsuarioController::index');
    $routes->post('', 'UsuarioController::create');
    
    $routes->get('(:num)', 'UsuarioController::show/$1');
    $routes->post('(:num)', 'UsuarioController::update/$1');
    $routes->delete('(:num)', 'UsuarioController::delete/$1');

});