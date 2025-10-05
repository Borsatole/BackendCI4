<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NiveisPermissoesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Administrador (nivel_id = 1) => todas permissões liberadas
            ['nivel_id' => 1, 'permissao_id' => 1, 'allow' => 1],
            ['nivel_id' => 1, 'permissao_id' => 2, 'allow' => 1],
            ['nivel_id' => 1, 'permissao_id' => 3, 'allow' => 1],
            ['nivel_id' => 1, 'permissao_id' => 4, 'allow' => 1],
            ['nivel_id' => 1, 'permissao_id' => 5, 'allow' => 1],
            ['nivel_id' => 1, 'permissao_id' => 6, 'allow' => 1],
            ['nivel_id' => 1, 'permissao_id' => 7, 'allow' => 1],
            ['nivel_id' => 1, 'permissao_id' => 8, 'allow' => 1],

            // Usuário Padrão (nivel_id = 2) => permissões limitadas
            ['nivel_id' => 2, 'permissao_id' => 1, 'allow' => 0],
            ['nivel_id' => 2, 'permissao_id' => 2, 'allow' => 1],
            ['nivel_id' => 2, 'permissao_id' => 3, 'allow' => 0],
            ['nivel_id' => 2, 'permissao_id' => 4, 'allow' => 0],
            ['nivel_id' => 2, 'permissao_id' => 5, 'allow' => 1],
            ['nivel_id' => 2, 'permissao_id' => 6, 'allow' => 1],
            ['nivel_id' => 2, 'permissao_id' => 7, 'allow' => 0],
            ['nivel_id' => 2, 'permissao_id' => 8, 'allow' => 0],
        ];

        $this->db->table('niveis_permissoes')->insertBatch($data);
    }
}
