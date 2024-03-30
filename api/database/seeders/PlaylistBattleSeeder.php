<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaylistBattleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 7; $i++) {
            DB::table('playlist_battle')->insert([
                'created_at' => now(),
                'updated_at' => now(),
                'image' => null,
            ]);
        }
    }
}
