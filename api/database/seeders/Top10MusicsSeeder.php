<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Top10MusicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('top_10_musics')->insert([
                'created_at' => now(),
                'updated_at' => now(),
                'number_of_requests' => null,
                'avatar' => null,
                'name' => null,
                'anime' => null,
            ]);
        }
    }
}
