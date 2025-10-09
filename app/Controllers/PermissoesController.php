<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NiveisModel;
use App\Models\PermissoesModel;
use App\Models\NiveisXPermissoes;

class PermissoesController extends BaseController
{
    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Retorna todas as permissões cadastradas no sistema.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    /*******  dadf6ce4-78c0-436a-b2b4-f986c8e598a2  *******/
    public function index()
    {
        $model = new PermissoesModel();
        return $this->response->setJSON([
            'success' => true,
            'registros' => $model->orderBy('id', 'ASC')->findAll()
        ]);
    }

    public function create()
    {
        $permissoesModel = new PermissoesModel();
        $niveisModel = new NiveisModel();
        $niveisXPermissoesModel = new NiveisXPermissoes();

        // Dados recebidos do body JSON
        $data = $this->request->getJSON(true);

        // Validação simples
        if (empty($data) || empty($data['slug']) || empty($data['descricao'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Os campos slug e descricao são obrigatórios.'
            ])->setStatusCode(400);
        }

        // Insere a nova permissão
        if (!$permissoesModel->insert($data)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao criar permissão.',
                'errors' => $permissoesModel->errors()
            ])->setStatusCode(400);
        }

        $permissaoId = $permissoesModel->getInsertID();

        // Busca todos os níveis existentes
        $todosNiveis = $niveisModel->findAll();

        // Cria a relação em niveisxpermissoes com allow = 0
        foreach ($todosNiveis as $nivel) {
            $niveisXPermissoesModel->insert([
                'nivel_id' => $nivel['id'],
                'permissao_id' => $permissaoId,
                'allow' => 0
            ]);
        }

        // Retorna a nova permissão criada
        $novaPermissao = $permissoesModel->find($permissaoId);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Permissão criada com sucesso.',
            'registro' => $novaPermissao
        ]);
    }

    public function delete($id = null)
    {
        $niveisXPermissoesModel = new NiveisXPermissoes();

        // Remove as relações do nível com essa permissão
        $niveisXPermissoesModel->where('permissao_id', $id)->delete();

        // Remove a permissão
        $permissoesModel = new PermissoesModel();
        $permissoesModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Permissão excluída com sucesso e removida de todos os níveis.'
        ]);
    }

    public function byNivel($nivelId)
    {
        $niveisModel = new NiveisModel();
        $permissoesModel = new PermissoesModel();

        $nivel = $niveisModel->find($nivelId);
        if (!$nivel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nível não encontrado'
            ])->setStatusCode(404);
        }

        $nivel['permissoes'] = $permissoesModel->BuscarPermissoesPeloNivel($nivelId);

        return $this->response->setJSON([
            'success' => true,
            'registro' => $nivel
        ]);
    }


    public function updateByNivel($nivelId)
    {
        $niveisModel = new NiveisModel();
        $niveisXPermissoesModel = new NiveisXPermissoes();
        $permissoesModel = new PermissoesModel();

        $nivel = $niveisModel->find($nivelId);
        if (!$nivel) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nível não encontrado'
            ])->setStatusCode(404);
        }

        $data = $this->request->getJSON(true);


        if (empty($data['nome'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'O campo nome é obrigatório',
                'dados' => $data
            ])->setStatusCode(400);
        }

        // Decodifica as permissões enviadas como JSON no FormData
        $permissoes = [];
        if (!empty($data['permissoes']) && is_array($data['permissoes'])) {
            foreach ($data['permissoes'] as $p) {
                $permissoes[] = [
                    'permissao_id' => $p['permissao_id'] ?? null,
                    'allow' => isset($p['allow']) ? (int) $p['allow'] : 0
                ];
            }
        }

        // Atualiza o nome do nível
        if (!$niveisModel->update($nivelId, ['nome' => $data['nome']])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao atualizar nível',
                'errors' => $niveisModel->errors()
            ])->setStatusCode(400);
        }

        // Atualiza permissões se foram enviadas
        if (!empty($permissoes)) {
            // Remove permissões antigas
            $niveisXPermissoesModel->where('nivel_id', $nivelId)->delete();

            // Insere novas permissões
            foreach ($permissoes as $p) {
                if ($p['permissao_id'] !== null) {
                    $niveisXPermissoesModel->insert([
                        'nivel_id' => $nivelId,
                        'permissao_id' => $p['permissao_id'],
                        'allow' => $p['allow']
                    ]);
                }
            }
        }

        // Retorna nível atualizado
        $nivel = $niveisModel->find($nivelId);
        $nivel['permissoes'] = $permissoesModel->BuscarPermissoesPeloNivel($nivelId);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Permissões atualizadas com sucesso',
            'registro' => $nivel
        ]);
    }
}
