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
        // Desabilita temporariamente as restrições de chave estrangeira
        Schema::disableForeignKeyConstraints();

        // Exclui a tabela 'shows' se ela existir
        Schema::dropIfExists('shows');

        // Habilita novamente as restrições de chave estrangeira
        Schema::enableForeignKeyConstraints();
    }
}
