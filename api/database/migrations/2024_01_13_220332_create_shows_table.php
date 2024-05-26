<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); 
            $table->string('slug'); 
            $table->string('type'); 
            $table->unsignedBigInteger('presenter'); 
            $table->foreign('presenter')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->unique(); 
            $table->string('logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('shows');
        Schema::enableForeignKeyConstraints();
    }
}
