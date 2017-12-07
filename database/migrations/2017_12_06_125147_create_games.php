<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGames extends Migration
{
    private $_table = 'games';
    public function up()
    {
        Schema::create($this->_table, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('is_win');
            $table->timestamps();

            $table->foreign('user_id', 'user_has_game')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::table($this->_table, function(Blueprint $table) {
            $table->dropForeign('user_has_game');
        });

        Schema::dropIfExists($this->_table);
    }
}
