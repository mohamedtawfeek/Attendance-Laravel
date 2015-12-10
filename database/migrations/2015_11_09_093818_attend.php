<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Attend extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('attend', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day');
            $table->integer('user_id');
            $table->integer('shift_id');
            $table->string('attend_date');
            $table->string('attend_h');
            $table->integer('calc_hour');
            $table->integer('calc_min');
            $table->string('leave_h');
            $table->string('break_h');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('attend');
    }

}
