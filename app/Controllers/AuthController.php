<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\Usuario;
use App\Models\NiveisModel;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();

    }

    public function login()
    {
        // Models
        $NiveisModel = new NiveisModel();


        $request = service('request');
        $email = $request->getVar('email');
        $senha = $request->getVar('password');

        // Verifica se os campos foram enviados
        if (!$email || !$senha) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email e senha são obrigatórios'
            ])->setStatusCode(400);
        }

        // Busca o usuário pelo email
        $usuario = $this->usuarioModel->where('email', $email)->first();


        if (!$usuario) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ])->setStatusCode(401);
        }


        $NomeNivel = $NiveisModel->getNomeNivel($usuario['nivel']);


        if (!$NomeNivel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuario não tem permissão'
            ])->setStatusCode(401);
        }



        // Verifica se o usuário está ativo
        if ($usuario['ativo'] != true) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Entre em contato com o administrador'
            ])->setStatusCode(401);
        }

        // Verifica senha
        if (!password_verify($senha, $usuario['senha'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Senha incorreta'
            ])->setStatusCode(401);
        }

        // Cria o payload do JWT
        $payload = [
            'iss' => base_url(),         // emissor
            'iat' => time(),             // hora da emissão
            'exp' => time() + 3600,      // expira em 1 hora
            'sub' => $usuario['id'],     // ID do usuário
            'nivel' => $usuario['nivel'], // Nível do usuário
        ];

        // Gera o token
        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');


        $menu = [];

        $menusConfig = include(APPPATH . 'Config/Menus.php');
        $menu = $menusConfig[$usuario['nivel']] ?? $menusConfig[2];

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'usuario' => [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email'],
                'nivel' => $usuario['nivel'],
                'nivel_nome' => $NomeNivel['nome'],
                'ativo' => $usuario['ativo']

            ],

            'menu' => $menu,

            

            'token' => $jwt
        ]);
    }

    public function validarToken()
    {
        $request = service('request');
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Token não fornecido'
            ])->setStatusCode(401);
        }

        // Remove o prefixo "Bearer "
        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (!$token) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Token inválido'
            ])->setStatusCode(401);
        }

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Token válido',
                'data' => (array) $decoded
            ])->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Token inválido ou expirado',
                'error' => $e->getMessage()
            ])->setStatusCode(401);
        }
    }

}
