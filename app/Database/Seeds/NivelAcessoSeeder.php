<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NivelAcessoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Role 1 (Admin) - Acesso total
            ['IdRota' => 1, 'IdNivel' => 1], // /produtos
            ['IdRota' => 2, 'IdNivel' => 1], // /usuarios
            ['IdRota' => 3, 'IdNivel' => 1], // /relatorios
            ['IdRota' => 4, 'IdNivel' => 1], // /configuracoes

            // Role 2 (Gerente) - Acesso limitado
            ['IdRota' => 1, 'IdNivel' => 2], // /produtos
            ['IdRota' => 2, 'IdNivel' => 2], // /usuarios
            ['IdRota' => 3, 'IdNivel' => 2], // /relatorios

            // Role 3 (Funcionário) - Apenas produtos
            ['IdRota' => 1, 'IdNivel' => 3], // /produtos

            // Role 4 (Visualizador) - Apenas relatórios
            ['IdRota' => 3, 'IdNivel' => 4], // /relatorios
        ];

        // Usar DELETE em vez de TRUNCATE
        $this->db->table('niveldeacessos')->emptyTable();

        // Usar insertBatch para inserir todos os registros
        $this->db->table('niveldeacessos')->insertBatch($data);

        echo "Permissões de rotas inseridas com sucesso!\n";
    }
}
