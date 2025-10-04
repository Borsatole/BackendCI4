<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TiposDeUsuariosSeeder extends Seeder
{
    public function run()
    {

        $data = [
            [
                'id' => 1,
                'nivel' => 'Administrador',
                'id_nivel' => 1
            ],
            [
                'id' => 2,
                'nivel' => 'Padrao',
                'id_nivel' => 2
            ],
            [
                'id' => 3,
                'nivel' => 'Funcionario',
                'id_nivel' => 3
            ],
            [
                'id' => 4,
                'nivel' => 'Visualizador',
                'id_nivel' => 4
            ]
        ];
        
        // Usar DELETE em vez de TRUNCATE por causa das foreign keys
        $this->db->table('tiposdeusuarios')->emptyTable();

        // Usar insertBatch para inserir todos os registros
        $this->db->table('tiposdeusuarios')->insertBatch($data);
        
        echo "Tipos de usuários inseridos com sucesso!\n";
    }

}
