<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PlaylistBattleSeeder::class,
            Top10MusicsSeeder::class,
            // Adicione suas outras classes de seeders aqui...
        ]);
    }
}
