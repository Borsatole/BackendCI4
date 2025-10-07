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

$routes->group('papeis', ['filter' => 'autenticacao'], function ($routes) {
    $routes->get(
        '',
        'NiveisController::index',
        ['filter' => 'permission:papeis.visualizar']
    );

    $routes->post(
        '',
        'NiveisController::create',
        ['filter' => 'permission:papeis.criar']
    );

    $routes->get(
        '(:num)',
        'NiveisController::show/$1',
        ['filter' => 'permission:papeis.visualizar']
    );

    $routes->put(
        '(:num)',
        'NiveisController::update/$1',
        ['filter' => 'permission:papeis.editar']
    );

    $routes->delete(
        '(:num)',
        'NiveisController::delete/$1',
        ['filter' => 'permission:papeis.excluir']
    );

});

$routes->group('permissoes', ['filter' => 'autenticacao'], function ($routes) {
    $routes->get(
        '',
        'PermissoesController::index',
        ['filter' => 'permission:papeis.visualizar']
    );

    $routes->get(
        '(:num)',
        'PermissoesController::byNivel/$1',
        ['filter' => 'permission:papeis.visualizar']
    );

    $routes->post(
        '',
        'PermissoesController::create',
        ['filter' => 'permission:papeis.criar']
    );

    $routes->put(
        '(:num)',
        'PermissoesController::updateByNivel/$1',
        ['filter' => 'permission:papeis.editar']
    );

    $routes->delete(
        '(:num)',
        'PermissoesController::delete/$1',
        ['filter' => 'permission:papeis.excluir']
    );

});

