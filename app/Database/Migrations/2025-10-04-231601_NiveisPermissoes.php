<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNiveisPermissoes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'nivel_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'permissao_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'allow' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ]
        ]);

        $this->forge->addForeignKey('nivel_id', 'niveis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permissao_id', 'permissoes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addKey(['nivel_id', 'permissao_id'], true);

        $this->forge->createTable('niveis_permissoes');
    }

    public function down()
    {
        $this->forge->dropTable('niveis_permissoes');
    }
}
