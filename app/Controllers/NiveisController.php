<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NiveisModel;
use App\Models\PermissoesModel;
use App\Models\NiveisXPermissoes;

class NiveisController extends BaseController
{
    protected $niveisModel;
    protected $permissoesModel;
    protected $niveisXPermissoesModel;

    public function __construct()
    {
        $this->niveisModel = new NiveisModel();
        $this->permissoesModel = new PermissoesModel();
        $this->niveisXPermissoesModel = new NiveisXPermissoes();
    }

    public function index()
    {
        $perPage = 10;
        $page = $this->request->getVar('page') ?? 1;

        $niveis = $this->niveisModel->orderBy('id', 'DESC')->paginate($perPage);
        $pager = $this->niveisModel->pager;

        foreach ($niveis as &$nivel) {
            $nivel['permissoes'] = $this->permissoesModel->BuscarPermissoesPeloNivel($nivel['id']);
        }

        return $this->response->setJSON([
            'success' => true,
            'Registros' => $niveis,
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
        $nivel = $this->niveisModel->find($id);

        if (!$nivel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nível não encontrado',
            ])->setStatusCode(404);
        }

        $nivel['permissoes'] = $this->permissoesModel->BuscarPermissoesPeloNivel($nivel['id']);

        return $this->response->setJSON([
            'success' => true,
            'Registros' => $nivel,
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if (empty($data) || empty($data['nome'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'O campo nome é obrigatório',
            ])->setStatusCode(400);
        }

        unset($data['permissoes']);

        if (!$this->niveisModel->insert($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao criar nível',
                'errors' => $this->niveisModel->errors()
            ])->setStatusCode(400);
        }

        $nivelId = $this->niveisModel->getInsertID();

        // Vincula todas permissões existentes com allow = 0
        $todasPermissoes = $this->permissoesModel->findAll();
        foreach ($todasPermissoes as $permissao) {
            $this->niveisXPermissoesModel->insert([
                'nivel_id' => $nivelId,
                'permissao_id' => $permissao['id'],
                'allow' => 0
            ]);
        }

        $nivel = $this->niveisModel->find($nivelId);
        $nivel['permissoes'] = $this->permissoesModel->BuscarPermissoesPeloNivel($nivelId);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Nível criado com sucesso.',
            'registro' => $nivel
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getPost();

        if (empty($data) || empty($data['nome'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'O campo nome é obrigatório',
            ])->setStatusCode(400);
        }

        $permissoes = !empty($data['permissoes']) ? json_decode($data['permissoes'], true) : [];
        unset($data['permissoes']);

        // Atualiza o nível
        if (!$this->niveisModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao atualizar nível',
                'errors' => $this->niveisModel->errors()
            ])->setStatusCode(400);
        }

        // Atualiza as permissões se vieram no corpo da requisição
        if (!empty($permissoes)) {
            $this->niveisXPermissoesModel->where('nivel_id', $id)->delete();

            foreach ($permissoes as $permissao) {
                $this->niveisXPermissoesModel->insert([
                    'nivel_id' => $id,
                    'permissao_id' => $permissao['id'],
                    'allow' => $permissao['allow'] ?? 0
                ]);
            }
        }

        $nivel = $this->niveisModel->find($id);
        $nivel['permissoes'] = $this->permissoesModel->BuscarPermissoesPeloNivel($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Nível atualizado com sucesso',
            'registro' => $nivel
        ]);
    }

    public function delete($id = null)
    {
        if (!$this->niveisModel->find($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nível não encontrado',
            ])->setStatusCode(404);
        }

        $this->niveisXPermissoesModel->where('nivel_id', $id)->delete();

        if (!$this->niveisModel->delete($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao deletar nível',
                'errors' => $this->niveisModel->errors()
            ])->setStatusCode(400);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Nível deletado com sucesso',
        ]);
    }
}
