<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_id'); 
            $table->integer('user_id');
            $table->string('home_score')->default(0);
            $table->string('away_score')->default(0);
            $table->string('time');
            $table->date('date');
            $table->integer('minutes')->nullable();
            $table->string('status')->default('Not Started');
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games'); // Adjust the table name if necessary
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}