<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScorersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scorers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_id'); 
            $table->unsignedBigInteger('team_home_id'); 
            $table->unsignedBigInteger('team_away_id'); 
            $table->string('scorer'); 
            $table->timestamps();


            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('team_home_id')->references('id')->on('teams');
            $table->foreign('team_away_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scorers');
    }
}
