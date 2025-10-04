<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        echo "Populando rotas...\n";
        $this->call('RotasSeeder');

        echo "Populando tipos de usuários...\n";
        $this->call('TiposDeUsuariosSeeder');

        echo "Populando nível de acessos...\n";
        $this->call('NivelAcessoSeeder');

        echo "Banco de dados repopulado com sucesso!\n";
    }
}
