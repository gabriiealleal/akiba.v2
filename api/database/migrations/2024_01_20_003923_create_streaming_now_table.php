<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamingNowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streaming_now', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug');
            $table->string('phrase');
            $table->unsignedBigInteger('show');
            $table->foreign('show')->references('id')->on('shows')->onCascade('delete');
            $table->string('type');
            $table->string('date_streaming');
            $table->string('start_streaming');
            $table->string('end_streaming');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('streaming_now');
    }
}
