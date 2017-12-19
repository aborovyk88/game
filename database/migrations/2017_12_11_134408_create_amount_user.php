<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmountUser extends Migration
{
    private $_table = 'users';

    public function up()
    {
        Schema::table($this->_table, function (Blueprint $table) {
            $table->float('amount')->default(1000);
        });
    }


    public function down()
    {
        Schema::table($this->_table, function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
}
