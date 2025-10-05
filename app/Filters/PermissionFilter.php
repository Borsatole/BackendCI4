<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\PermissoesModel;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $m)) {
            return service('response')
                ->setJSON(['success' => false, 'message' => 'Token ausente'])
                ->setStatusCode(401);
        }

        $token = $m[1];
        $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $nivelId = $decoded->nivel ?? null;

        $slug = $arguments[0] ?? null;
        if (!$slug || !$nivelId) {
            return service('response')->setJSON(['success' => false, 'message' => 'Permissão inválida'])->setStatusCode(403);
        }

        $PermissaoModel = new PermissoesModel();
        $temPermissao = $PermissaoModel->usuarioTemPermissao($nivelId, $slug);

        if (!$temPermissao) {
            return service('response')->setJSON(['success' => false, 'message' => 'Acesso negado.'])->setStatusCode(403);
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
