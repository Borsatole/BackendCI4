<?php

namespace App\Controllers;
use App\Models\Usuario;


use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class UsuarioController extends BaseController
{

    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    public function index()
    {
        /** @var object $usuarioLogado */
        $usuarioLogado = $this->request->user ?? null;

        $perPage = 10;
        $page = $this->request->getVar('page') ?? 1;

        $usuarios = $this->usuarioModel->orderBy('id', 'DESC')->paginate($perPage);
        $pager = $this->usuarioModel->pager;

        return $this->response->setJSON([
            'success' => true,
            'Registros' => $usuarios,
            'paginacao' => [
                'total' => $pager->getTotal(),
                'porPagina' => $perPage,
                'paginaAtual' => $pager->getCurrentPage(),
                'ultimaPagina' => $pager->getPageCount(),
            ],

        ]);
    }

    public function show($id = null)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usuário não encontrado',
            ])->setStatusCode(404);
        }

        return $this->response->setJSON($usuario);
    }

    public function create()
    {
        $data = [
            'nome' => 'Leandro',
            'email' => 'teste3@email.com',
            'senha' => password_hash('123456', PASSWORD_DEFAULT)
        ];

        if (!$this->usuarioModel->insert($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao criar usuário',
                'errors' => $this->usuarioModel->errors()
            ])->setStatusCode(400);
        }

        $id = $this->usuarioModel->getInsertID();
        $usuario = $this->usuarioModel->find($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Usuário criado com sucesso',
        ]);
    }

    public function update($id = null)
    {
        $data = [
            'nome' => 'Leandreta',

        ];

        if (!$this->usuarioModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao atualizar usuário',
                'errors' => $this->usuarioModel->errors()
            ])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Usuário atualizado com sucesso',
        ]);
    }

    public function delete($id = null)
    {
        if (!$this->usuarioModel->delete($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao deletar usuário',
                'errors' => $this->usuarioModel->errors()
            ])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Usuário deletado com sucesso',
        ]);
    }


}
