<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListenerRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    
        Schema::create('listener_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('listener');
            $table->string('address');
            $table->string('message');
            $table->unsignedBigInteger('streaming_now');
            $table->foreign('streaming_now')->references('id')->on('streaming_now')->onDelete('cascade');
            $table->unsignedBigInteger('music');
            $table->foreign('music')->references('id')->on('musics_list');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Desabilita restrições de chave estrangeira antes de excluir a tabela
        Schema::disableForeignKeyConstraints();
        
        // Exclui a tabela 'listener_requests' se ela existir
        Schema::dropIfExists('listener_requests');
        
        // Habilita restrições de chave estrangeira após a exclusão da tabela
        Schema::enableForeignKeyConstraints();
    }
}
