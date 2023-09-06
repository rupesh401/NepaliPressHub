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
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('title');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('status');
            $table->string('slug')->unique();
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->string('lang')->default('en');
            $table->boolean('flash_news')->default(false);
            $table->boolean('national')->default(false);
            $table->timestamps();
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
