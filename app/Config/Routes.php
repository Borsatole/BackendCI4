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
$routes->group('usuarios', ['filter' => 'autenticacao'], function ($routes) {
    $routes->get(
        '',
        'UsuarioController::index',
        ['filter' => 'permission:usuario.visualizar']
    );

    $routes->post(
        '',
        'UsuarioController::create',
        ['filter' => 'permission:usuario.criar']
    );

    $routes->get(
        '(:num)',
        'UsuarioController::show/$1',
        ['filter' => 'permission:usuario.visualizar']
    );

    $routes->post(
        '(:num)',
        'UsuarioController::update/$1',
        ['filter' => 'permission:usuario.editar']
    );

    $routes->delete(
        '(:num)',
        'UsuarioController::delete/$1',
        ['filter' => 'permission:usuario.excluir']
    );

});