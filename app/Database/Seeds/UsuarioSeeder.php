<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Limpa todos os usuários existentes
        $this->db->table('usuarios')->truncate();

        // Insere usuários de teste
        $data = [
            [
                'nome'  => 'Leandro Adminer',
                'email' => 'teste1@email.com',
                'senha' => password_hash('123456', PASSWORD_DEFAULT),
                'ativo' => 1,
                'nivel' => 1,
            ],
            [
                'nome'  => 'Roberio Padrão',
                'email' => 'teste2@email.com',
                'senha' => password_hash('123456', PASSWORD_DEFAULT),
                'ativo' => 1,
                'nivel' => 2,
            ],
        ];

        $this->db->table('usuarios')->insertBatch($data);
    }
}
