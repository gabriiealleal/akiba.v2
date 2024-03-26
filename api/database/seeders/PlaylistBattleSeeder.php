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
        DB::table('playlist_battle')->insert([
            ['image' => '#'],
            ['image' => '#'],
            ['image' => '#'],
            ['image' => '#'],
            ['image' => '#'],
            ['image' => '#'],
            ['image' => '#'],
        ]);
    }
}
