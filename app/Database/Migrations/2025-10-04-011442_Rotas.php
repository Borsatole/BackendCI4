<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rotas extends Migration
{
    public function up()
    {
       $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'rota' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'icone' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rotas');
    }

    public function down()
    {
        $this->forge->dropTable('rotas');
    }
}
