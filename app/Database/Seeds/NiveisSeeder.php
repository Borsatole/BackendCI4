<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NiveisSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nome' => 'Administrador',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nome' => 'Padrão',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('niveis')->insertBatch($data);
    }
}
