<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoteControl implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pega o usuário da request (definido pelo filtro de autenticação)
        $user = $request->user ?? null;

        if (!$user) {
            return service('response')->setJSON([
                'success' => false,
                'message' => 'Usuário não autenticado'
            ])->setStatusCode(401);
        }

        // Normalizar a rota atual - funciona em qualquer ambiente
            $rotaAtual = '/' . trim(service('uri')->getPath(), '/');

            // Remove qualquer arquivo PHP da URL (index.php, app.php, etc.)
            $rotaAtual = preg_replace('/\/[a-zA-Z0-9_-]+\.php\//', '/', $rotaAtual);

            // Remove barras duplas e garante que sempre inicie com /
            $rotaAtual = '/' . trim(str_replace('//', '/', $rotaAtual), '/');



        // Conecta ao banco para verificar permissão
        $db = \Config\Database::connect();

        $sql = "SELECT na.*
                FROM niveldeacessos na
                JOIN rotas r ON na.IdRota = r.id
                WHERE na.IdNivel = ? AND r.rota = ?";
        
        $query = $db->query($sql, [$user->nivel, $rotaAtual]);
        $permissao = $query->getRow();


        if (!$permissao) {
            return service('response')->setJSON([
                'success' => false,
                'message' => 'Você não tem acesso a esta rota.',
            ])->setStatusCode(403);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
