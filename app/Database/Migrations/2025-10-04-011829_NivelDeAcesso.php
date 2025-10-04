<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NivelDeAcesso extends Migration
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
            'IdRota' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'IdNivel' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('niveldeacessos');
    }

    public function down()
    {
        $this->forge->dropTable('niveldeacessos');
    }
}
