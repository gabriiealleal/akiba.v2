<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PlaylistBattleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $sql = File::get(database_path('seeders/sql/playlist_battle.sql'));
            DB::unprepared($sql);
        }
    }
}
