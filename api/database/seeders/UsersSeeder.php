<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Desabilitar restrições de chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Executar o SQL do arquivo
        $sql = File::get(database_path('seeders/sql/users.sql'));
        DB::unprepared($sql);

        // Reabilitar restrições de chave estrangeira
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}