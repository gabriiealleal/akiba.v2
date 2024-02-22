<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug');
            $table->unsignedBigInteger('author');
            $table->foreign('author')->references('id')->on('users')->onDelete('cascade');
            $table->string('featured_image');
            $table->string('image');
            $table->string('title');
            $table->string('content');
            $table->json('categories');
            $table->json('search_fonts');
            $table->json('reactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
