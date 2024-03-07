<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_calendar', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('day');
            $table->string('hour');
            $table->string('category');
            $table->unsignedBigInteger('responsible');
            $table->foreign('responsible')->references('id')->on('users');
            $table->string('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_calendar');
    }
}
