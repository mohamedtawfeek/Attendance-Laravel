<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Hours extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('first_start');
            $table->integer('first_end');
            $table->integer('second_start');
            $table->integer('second_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('hours');
    }

}
