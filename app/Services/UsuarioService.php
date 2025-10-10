<?php

namespace App\Services;

use App\Models\Usuario;
use App\Exceptions\UsuarioException;



class UsuarioService
{
    private $usuariosModel;
    private $db;

    public function __construct()
    {
        $this->usuariosModel = new Usuario();
        $this->db = \Config\Database::connect();
    }

    public function listar(int $limite = 10, int $pagina = 1, array $filtros = []): array
    {
        $resultado = $this->usuariosModel->listarComPaginacao($limite, $pagina, $filtros);
        $pager = $this->usuariosModel->pager;

        foreach ($resultado as &$usuario) {
            unset($usuario['senha']);
        }
        
        return [
            'registros' => $resultado,
            'paginacao' => [
                'total' => $pager->getTotal(),
                'porPagina' => $limite,
                'paginaAtual' => $pager->getCurrentPage(),
                'ultimaPagina' => $pager->getPageCount(),
            ]
        ];
    }

    
}