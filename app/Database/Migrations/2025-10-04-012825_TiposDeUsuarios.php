<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TiposDeUsuarios extends Migration
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
            'nivel' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'id_nivel' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tiposdeusuarios');
    }

    public function down()
    {
        $this->forge->dropTable('tiposdeusuarios');
    }
}
