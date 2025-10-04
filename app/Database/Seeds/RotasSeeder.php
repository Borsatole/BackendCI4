<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RotasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'nome' => 'Produtos',
                'rota' => '/produtos',
                'icone' => 'fas fa-box'
            ],
            [
                'id' => 2,
                'nome' => 'Usuarios',
                'rota' => '/usuarios',
                'icone' => 'fas fa-user'
            ],
            [
                'id' => 3,
                'nome' => 'Relatorios',
                'rota' => '/relatorios',
                'icone' => 'fas fa-chart-bar'
            ],
            [
                'id' => 4,
                'nome' => 'Configuracoes',
                'rota' => '/configuracoes',
                'icone' => 'fas fa-cog'
            ]
        ];

        // Usar DELETE em vez de TRUNCATE por causa das foreign keys
        $this->db->table('rotas')->emptyTable();

        // Usar insertBatch para inserir todos os registros
        $this->db->table('rotas')->insertBatch($data);
    }
}
