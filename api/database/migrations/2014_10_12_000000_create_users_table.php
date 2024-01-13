<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug');
            $table->boolean('is_active');
            $table->string('login')->unique();
            $table->string('password');
            $table->json('access_levels');
            $table->string('avatar');
            $table->string('name');
            $table->string('nickname');
            $table->string('email')->unique();
            $table->string('age');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('biography');
            $table->json('social_networks');
            $table->json('likes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
