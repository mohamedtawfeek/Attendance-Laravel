<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Extra extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('extra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day');
            $table->integer('user_id');
            $table->string('user_shift');
            $table->string('extra_date');
            $table->integer('extra_start');
            $table->integer('extra_h');
            $table->integer('extra_m');
            $table->integer('calc_hour');
            $table->integer('calc_min');
            $table->integer('leave_h');
            $table->integer('leave_m');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('extra');
    }

}
