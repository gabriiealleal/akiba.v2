<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTop10MusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_10_musics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('number_of_requests');
            $table->string('avatar');
            $table->string('name');
            $table->string('anime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_10_musics');
    }
}
